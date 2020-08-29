#include <TinyGPS.h>
TinyGPS gps;
#include <SoftwareSerial.h>
SoftwareSerial ss(10, 11); //rx tx

void setup() {
  Serial.begin(9600);
  ss.begin(9600);
}

void loop() {
  smartdelay(3000);

  float enlem, boylam;
  unsigned long age;
  gps.f_get_position(&enlem, &boylam, &age);
  Serial.print(enlem, 6);
  Serial.print(","); 
  Serial.print(boylam, 6);

  int yukseklik = gps.f_altitude();
  Serial.print(","); Serial.print(yukseklik);

  int hiz = gps.f_speed_kmph();
  Serial.print(","); Serial.print(hiz);

  int yon = gps.f_course();
  Serial.print(","); Serial.print(yon);

  uint8_t uydu = gps.satellites();
  Serial.print(","); Serial.print(uydu);

  Serial.print(",");Serial.print("a");
}

static void smartdelay(unsigned long ms) {
  unsigned long start = millis();
  do {
    while (ss.available())
      gps.encode(ss.read());
  } while (millis() - start < ms);
}
