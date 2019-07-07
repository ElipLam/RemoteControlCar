# INSTRUCTION CONTROL THROUGH SERVER

**1)	Server:** 
Create Window Server with Amazon Web Services and software installation:
-	Xampp ( port 80) version 7.1.28 / PHP 7.1.28: create web server. 
 		Source in the *PHP_SERVER\dieukhienxe\\* directory, save to: *..\xampp\htdocs\dieukhienxe\\* 
-	MySQL ( port 3306) version 8.0.15 Community: 
	- The ID and Password connect to database to modified in the config.php file
	- Create database mydatabasa, then import **install.sql** file in the *PHP_SERVER* directory to create table.
-	Java SE JDK ( port 2345) version 12.0.1: TCP socket.
Run **TCPClientServer.jar** in the *TCPClientServer\dist\\* directory to create socket server.
*** Use “**ec2-13-58-108-38.us-east-2.compute.amazonaws.com.rdp**”file with password “****U!LbDta*gNgD6%?rqE)!qjHVgKDJ4Ouc**” to connect directly to the already created Server.

**2)	Android:** 
Version 8.0 (API 27) add dependencies and permission:
-	Navagation Drawer Library
-	com.github.markushi:circlebutton:1.1 Library
-	io.github.controlwear:virtualjoystick:1.9.2 Library
-	Permission Internet
	
**3)	RemoteControlCar + ESP8266:**
-	Arduino IDE version 1.8: verify and upload code ESP8266, Arduino Uno R3.
-	Install Driver: to computer and board Arduino, ESP8266 communicates with each other.
-	Upload code **car_esp.ino** in the *Arduino/car_esp/* directory for ESP8266.
Changes SSID and password before upload the code.
-	Upload the **car_arduino.ino** code in the *Arduino/car_arduino/* directory to the Arduino board.
