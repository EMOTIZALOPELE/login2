#include <WiFi.h>
#include <WiFiClientSecure.h>
#include <HTTPClient.h>
#include <ESP32Servo.h>
#include <Preferences.h>
#include <AsyncTCP.h>
#include <ESPAsyncWebServer.h>
#include <ArduinoJson.h>
#include <map>
#include <vector>
#include <algorithm>
#include "time.h"

// --- CONFIGURACIÓN ---
const char* serverHost = "vecopo.ddns.net";
const char* serverPath = "/vecopo/public/dispositivos/estado/";
const char* serverSetModePath = "/vecopo/public/servos/set-mode/";
const char* serverReportStatePath = "/vecopo/public/servos/report-state/";
const int serverPort = 443;
const char* AP_SSID = "ESP32_Config_Servo";
const char* AP_PASSWORD = "password";
IPAddress AP_LOCAL_IP(192, 168, 4, 1);

// !!! --- CONFIGURACIÓN DE PRIORIDAD --- !!!
// Define qué pin corresponde a la cortina para darle prioridad de movimiento.
const int CORTINA_PIN = 4;


const char* ntpServer = "pool.ntp.org";
const long  gmtOffset_sec = -3 * 3600;
const int   daylightOffset_sec = 0;

// --- OBJETOS Y ESTRUCTURAS ---
Servo servoPin2;
Servo servoPin4; // Servo de rotación continua
Servo servoPin16;

// guarda el estado actual de cada servo ("ABIERTO" o "CERRADO")
std::map<int, String> servoLocalStates;

// Estructura para almacenar las acciones pendientes de los servos
struct ServoAction {
    int pin;
    int servoId;
    String targetState;
    String modo;
};

Servo* getServoObject(int pin) {
    switch (pin) {
        case 2: return &servoPin2;
        case 4: return &servoPin4;
        case 16: return &servoPin16;
        default: return nullptr;
    }
}

// --- VARIABLES GLOBALES ---
Preferences preferences;
AsyncWebServer server(80);
unsigned long lastServerCheck = 0;
const long serverInterval = 15000;

// --- PROTOTIPOS DE FUNCIONES ---
void connectToWiFi();
void startAPMode();
void checkServer();
void switchToAutoMode(int servoId);
void reportNewState(int servoId, String newState);
void moveServo(Servo* servo, int pin, String targetState);

void setup() {
    Serial.begin(115200);
    delay(1000);
    Serial.println("\n--- Iniciando Dispositivo Vecopo v4.5 (Prioridad de Cortina) ---");

    // Servos estándar
    servoPin2.attach(2);
    servoPin2.write(0);
    servoLocalStates[2] = "CERRADO";

    servoPin16.attach(16);
    servoPin16.write(0);
    servoLocalStates[16] = "CERRADO";

    // Servo de rotación continua (Pin 4)
    servoPin4.attach(4);
    servoPin4.write(90); // 90 es DETENIDO para servos de rotación continua
    servoLocalStates[4] = "CERRADO";


    preferences.begin("wifi-creds", false);
    String STA_ssid = preferences.getString("ssid", "");
    if (STA_ssid.length() > 0) {
        connectToWiFi();
        if(WiFi.status() == WL_CONNECTED) {
            configTime(gmtOffset_sec, daylightOffset_sec, ntpServer);
        }
    } else {
        startAPMode();
    }
}

void loop() {
    if (WiFi.status() == WL_CONNECTED) {
        if (millis() - lastServerCheck > serverInterval) {
            checkServer();
            lastServerCheck = millis();
        }
    } else if (WiFi.getMode() == WIFI_STA) {
        Serial.println("Wi-Fi desconectado. Intentando reconectar...");
        connectToWiFi();
    }
}

// =======================================================================================
// FUNCIÓN MODIFICADA PARA CONTROLAR EL MOVIMIENTO Y VELOCIDAD DE LOS SERVOS
// =======================================================================================
/**
 * @brief Mueve un servo a un estado deseado, aplicando lógica de velocidad y control de ruido.
 * @param servo Puntero al objeto Servo a mover.
 * @param pin El número de pin del servo.
 * @param targetState El estado deseado ("ABIERTO" o "CERRADO").
 */
void moveServo(Servo* servo, int pin, String targetState) {
    if (servo == nullptr) return;

    if (pin == 4) { // Lógica INVERTIDA específica para el servo de rotación continua en el pin 4
        // --- AJUSTA ESTOS VALORES A TU GUSTO ---
        
        // Define la "fuerza" del giro. Un número más alto significa un giro más rápido.
        int speedOffsetOpen = 30;  // Más alto = más rápido al abrir (ej: 90 + 30 = 120)
        int speedOffsetClose = 35; // Más bajo = más lento al cerrar (ej: 90 - 35 = 55)

        int duration = 3000; // Duración del giro en milisegundos

        // !!! IMPORTANTE PARA EL RUIDO !!!
        // Ajusta este valor hasta que el servo deje de hacer ruido cuando está parado.
        // Prueba con 91, 92, 89, 88, etc.
        int stopSpeed = 91;

        // Calculamos las velocidades para cada dirección
        int speedOpen = stopSpeed + speedOffsetOpen;
        int speedClose = stopSpeed - speedOffsetClose;

        if (targetState == "ABIERTO") { // La orden es ABRIR, pero ejecutamos la acción de CERRAR
            Serial.printf("-> [Pin %d] Orden ABRIR recibida, ejecutando Cierre por %d ms...\n", pin, duration);
            servo->write(speedClose); // Usamos la velocidad de cierre
            delay(duration);
            servo->write(stopSpeed);
            Serial.printf("-> [Pin %d] Detenido.\n", pin);
        } else if (targetState == "CERRADO") { // La orden es CERRAR, pero ejecutamos la acción de ABRIR
            Serial.printf("-> [Pin %d] Orden CERRAR recibida, ejecutando Apertura por %d ms...\n", pin, duration);
            servo->write(speedOpen); // Usamos la velocidad de apertura
            delay(duration);
            servo->write(stopSpeed);
            Serial.printf("-> [Pin %d] Detenido.\n", pin);
        }
    } else { // Lógica ESTÁNDAR para los otros servos (0-180 grados) con control de velocidad
        int currentPos = servo->read();

        // --- AJUSTA ESTE VALOR PARA CAMBIAR LA VELOCIDAD ---
        // Un valor MÁS ALTO hará que el movimiento sea MÁS LENTO. (Pausa en milisegundos)
        int servoStepDelay = 15;

        if (targetState == "ABIERTO") { // Orden ABRIR, se mueve a 180°
            Serial.printf("-> [Pin %d] Moviendo lentamente a ABIERTO (180°)...\n", pin);
            for (int pos = currentPos; pos <= 180; pos++) {
                servo->write(pos);
                delay(servoStepDelay);
            }
        } else { // Asume CERRADO, se mueve a 0°
            Serial.printf("-> [Pin %d] Moviendo lentamente a CERRADO (0°)...\n", pin);
            for (int pos = currentPos; pos >= 0; pos--) {
                servo->write(pos);
                delay(servoStepDelay);
            }
        }
    }
}


void reportNewState(int servoId, String newState) {
    WiFiClientSecure client;
    client.setInsecure();
    HTTPClient http;
    String url = "https://" + String(serverHost) + String(serverReportStatePath) + String(servoId) + "/" + newState;
    
    Serial.print("Reportando nuevo estado al servidor: ");
    Serial.println(url);

    if (http.begin(client, url)) {
        int httpCode = http.GET();
        if (httpCode == 200) {
            Serial.println("Reporte de estado exitoso.");
        } else {
            Serial.printf("Error en el reporte de estado, código: %d (%s)\n", httpCode, http.errorToString(httpCode).c_str());
        }
        http.end();
    } else {
        Serial.println("No se pudo conectar para reportar estado.");
    }
}

void switchToAutoMode(int servoId) {
    WiFiClientSecure client;
    client.setInsecure();
    HTTPClient http;
    String url = "https://" + String(serverHost) + String(serverSetModePath) + String(servoId) + "/AUTOMATICO";
    
    Serial.print("Enviando petición para cambiar a modo AUTO: ");
    Serial.println(url);

    if (http.begin(client, url)) {
        int httpCode = http.GET();
        if (httpCode == 200) {
            Serial.println("Petición de cambio de modo exitosa.");
        } else {
            Serial.printf("Error en la petición de cambio de modo, código: %d (%s)\n", httpCode, http.errorToString(httpCode).c_str());
        }
        http.end();
    } else {
        Serial.println("No se pudo conectar para cambiar modo.");
    }
}

void checkServer() {
    Serial.println("====================");
    Serial.println("🔄 Iniciando chequeo del servidor...");
    WiFiClientSecure client;
    client.setInsecure();
    HTTPClient http;
    
    String mac = WiFi.macAddress();
    mac.replace(":", "");
    mac.toLowerCase();
    String fullUrl = "https://" + String(serverHost) + String(serverPath) + mac;
    
    if (http.begin(client, fullUrl)) {
        int httpCode = http.GET();

        if (httpCode == 200) {
            String payload = http.getString();

            Serial.println("📦 JSON recibido del servidor:");
            Serial.println(payload);
            
            StaticJsonDocument<1536> doc;
            DeserializationError error = deserializeJson(doc, payload);

            if (error) {
                Serial.print(F("Error al parsear JSON del servidor: "));
                Serial.println(error.f_str());
                http.end();
                return;
            }

            // Vector para almacenar todas las acciones de movimiento necesarias
            std::vector<ServoAction> pendingActions;

            JsonObject clima = doc["clima"];
            float temperaturaActual = clima["temperatura"];
            bool estaLloviendo = clima["esta_lloviendo"];

            Serial.printf("Clima recibido: Temp=%.1f°C, Lloviendo=%s\n", temperaturaActual, estaLloviendo ? "Si" : "No");

            JsonArray servosArray = doc["servos"].as<JsonArray>();
            if (!servosArray) {
                http.end();
                return;
            }

            // --- PASO 1: RECOLECTAR TODAS LAS ACCIONES NECESARIAS ---
            for (JsonObject servoObj : servosArray) {
                int pin = servoObj["pin"];
                int servoId = servoObj["id"];
                String modo = servoObj["modo"].as<String>();
                modo.toUpperCase();
                String estadoHorario = servoObj["estado_horario"].as<String>();
                estadoHorario.toUpperCase();
                
                String accionFinal = ""; // Variable para guardar la acción final

                if (modo == "MANUAL") {
                    String estadoActualDB = servoObj["estado"].as<String>();
                    estadoActualDB.toUpperCase();
                    if (servoLocalStates[pin] != estadoActualDB) {
                        accionFinal = estadoActualDB;
                    }
                }
                else if (modo == "AUTOMATICO") {
                    if (estadoHorario == "ABIERTO" || estadoHorario == "CERRADO") {
                        if (servoLocalStates[pin] != estadoHorario) {
                            accionFinal = estadoHorario;
                        }
                    } else { // Lógica climática
                        JsonObject condiciones = servoObj["condiciones"];
                        if (!condiciones || temperaturaActual == -100.0) continue;
                        
                        String accionDeseada = servoLocalStates[pin];
                        bool ignorarLluvia = condiciones["ignorar_lluvia"];
                        float tempAbrir = condiciones.containsKey("temp_abrir") && !condiciones["temp_abrir"].isNull() ? condiciones["temp_abrir"].as<float>() : -100.0;
                        float tempCerrar = condiciones.containsKey("temp_cerrar") && !condiciones["temp_cerrar"].isNull() ? condiciones["temp_cerrar"].as<float>() : -100.0;
                        
                        if (estaLloviendo && !ignorarLluvia) accionDeseada = "CERRADO";
                        else if (tempAbrir != -100.0 && temperaturaActual >= tempAbrir) accionDeseada = "ABIERTO";
                        else if (tempCerrar != -100.0 && temperaturaActual <= tempCerrar) accionDeseada = "CERRADO";
                        
                        if (servoLocalStates[pin] != accionDeseada) {
                           accionFinal = accionDeseada;
                        }
                    }
                }
                
                // Si se determinó que se necesita una acción, la añadimos a la lista
                if (accionFinal != "") {
                    pendingActions.push_back({pin, servoId, accionFinal, modo});
                }
            }

            // --- PASO 2: PRIORIZAR Y EJECUTAR ACCIONES ---
            if (!pendingActions.empty()) {
                Serial.println("-------------------------");
                Serial.printf("▶️ Se encontraron %d acciones pendientes.\n", pendingActions.size());

                // Buscamos si la cortina necesita moverse y la ponemos al principio de la lista.
                int cortinaActionIndex = -1;
                for (int i = 0; i < pendingActions.size(); ++i) {
                    if (pendingActions[i].pin == CORTINA_PIN) {
                        cortinaActionIndex = i;
                        break;
                    }
                }

                // Si encontramos la acción de la cortina y no está ya al principio, la movemos.
                if (cortinaActionIndex > 0) {
                    Serial.printf("Priorizando la cortina (Pin %d).\n", CORTINA_PIN);
                    std::swap(pendingActions[0], pendingActions[cortinaActionIndex]);
                }

                // Ahora ejecutamos las acciones en orden (la cortina, si existe, será la primera).
                for (const auto& action : pendingActions) {
                    Servo* servoToMove = getServoObject(action.pin);
                    moveServo(servoToMove, action.pin, action.targetState);
                    servoLocalStates[action.pin] = action.targetState;

                    if (action.modo == "AUTOMATICO") {
                        reportNewState(action.servoId, action.targetState);  //para reportale el nuevo estado al servidor o sea automatico
                    }
                }
            } else {
                 Serial.println("-------------------------");
                 Serial.println("✅ No se requieren movimientos. Todo en orden.");
            }

        } else {
            Serial.printf("Error en la petición HTTP al servidor, código: %d (%s)\n", httpCode, http.errorToString(httpCode).c_str());
        }
        http.end();
    } else {
        Serial.println("No se pudo iniciar la conexión HTTP.");
    }
}

void connectToWiFi() {
    String STA_ssid = preferences.getString("ssid", "");
    String STA_password = preferences.getString("pass", "");
    WiFi.mode(WIFI_STA);
    Serial.print("Conectando a red: ");
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
        Serial.println("\nFallo la conexión.");
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
        String html = "<html><head><meta name='viewport' content='width=device-width, initial-scale=1'><style>body{font-family: Arial; text-align: center; background: #f0f0f0; margin: 20px;} h1{color: #333;} form{background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);} select, input{width: 90%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px;} input[type='submit']{background: #007bff; color: white; border: none; cursor: pointer; font-size: 16px;}</style></head><body><h1>Configurar Wi-Fi de Vecopo</h1><form action='/save' method='get'><p>Selecciona tu red:</p><select name='ssid'>";
        int n = WiFi.scanNetworks();
        for (int i = 0; i < n; ++i) { html += "<option value='" + WiFi.SSID(i) + "'>" + WiFi.SSID(i) + "</option>"; }
        html += "</select><br><input name='pass' type='password' placeholder='Contraseña'><br><br><input type='submit' value='Guardar y Conectar'></form></body></html>";
    
        request->send(200, "text/html", html);
    });

    server.on("/save", HTTP_GET, [](AsyncWebServerRequest *request){
        preferences.putString("ssid", request->getParam("ssid")->value());
        preferences.putString("pass", request->getParam("pass")->value());
        request->send(200, "text/html", "<h1>¡Guardado!</h1><p>El dispositivo se reiniciará para conectarse a tu red. Esto puede tomar unos segundos.</p>");
        delay(3000);
        ESP.restart();
    });
    server.begin();
}