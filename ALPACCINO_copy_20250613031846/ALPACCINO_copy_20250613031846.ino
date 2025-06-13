#include <WiFi.h>
#include <HTTPClient.h>
#include <ESP32Servo.h>
#include <Preferences.h>
#include <AsyncTCP.h>
#include <ESPAsyncWebServer.h>
#include <ArduinoJson.h> // ¡Añade esta línea!

// --- CONFIGURACIÓN ---
String serverUrl = "https://vecopo.ddns.net/vecopo/public/dispositivos/estado/"; // URL corregida
const char* AP_SSID = "ESP32_Config_Servo";
const char* AP_PASSWORD = "password";
IPAddress AP_LOCAL_IP(192, 168, 4, 1);

Servo servo;
const int servoPin = 2;
String servoState = "CERRADO"; // Estado inicial del servo

Preferences preferences;
bool isStaMode = false;
AsyncWebServer server(80);

void connectToWiFi();
void startAPMode();

void setup() {
    Serial.begin(115200);
    servo.attach(servoPin);
    servo.write(0); // Asegura que el servo esté en 0 grados al inicio (cerrado)
    preferences.begin("wifi-creds", false);
    String STA_ssid = preferences.getString("ssid", "");
    String STA_password = preferences.getString("pass", "");
    if (STA_ssid.length() > 0) {
        isStaMode = true;
        connectToWiFi();
    } else {
        isStaMode = false;
        startAPMode();
    }
}

void loop() {
    if (isStaMode && WiFi.status() == WL_CONNECTED) {
        HTTPClient http;
        String mac = WiFi.macAddress();

        // --- CORRECCIÓN CLAVE ---
        mac.replace(":", ""); 
        mac.toLowerCase();
        // --------------------

        String fullUrl = serverUrl + mac;

        http.begin(fullUrl);
        int httpCode = http.GET();

        if (httpCode == 200) {
            String payload = http.getString();
            payload.trim();
            Serial.print("Payload recibido: '");
            Serial.print(payload);
            Serial.println("'");

            // --- PARSEAR JSON ---
            // Se recomienda un tamaño de Documento JSON un poco más grande de lo necesario
            // para evitar fallos si el JSON crece un poco.
            // DynamicJsonDocument doc(256); // Usa esto si necesitas más flexibilidad en RAM (no recomendado para ESP32)
            StaticJsonDocument<128> doc; // Usa esto para uso fijo y más eficiente en memoria

            DeserializationError error = deserializeJson(doc, payload); //Esta línea es la que hace la magia. 
            //Toma el payload (la cadena JSON que recibiste) y lo convierte en una estructura de datos accesible dentro del objeto

            if (error) {
                Serial.print(F("Error al parsear JSON: "));
                Serial.println(error.f_str());
            } else {
                // Extraer el estado del JSON
                const char* estadoRecibido = doc["estado"]; // Una vez parseado, podemos 
                //acceder al valor asociado con la clave "estado" (en este caso, "ABIERTO" o "CERRADO") de una manera sencilla y directa.

                if (estadoRecibido) { // Asegúrate de que la clave "estado" existe
                    String estadoStr = String(estadoRecibido); // Convertir a String para facilitar la comparación
                    Serial.print("Estado extraído: ");
                    Serial.println(estadoStr);

                    if (estadoStr == "ABIERTO" && servoState != "ABIERTO") {
                        servo.write(180);
                        servoState = "ABIERTO";
                        Serial.println("Servo movido a ABIERTO");
                    } else if (estadoStr == "CERRADO" && servoState != "CERRADO") {
                        servo.write(0);
                        servoState = "CERRADO";
                        Serial.println("Servo movido a CERRADO");
                    } else {
                        Serial.print("Estado recibido '");
                        Serial.print(estadoStr);
                        Serial.println("' es igual al estado actual del servo. No hay movimiento.");
                    }
                } else {
                    Serial.println("La clave 'estado' no se encontró en el JSON.");
                }
            }
            // --- FIN PARSEO JSON ---
        } else {
            Serial.print("Error en la petición HTTP: ");
            Serial.println(http.errorToString(httpCode).c_str());
        }
        http.end();
        delay(3000);
    } else if (isStaMode) {
        Serial.println("Wi-Fi desconectado, intentando reconectar...");
        connectToWiFi();
        delay(5000);
    } else {
        // Si no está en modo STA y no está conectado, sigue en modo AP
        // Puedes añadir algún delay o lógica aquí si es necesario para el modo AP
        delay(100); 
    }
}

void connectToWiFi() {
    String STA_ssid = preferences.getString("ssid", "");
    String STA_password = preferences.getString("pass", "");
    WiFi.mode(WIFI_STA);
    Serial.print("Conectando a: ");
    Serial.println(STA_ssid);
    WiFi.begin(STA_ssid.c_str(), STA_password.c_str());
    long startTime = millis();
    while (WiFi.status() != WL_CONNECTED && millis() - startTime < 20000) {
        delay(500);
        Serial.print(".");
    }
    if (WiFi.status() == WL_CONNECTED) {
        Serial.println("\n¡Conectado a la red Wi-Fi!");
        Serial.print("Dirección IP: "); Serial.println(WiFi.localIP());
    } else {
        Serial.println("\nFallo la conexión. Borrando credenciales y reiniciando en modo AP...");
        preferences.clear();
        delay(1000);
        ESP.restart();
    }
}

void startAPMode() {
    IPAddress AP_GATEWAY(192, 168, 4, 1);
    IPAddress AP_SUBNET(255, 255, 255, 0);
    Serial.println("Iniciando modo de configuración (AP)...");
    WiFi.softAP(AP_SSID, AP_PASSWORD);
    delay(500);
    WiFi.softAPConfig(AP_LOCAL_IP, AP_GATEWAY, AP_SUBNET);
    Serial.print("AP iniciado. Conéctate a '"); Serial.print(AP_SSID);
    Serial.print("' y ve a http://"); Serial.println(WiFi.softAPIP());

    server.on("/", HTTP_GET, [](AsyncWebServerRequest *request){
        String html = "<html><head><meta name='viewport' content='width=device-width, initial-scale=1'><style>body{font-family: Arial; text-align: center;} select, input{width: 80%; padding: 10px; margin: 10px 0;}</style></head><body><h1>Configurar Wi-Fi</h1><form action='/save' method='get'><select name='ssid'>";
        int n = WiFi.scanNetworks();
        for (int i = 0; i < n; ++i) { html += "<option value='" + WiFi.SSID(i) + "'>" + WiFi.SSID(i) + "</option>"; }
        html += "</select><br><input name='pass' type='password' placeholder='Contraseña'><br><br><input type='submit' value='Guardar y Conectar'></form></body></html>";

        request->send(200, "text/html", html);
    });
    server.on("/save", HTTP_GET, [](AsyncWebServerRequest *request){
        preferences.putString("ssid", request->getParam("ssid")->value());
        preferences.putString("pass", request->getParam("pass")->value());
        request->send(200, "text/plain", "Guardado. Reiniciando...");
        delay(1000);
        ESP.restart();
    });
    server.begin();
}