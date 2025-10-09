#include <WiFi.h>
#include <WiFiClientSecure.h>
#include <HTTPClient.h>
#include <ESP32Servo.h>
#include <Preferences.h>
#include <AsyncTCP.h>
#include <ESPAsyncWebServer.h>
#include <ArduinoJson.h>
#include <map>
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

const char* ntpServer = "pool.ntp.org";
const long  gmtOffset_sec = -3 * 3600;
const int   daylightOffset_sec = 0;

// --- OBJETOS Y ESTRUCTURAS ---
Servo servoPin2;
Servo servoPin4;
Servo servoPin16;
std::map<int, String> servoLocalStates;

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

void setup() {
    Serial.begin(115200);
    delay(1000);
    Serial.println("\n--- Iniciando Dispositivo Vecopo v3.8 (Auto-Corrección de Modo) ---");

    servoPin2.attach(2);
    servoPin2.write(0);
    servoLocalStates[2] = "CERRADO";
    servoPin4.attach(4);
    servoPin4.write(0);
    servoLocalStates[4] = "CERRADO";
    servoPin16.attach(16);
    servoPin16.write(0);
    servoLocalStates[16] = "CERRADO";

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
            Serial.println("-----------------------------");

            StaticJsonDocument<1536> doc;
            DeserializationError error = deserializeJson(doc, payload);

            if (error) {
                Serial.print(F("Error al parsear JSON del servidor: "));
                Serial.println(error.f_str());
                http.end();
                return;
            }

            JsonObject clima = doc["clima"];
            float temperaturaActual = clima["temperatura"];
            bool estaLloviendo = clima["esta_lloviendo"];

            Serial.printf("Clima recibido del servidor: Temp=%.1f°C, Lloviendo=%s\n", temperaturaActual, estaLloviendo ? "Si" : "No");

            JsonArray servosArray = doc["servos"].as<JsonArray>();
            if (!servosArray) {
                http.end();
                return;
            }

            for (JsonObject servoObj : servosArray) {
                int pin = servoObj["pin"];
                int servoId = servoObj["id"];
                Serial.printf("🔍 Analizando servo ID %d (Pin %d)\n", servoId, pin);

                Servo* currentServo = getServoObject(pin);
                if (currentServo == nullptr) continue;

                String modo = servoObj["modo"].as<String>();
                modo.toUpperCase();
                String estadoHorario = servoObj["estado_horario"].as<String>();
                estadoHorario.toUpperCase();
               
                Serial.println("-------------------------");
                Serial.printf("Procesando servo ID %d (Pin %d) | Modo: %s\n", servoId, pin, modo.c_str());

                // --- LÓGICA DE AUTO-CORRECCIÓN DE MODO ---
                if (modo == "MANUAL" && (estadoHorario == "ABIERTO" || estadoHorario == "CERRADO")) {
                    Serial.printf("Inconsistencia detectada: Modo MANUAL pero con horario activo. Solicitando cambio a AUTOMATICO para servo ID %d.\n", servoId);
                    switchToAutoMode(servoId);
                }

                if (modo == "MANUAL") {
                    long proximoEventoUTC = servoObj["proximo_evento_utc"];
                    time_t now;
                    time(&now);
                   
                    if (proximoEventoUTC > 0) {
                        long diff = proximoEventoUTC - now;
                        Serial.printf("Próximo evento en %ld segundos.\n", diff);
                        if (diff > 0 && diff <= 900) {
                            Serial.println("¡Evento cercano! Cambiando a modo AUTOMATICO.");
                            switchToAutoMode(servoId);
                        }
                    }
                   
                    String estadoActualDB = servoObj["estado"].as<String>();
                    estadoActualDB.toUpperCase();
                    if (servoLocalStates[pin] != estadoActualDB) {
                        if (estadoActualDB == "ABIERTO") currentServo->write(180); else currentServo->write(0);
                        servoLocalStates[pin] = estadoActualDB;
                        Serial.printf("-> Movido a %s por orden manual.\n", estadoActualDB.c_str());
                    } else {
                        Serial.printf("-> No se requiere movimiento. Estado actual: %s\n", servoLocalStates[pin].c_str());
                    }
                }
                else if (modo == "AUTOMATICO") {
                    if (estadoHorario == "ABIERTO" || estadoHorario == "CERRADO") {
                        if (servoLocalStates[pin] != estadoHorario) {
                            if (estadoHorario == "ABIERTO") currentServo->write(180); else currentServo->write(0);
                            servoLocalStates[pin] = estadoHorario;
                            Serial.printf("--> Movido a %s por horario.\n", estadoHorario.c_str());
                            reportNewState(servoId, estadoHorario);
                        } else {
                            Serial.printf("--> No se requiere movimiento. Estado actual por horario: %s\n", servoLocalStates[pin].c_str());
                        }
                    }
                    else {
                        // ✅ AQUÍ VA EL NUEVO CÓDGO - REEMPLAZA LO QUE HAY DENTRO DE ESTE ELSE
                        JsonObject condiciones = servoObj["condiciones"];
                        if (!condiciones || temperaturaActual == -100.0) continue;

                        String accionDeseada = servoLocalStates[pin];
                        bool ignorarLluvia = condiciones["ignorar_lluvia"];

                        // ✅ MANEJO CORRECTO DE VALORES NULOS
                        float tempAbrir = -100.0;
                        float tempCerrar = -100.0;

                        if (condiciones.containsKey("temp_abrir") && !condiciones["temp_abrir"].isNull()) {
                            tempAbrir = condiciones["temp_abrir"].as<float>();
                        }
                        if (condiciones.containsKey("temp_cerrar") && !condiciones["temp_cerrar"].isNull()) {
                            tempCerrar = condiciones["temp_cerrar"].as<float>();
                        }

                        bool tieneTempAbrir = tempAbrir != -100.0;
                        bool tieneTempCerrar = tempCerrar != -100.0;

                        Serial.printf("🌡️ Temperaturas - Abrir: %.1f°C, Cerrar: %.1f°C\n", tempAbrir, tempCerrar);
                        Serial.printf("📊 Condiciones - TieneAbrir: %d, TieneCerrar: %d\n", tieneTempAbrir, tieneTempCerrar);

                        // --- LÓGICA CLIMÁTICA ---
                        if (estaLloviendo && !ignorarLluvia) {
                            accionDeseada = "CERRADO";
                            Serial.println("--> Cerrando por lluvia");
                        }
                        else if (tieneTempAbrir && temperaturaActual >= tempAbrir) {
                            accionDeseada = "ABIERTO";
                            Serial.printf("--> Abriendo por calor (%.1f°C >= %.1f°C)\n", temperaturaActual, tempAbrir);
                        }
                        else if (tieneTempCerrar && temperaturaActual <= tempCerrar) {
                            accionDeseada = "CERRADO";
                            Serial.printf("--> Cerrando por frío (%.1f°C <= %.1f°C)\n", temperaturaActual, tempCerrar);
                        }
                        else {
                            accionDeseada = servoLocalStates[pin];
                            Serial.println("--> Sin reglas de temperatura activas. Manteniendo estado actual.");
                        }

                        if (servoLocalStates[pin] != accionDeseada) {
                            if (accionDeseada == "ABIERTO") currentServo->write(180); else currentServo->write(0);
                            servoLocalStates[pin] = accionDeseada;
                            Serial.printf("--> Movido a %s por condición climática.\n", accionDeseada.c_str());
                            reportNewState(servoId, accionDeseada);
                        } else {
                            Serial.printf("--> No se requiere movimiento. Estado actual: %s\n", servoLocalStates[pin].c_str());
                        }
                    }
                }
            }
            Serial.println("-------------------------");
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