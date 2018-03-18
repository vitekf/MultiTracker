<html>
	<head>
    <meta charset="utf-8">
		<title>Multitracker: Help</title>
	</head>
  <style type="text/css">
    body {background-color: #fff; color: #222; font-family: sans-serif;}
  </style>  
	<body>
		<p>
			<strong>Aplikace do Androidu - varianta 1:</strong> <br>
      <a href="https://play.google.com/store/apps/details?id=org.gnarf.bigbrother.gps">Big Brother GPS</a> (open source app)</p>
		<p>
			<strong>Nastavení Big Brother GPS:</strong><br /> 
      (menu -&gt; settings):<br />
			* Update interval (minutes): 3<br />
			* Use GPS: ☑<br />
			* URL: http://vitek.fedra.cz/multitracker-demo/ (lomítko na konci je nutné!)<br />
			* Secret: Jmeno (bude se zobrazovat v mapě)<br />
			* Send altitude: ☑ <br />
			* (na dalších volbách nezaleží)<br />
			* Use HTTP response for notif.: ☑
	  </p>
		<hr>
		<p>
			<strong>Aplikace do Androidu - varianta 2:</strong> <br>
      <a href="https://play.google.com/store/apps/details?id=com.mendhak.gpslogger">GPSLogger</a> (open source app)</p>
		<p>
			<strong>Nastavení GPSLogger:</strong><br /> 
      Menu -&gt; Obecné možnosti:<br />
			* Spustit po startu aplikace: ☑<br />
      Menu -&gt; Podrobnosti záznamu:<br />
			* vše vpnout, zapnout jen "Vlastní URL"<br />
			Vlastní URL:<br />
      * URL: http://vitek.fedra.cz/multitracker-demo/?latitude=%LAT&longitude=%LON&altitude=%ALT&secret=MojeJmeno<br />
			* (na dalších volbách nezaleží)<br />
			Menu -&gt; Výkon:<br />
      * Zjišťování polohy: pouze GPS<br />
			* Interval protokolování: 180<br />
	  </p>
    <hr>
    <p>
    <strong>Tipy k mapě:</strong><br />
    * v mobilu je možno při kliknutí na jméno pilota rovnou spustit navigaci (např. v aplikaci mapy.cz)<br /> 
    * všechny včerejší tracklogy  se mažou s prvním dnešním záznamem
    </p>
    
    <p>
			<strong>Co když se poloha po uzamčení telefonu neposílá? (Android 6 a vyšší - problémy s doze módem)</strong><br />
			* Xiaomi: nastavení baterie - vypnout úsporu, povolit aplikace na pozadí, případně  poladit <a href="https://www.youtube.com/watch?v=kinYsvd58NM">developer options</a><br />
			* Huawei: settings - advantage setting - battery manager: zmenit ze smart na performance<br />
			* Huawei: settings - app - big brother - buttery: keep running after screen off<br />
			* V nastavení Big Brother GPS zkus zapnout: Continous operation ☑ <br />
			* inspiruj se, jak to řeší <a href="https://support.endomondo.com/hc/en-us/articles/115000384453-Android-Disabling-App-Optimization">jinde</a>
    </p>
    <hr>
    <p>
  		<font color="silver">    
			<strong>Instalace webové části aplikace na server:</strong><br />
			* stačí stáhnout <a href="http://vitek.fedra.cz/exit/?url=http://vitek.fedra.cz/multitracker-demo/multitracker-demo.zip&name=multitracker-zdrojaky">zdrojový kód</a> a do libovolného adresáře na serveru (s podporou PHP) uložit soubory<br />
    </p>
    <p>
			<strong>Poslední úprava zdrojáků:</strong><br />
			* 18.3.2018<br />
    </p>
 
    <p>
      <strong>Instalace webové části aplikace na server pro lamky :)</strong><br />
  		* zaregistruj si na nějaký free hosting, třeba <a href="https://www.webzdarma.cz/objednavka/order-free/"><font color="silver">webzdarma.cz</font></a><br />
  		* přihlaš se do administrace hostingu <br />
  		* v menu klikni na správce souborů, smaž index.html a nahraj index.php, databaze.php a help.php<br />
		  </font>
  </p>
	</body>
</html>
