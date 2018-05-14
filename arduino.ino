#include <IRremote.h>
#include "DHT.h"

IRsend irsend;          //objeto irsend (pin 9 en Arduino Mega)

#define PIN 7
DHT dht(PIN, DHT22);    //objeto dht

int led1=12;
int led2=11;


String c;

void setup() {
  pinMode(led1, OUTPUT);
  pinMode(led2, OUTPUT);
  Serial.begin(9600);      //conexion puerto Serie
  dht.begin();             //conexion con AM2302
}

void loop() {
if(Serial.available())
{
  c = Serial.readString();
  //char c = Serial.read();
  //===================== LED =====================
  if(c=="Encender led 1")
  {
    digitalWrite(led1, HIGH);
  }
  if(c=="Encender led 2")
  {
    digitalWrite(led2, HIGH);
  }
  else if(c=="Apagar led 1")
  {
    digitalWrite(led1, LOW);
  }
  else if(c=="Apagar led 2")
  {
    digitalWrite(led2, LOW);
  }
  //===================== AM2302 =====================
  else if(c == "Temperatura")
  {
    float t = dht.readTemperature();    //Leer temperatura
    //Serial.print(F("Temperatura: "));
    Serial.print("Temperatura: ");
    Serial.print(t);
    Serial.println(" C");
  }
  else if(c == "Humedad")
  {
    float h = dht.readHumidity();       //Leer humedad
    Serial.print("Humedad: ");
    Serial.print(h);
    Serial.println(" %");
  }
  //===================== IR =====================
  else if(c == "Encender television" || c == "Apagar television") 
  {
    irsend.sendRC5(0xC, 12);            //Mandar el codigo
  }
  else if(c == "Subir programa")
  {
    irsend.sendRC5(0x18, 12);
  }
  else if(c == "Bajar programa")
  {
    irsend.sendRC5(0x17, 12);
  }
  else if(c == "Subir volumen")
  {
    irsend.sendRC5(0x15, 12);
  }
  else if(c == "Bajar volumen")
  {
    irsend.sendRC5(0x14, 12);
  }
}
}
