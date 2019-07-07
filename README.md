# RemoteControlCar

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
  + Main Activity: Main screen - send message to Server to control the car, check status car,change control mode,...
- Admin dashboard: View and edit user accounts, car status
	*[dieukhienxe](http://13.58.108.38/dieukhienxe)
- Link download android application: [download](https://github.com/ElipLam/RemoteControlCar/blob/master/CarController.apk)

**3. How to install project**
- [Instruction](https://github.com/ElipLam/RemoteControlCar/tree/master/Source)
- [Arduino UNO R3](https://github.com/ElipLam/RemoteControlCar/tree/master/Source/Arduino/car_arduino)
- [ESP8266](https://github.com/ElipLam/RemoteControlCar/tree/master/Source/Arduino/car_esp)
- [Android Studio Project](https://github.com/ElipLam/RemoteControlCar/tree/master/Source/AndroidStudioProjects)
- [Server PHP](https://github.com/ElipLam/RemoteControlCar/tree/master/Source/PHP_SERVER)
- [Server TCP](https://github.com/ElipLam/RemoteControlCar/tree/master/Source/TCPClientServer)

**4. Video Demo**
[![Watch the video](https://i.imgur.com/vKb2F1B.png)](https://youtu.be/vt5fpE0bzSY)

## Control though ESP8266 WiFi Connection (Developing)
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
- [Arduino UNO R3]
- [ESP8266]
- [Android Studio Project]
