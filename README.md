# MultiTracker
Simple online tracking system for multiple users, optimized for paragliding pilots with Android phones
---

Android phone apps for sending coordinates (open source apps):

<strong>GPSLogger</strong> - https://play.google.com/store/apps/details?id=com.mendhak.gpslogger<br>
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

<strong>Big Brother GPS</strong> - https://play.google.com/store/apps/details?id=org.gnarf.bigbrother.gps<br>
(easy settings, sometimes does not work in background on Android 6+)

Settings of Big Brother GPS:<br>
(menu -> settings):
* Update interval (minutes): 3
* Use GPS: ☑
* URL: http://your_server.ltd/multitracker/ (slash on the end is necessary!)
* Secret: Your_Name (you will see it on the map)
* Send altitude: ☑
* (other items do not matter)
* Use HTTP response for notif.: ☑
---

 Tips for maps usage:
* on the mobile phone tap on the pilot name and let the phone open the position in navigation app
* all yesterday tracklogs are deleted by first today record

Instalation of web part to the server:
* just copy PHP/DB/PNG files to the some directory of the webserver (with PHP)

---
Demo: 
http://vitek.fedra.cz/multitracker-demo/
