# MultiTracker
Simple online tracking system for multiple users, optimized for paragliding pilots with Android phones
---

Android phone apps for sending coordinates (open source apps):

<strong>GPSLogger</strong> - https://gpslogger.app/<br>
(bit complicated settings, no problem with Doze mode on Android 6+)

Settings of GPSLogger: <br>

Menu -> General options: <br>
* Start on app launch: ☑

Menu -> Logging details:<br>
* all off, only "Log to custom URL" ☑

Custom URL:<br>
* URL: http://your_server.ltd/multitracker/?latitude=%LAT&longitude=%LON&altitude=%ALT&secret=YourName
* (another settings is not important)

Menu -> Performance:<br>
* Location providers: only GPS
* Logging interval: 180


---

 Tips for maps usage:
* on the mobile phone tap on the pilot name and let the phone open the position in navigation app
* all yesterday tracklogs are deleted by first today record

Instalation of web part to the server:
* just copy PHP/DB/PNG files to the some directory of the webserver (with PHP)

---
Demo: 

