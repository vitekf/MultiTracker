<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// if url string is "?last", return time of last record (for automatic refresh)
if ($_SERVER["QUERY_STRING"] == "last"){
  $db = new PDO("sqlite:databaze.db");
  $stmt = $db->query("SELECT MAX(time) FROM data");
  $row = $stmt->fetch();
  unset($db);
  echo (int)$row[0];
  exit;
  }

//this part receive data from GET/POST and send them to the database
if (isset($_GET['latitude']) OR isset($_POST['latitude'])){

  $lat = isset($_GET["latitude"]) ? $_GET["latitude"] : (isset($_POST["latitude"]) ? $_POST["latitude"] : null);
  $lon = isset($_GET["longitude"]) ? $_GET["longitude"] : (isset($_POST["longitude"]) ? $_POST["longitude"] : null);
  $alt = isset($_GET["altitude"]) ? $_GET["altitude"] : (isset($_POST["altitude"]) ? $_POST["altitude"] : null);
  $name = isset($_GET["secret"]) ? $_GET["secret"] : (isset($_POST["secret"]) ? $_POST["secret"] : null);
  
  $lat = str_replace(',', '.', $lat);
  $lon = str_replace(',', '.', $lon);
  $name = preg_replace("/\W+/", "_", $name); 
  $time = time();
  
  //check of data validity       
  if (($lat > 0) && ($lon > 0) && ($alt > 0)){
  
    //deleting all database records, if there is any yesterday record
    $beginOfDay = strtotime("midnight", time());
    $db = new PDO("sqlite:databaze.db");
    $stmt = $db->query("SELECT MIN(time) FROM data");
    $row = $stmt->fetch();
    if ($row[0] < $beginOfDay)
      $db->exec("DELETE FROM data"); 

    //save new data to the database
    $dotaz = "INSERT INTO data (\"name\",\"time\",\"lat\",\"lon\",\"alt\") VALUES (\"$name\",$time,$lat,$lon,$alt)";
    $db->exec($dotaz);
    echo "Pozice prijata ".date("G:i")."\n";//Position recieved at ....
    }
  else   
    echo "NEULOZENO: chybi vyska! ".date("G:i"); //NOT SAVED: no elevation!
  unset($db);
  exit;
  
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="icon" href="icon.png">
    <title>MultiTracker</title>
    <style>
      html, body{
        font: 0.9em "Lucida Grande","Lucida Sans Unicode",Segoe UI,Helvetica,Arial,sans-serif;
        height: 100%;
        width: 100%;
        margin: 0px;
        padding: 0px
      }
      #map-canvas { 
        height:100%;
        position: relative;
        min-height: 150px;
      }
      #piloti { 
        border-collapse: collapse;
      } 
      a:link {
        color: grey;
      }
      #legenda {
        padding: 5px;
        background-color:white;    
        position: absolute;
        top: 0;        
      }
      #help {
        padding: 3px;
        background-color:white;    
        position: absolute;
        top: 0;
        left: 280px;
        }
    </style>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=GOOGLEAPIKEY"></script>
<script>
function initialize() {
  //initial map settings
  var myOptions;  
  if (localStorage.mapLat!=null && localStorage.mapLng!=null && localStorage.mapZoom!=null){
  //if values ar locally stored
    myOptions = { center: new google.maps.LatLng(localStorage.mapLat,localStorage.mapLng),
                  zoom: parseInt(localStorage.mapZoom),
                  mapTypeId: google.maps.MapTypeId.ROADMAP,
                  mapTypeControl: true,
                  mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                    position: google.maps.ControlPosition.TOP_RIGHT
                    },                  
                  scaleControl: true
                  };}
  else {
  //if there are no local values (first usage), use these:
    myOptions = {zoom: 7,
                  center: new google.maps.LatLng(49.65,15.62),
                  mapTypeId: google.maps.MapTypeId.ROADMAP,
                  scaleControl: true
                  };}

  //creating map object 
  var map = new google.maps.Map(document.getElementById('map-canvas'), myOptions);
  var circle ={path: google.maps.SymbolPath.CIRCLE, fillColor: 'black', fillOpacity: .4, scale: 3, strokeColor: 'white', strokeWeight: 0};

<?php
  $colors = array("red", "fuchsia", "blue", "green", "purple", "dodgerblue", "sienna", "black", "aqua", "orange", "red", "fuchsia", "blue", "green", "purple", "dodgerblue", "sienna", "black", "aqua", "orange"); 
  $count = 0; //temporary variable counting number of tracklog (each user hawe own Polyline)
  $tabulka = array(); //temporary table for caption box (white box on map with the users data)
  
  //connect to database and find user names
  $db = new PDO('sqlite:databaze.db');
  $result = $db->query('SELECT "name" FROM "data" GROUP BY "name" COLLATE NOCASE');
  foreach ($result as $row) {
    $count++; 
    
    echo "  //-------------------------------------------------------------------\n";
    echo "  //drawing user ".$row["name"]."\n";
    echo "  var points".$count." = [\n";
    
    //for each unique name of user generate his tracklog
    $result2 = $db->query('SELECT * FROM "data" WHERE "name"="'.$row['name'].'" ORDER BY "time"');
    foreach ($result2 as $row)
      echo "    new google.maps.LatLng(".$row["lat"].", ".$row["lon"]."),\n";
    echo "  ];\n";
    echo "  var tracklog".$count." = new google.maps.Polyline({\n";
    echo "  path: points".$count.",\n";
    echo "  geodesic: true,\n";
    echo "  strokeColor: \"".$colors[$count-1]."\",\n";
    echo "  strokeOpacity: 1.0,\n";
    echo "  strokeWeight: 2\n";
    echo "  });\n";
    echo "  tracklog".$count.".setMap(map);\n";  
    echo "  var marker = new google.maps.Marker({position: new google.maps.LatLng(".$row["lat"].", ".$row["lon"]."), map: map, label:\"".$row["name"]."\"});\n";
    echo "\n";
    
    //drawing dots for each position 
    //better to not use - slows down webbrowser a lot!!
    //echo "  for (i = 0; i < points".$count.".length; i++) {marker = new google.maps.Marker({ position: new google.maps.LatLng(points".$count."[i].lat(), points".$count."[i].lng()), map: map, icon: circle });}\n";
    
    //add data of currently-processed user to the table 
    $hours_ago = floor((time() - $row["time"]) / (60 * 60));
    $min_ago = floor((time() - $row["time"]) % (60 * 60) / 60);
 
    $tabulka[$count][] = $row["name"];//0
    $tabulka[$count][] = $row["lat"];//1
    $tabulka[$count][] = $row["lon"];//2
    $tabulka[$count][] = (int)$row["alt"];//3
    $tabulka[$count][] = $colors[$count-1];//4
    $tabulka[$count][] = strftime("%H:%M", $row["time"]);//5
    $tabulka[$count][] = $hours_ago."h ".$min_ago."m";//6
    $tabulka[$count][] = $count;//7 - number of line in the table 
    $tabulka[$count][] = $row["time"]*1000;//8 - unixtime format for javascript
    }
  $stmt = $db->query("SELECT MAX(time) FROM data");
  $row = $stmt->fetch();
  $last_record = (int)$row[0];  
  unset($db);          
?>

  //if zoom, or position changed, save new data to localStore
  google.maps.event.addListener(map,"zoom_changed", function() {localStorage.mapZoom = map.getZoom();});
  google.maps.event.addListener(map,"center_changed", function() {localStorage.mapLat = map.getCenter().lat();localStorage.mapLng = map.getCenter().lng();});

  //dynamic settings position of help "?" div
  var pom = document.getElementById("legenda").clientWidth;
  document.getElementById('help').style.left = pom + 5 + "px";

}//end of initialize()

function casy() { //count and change times from last stored position of user
  var now = new Date();
  
<?php
  foreach ($tabulka as $value) {
    print"  var date$value[7] = new Date($value[8]);\n";
    print"  var hours$value[7] = parseInt(Math.abs(now - date$value[7]) / (1000 * 60 * 60) );\n";
    print"  var minutes$value[7] = parseInt(Math.abs(now.getTime() - date$value[7].getTime()) / (1000 * 60) % 60);\n";
    print"  document.getElementById(\"cas$value[7]\").innerHTML = hours$value[7] + \"h \" + minutes$value[7] + \"m\";\n\n"; 
  }
?>
  }


function kontrola_novych(){ //if there are new data on the server, refresh page
  pageRequest = new XMLHttpRequest()
  pageRequest.open('GET', './?last', false);
  pageRequest.send(null);    
  last_record = pageRequest.responseText;
  last_record = last_record.replace(/(\r\n|\n|\r)/gm,""); //endings of line removing 
  if (last_record !== "<?php echo $last_record; ?>".valueOf()) {
    location.reload(); 
    } 
  }

//periodically run function
window.setInterval("kontrola_novych()", 60000);
window.setInterval("casy()", 10000);  
</script>

  </head>
  <body onload="initialize()">
    <div id="map-canvas"></div>
    <div id="legenda">
      <table id="piloti">
        <?php
        foreach ($tabulka as $value) {
          print"<tr><td><a href=geo:$value[1],$value[2]><font color=$value[4]>$value[0]</font></a></td><td align=right>$value[3] <font color=darkgray>m</font><b> ↥ </b>&nbsp;&nbsp;</td><td><font color=darkgray>🕖 $value[5] 〜 </font></td><td align=right><span id=cas$value[7]>$value[6]</span> <font color=darkgray>ago</font></td></tr>\n";
          }
        ?>
      </table> 
    </div>
    <span id="help">
      <a href="help.php" title="Nápověda - HELP">?</a>
    </span>
  </body>
</html>
