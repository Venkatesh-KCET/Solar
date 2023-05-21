#include <WiFi.h>
#include <HTTPClient.h>
const char* ssid = "";
const char* password = "";
const char* apiEndpoint = "";
// Define the pin numbers for the voltage and current sensors
const int voltagePin = 34;
const int currentPin = 35;

// Define the calibration values for the current sensor
const float currentZero = 2500;   // ACS712 output voltage at zero current (in millivolts)
const float currentSensitivity = 100;   // ACS712 sensitivity (in millivolts per ampere)

// Define the number of readings to average for the current sensor
const int numReadings = 10;

void setup() {
  // Start serial communication
  Serial.begin(9600);

  // Connect to Wi-Fi network
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }

  Serial.println("Connected to WiFi");
}

void loop() {
  // Read the voltage and current sensor values
  float voltage = analogRead(voltagePin) * 0.0049;  // Convert analog reading to voltage (in volts)
  float current = 0;
  for (int i = 0; i < numReadings; i++) {
    float rawCurrent = analogRead(currentPin) * 3.3 / 4096.0 * 1000.0; // Convert analog reading to millivolts
    current += -((rawCurrent - currentZero) / currentSensitivity);  // Convert millivolts to current (in amperes)
  }
  current /= numReadings;

  // Print the sensor readings
  Serial.print("Voltage: ");
  Serial.print(voltage);
  Serial.print("V, Current: ");
  Serial.print(current);
  Serial.println("A");

  // Send the sensor readings to the API
  WiFiClient client;
  String apiRequest = apiEndpoint;
  apiRequest += "?pv=1&voltage=";
  apiRequest += voltage;
  apiRequest += "&current=";
  apiRequest += current;

  HTTPClient http;
  http.begin(client, apiRequest);
  int httpResponseCode = http.GET();
  if (httpResponseCode == HTTP_CODE_OK) {
    String response = http.getString();
    Serial.println("API response: " + response);
  }
  else {
    Serial.println("API request failed");
  }
  http.end();

  // Wait for 1 second before taking the next readings
  delay(1000);
}
