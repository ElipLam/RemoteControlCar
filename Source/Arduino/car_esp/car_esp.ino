/*
  Author Tien Dat Huynh
  Date created 22-Apr-19 11:27PM
  TCP server power by ESP8266 WiFi
*/
#include <ESP8266WiFi.h>
#include <WiFiClient.h>

//Define variables
const char* ssid = "Tien Dat Huynh";
const char* password = "bat3glendi@abc123";

const char* host = "13.58.108.38";
const uint16_t port = 2345;

WiFiClient client;

void setup() {
  Serial.begin(115200);
  delay(10);
  //Config ESP as Access Point
  //WiFi.mode(WIFI_AP);
  //WiFi.softAP(ssid, password, 1);
  //IPAddress espIP = WiFi.softAPIP();
  //Serial.println(espIP);

  //Config ESP as Station
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
  }
  Serial.println(WiFi.localIP());

  if (!client.connect(host, port)) {
    Serial.println("CONNECT FAILED");
    delay(5000);
    return;
  }

  if (client.connected())
    client.println("ESP8266");
}

void loop() {

  while (client.available() > 0) {
    char ch = client.read();
    Serial.print(ch);
  }

  if (Serial.available())
  {
    char c = Serial.read();
    if (c == 'e')
    {
     client.println(c); 
    }
  }
}
