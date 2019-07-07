# RemoteControlCar
Use mobile through server to control arduino car via wifi ESP8266

# RC Car
<img src="/images/ic_launcher.png" width="50%">

## Control through SERVER
### Android application send message to TCP SERVER then SERVER send this message to module WiFi on the car
**1. Prepare**
- RC Car - Controlled by Arduino UNO R3
- ESP8266 - Module WiFi
- Smartphone Android
- Server PHP for manager (login, signup, change password...)
- Server TCP to connect android application and ESP8266
- Internet connection

**2. Software**
- Android application control the car:
  + Login Activity: Login screen - authorized by PHP Server
  + Sigup Activity: Sigup screen - authorized by PHP Server
  + ChangePassword Activity: Change Password screen - authorized by PHP Server
  + Main Activity: Main screen - send message to Server to control the car
- Admin dashboard: View and edit user accounts, car status
	*[dieukhienxe](http://13.58.108.38/dieukhienxe)
- Link download android application: [download](http://13.58.108.38/dieukhienxe/download)

**3. How to install project**
- [Arduino UNO R3](https://github.com/attain7710/RemoteControlCar-Project/tree/master/Arduino/car_arduino_tcp)
- [ESP8266](https://github.com/attain7710/RemoteControlCar-Project/tree/master/Arduino/car_esp_java)
- [Android Studio Project](https://github.com/attain7710/RemoteControlCar-Project/tree/master/AndroidStudioProjects)
- [Server PHP](https://github.com/attain7710/RemoteControlCar-Project/tree/master/PHP_SERVER)
- [Server TCP](https://github.com/attain7710/RemoteControlCar-Project/tree/master/TCPClientServer)

## Control though ESP8266 WiFi Connection
### Module WiFi ESP8266 open SERVER TCP connection, android smartphone has to connect to WiFi "ESP Car" to control the car
**1. Prepare:**
- RC Car - Controlled by Arduino UNO R3
- ESP8266 - Module WiFi
- Smartphone Android

**2. Software**
- Android application control the car:
  + Login Activity: Password is "tiendat" and username is what ever you want
  + Main Activity : Use TCP socket to send message

**3. How to install project**
- [Arduino UNO R3](https://github.com/attain7710/RemoteControlCar-Project/tree/master/Arduino/car_arduino_tcp)
- [ESP8266](https://github.com/attain7710/RemoteControlCar-Project/tree/master/Arduino/car_esp_tcp)
- [Android Studio Project](https://github.com/attain7710/RemoteControlCar-Project/tree/master/AndroidStudioProjects)
