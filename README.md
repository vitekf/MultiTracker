# MultiTracker
Simple online tracking system for multiple users, optimized for paragliding pilots with Android phones
---

Android phone apps for sending coordinates (open source apps):<br>
<strong>Big Brother GPS</strong> - https://play.google.com/store/apps/details?id=org.gnarf.bigbrother.gps<br>
<strong>GPSLogger</strong> - https://play.google.com/store/apps/details?id=com.mendhak.gpslogger

Settings of Big Brother GPS:
(menu -> settings):
* Update interval (minutes): 3
* Use GPS: ☑
* URL: http://your_server.ltd/multitracker/ (slash on the end is necessary!)
* Secret: Your_Name (you will see it on the map)
* Send altitude: ☑
* (other items do not matter)
* Use HTTP response for notif.: ☑

 Tips for maps usage:
* on the mobile phone tap on the pilot name and let the phone open the position in navigation app
* all yesterday tracklogs are deleted by first today record

Instalation of web part to the server:
* just copy PHP/DB/PNG files to the some directory of the webserver (with PHP)

---
Demo: 
http://vitek.fedra.cz/multitracker-demo/
