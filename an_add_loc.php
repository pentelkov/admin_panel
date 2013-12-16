<?
//header('Location: http://demo.rdsmedia.tv/an_login.php');
?>
<!DOCTYPE HTML>

<html>
 <head>
  <BASE TARGET="_parent">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF8">
  <title>RDS enter personal account</title>
<link href="http://code.google.com//apis/maps/documentation/javascript/examples/default.css" rel="stylesheet" type="text/css">
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=ru"></script>
<script>
var map;
var geocoder;
function initialize() {
geocoder = new google.maps.Geocoder();
  var mapOptions = {
    zoom: 10,
    center: new google.maps.LatLng(55.765, 37.601),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
 
  map = new google.maps.Map(document.getElementById('map-canvas'),
                                mapOptions);
//  setMarkers(map, minipc);
  google.maps.event.addListener(map, 'rightclick', function(event) {
    placeMarker(event.latLng,map);
//	alert (event.latLng.lat());
	document.getElementById('coord_x').value=event.latLng.lat();
	document.getElementById('coord_y').value=event.latLng.lng();
  });
}

function codeAddress() {
  var address = document.getElementById('searchbox').value;
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
	document.getElementById('coord_x').value=results[0].geometry.location.lat();
	document.getElementById('coord_y').value=results[0].geometry.location.lng();
	document.getElementById('address').value=document.getElementById('searchbox').value;
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

function placeMarker(location,map) {
  var marker = new google.maps.Marker({
      position: location,
      map: map
  });

google.maps.event.addListener(marker,'rightclick',function(){
	marker.setVisible(false);

});
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>
<body>
<?
session_start();
if((!$_SESSION['logged']) &&  (!$_SESSION['g_logged']))
echo "<script> window.top.location='an_login.php';</script>";
?>

<h2>Добавить локацию</h2> 

<input id="searchbox" type="textbox">
<input type="button" value="Найти" onclick="codeAddress()">
<div  id="map-canvas" style="position:absolute; top:300; width: 300px; height: 300px"></div>
<table><tr><td width=300>

</td><td>
<form action="action.php" method="post">
    <p>Название локации:
    <input type="text" name="name">
    <p>Адрес: 
    <input type="text" name="addr" id="address">
    <p>Статус:         
    <select name="status" required >
    <?
      $mysqli = new mysqli("80.243.15.51","qwe","123", "RDSDB"); 
      $mysqli->set_charset("utf8");
		$res_i=$mysqli->query("SELECT * FROM image;"); 
		$row_i=$res_i->fetch_assoc();
		while($row_i!=NULL)
		{			
			echo "<option value='".$row_i['i_status']."'>".$row_i['i_status']."</option>";
			$row_i=$res_i->fetch_assoc();
		}    
    ?>
    </select></p> 
    <p>Координаты на карте: 
    <input type="text" name="map_x" id="coord_x">
    <input type="text" name="map_y" id="coord_y">
    <p>Ближайшее метро: 
    <input type="text" name="metro">
    <p>Количество панелей: 
    <input type="text" name="num_panels">
    <p>Ссылка на карточку в Trello: 
    <input type="text" name="trello">
    <p>Интернет: 
    <input type="text" name="internet" >
    <p>Комментарий: 
    <p><textarea cols="60" name="comm"></textarea>
    <p><button formaction="an_add_l.php">Сохранить</button>
</form>
</td></tr></table>
</body>
</html>

