<!DOCTYPE HTML>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>SEX, drugs & rock-n-roll</title>
</head>
<body>

<h2>Список устройств</h2> 
<table border="2">
<tr>
<td>#</td>
<td><a href="an_devs.php?order=name">Имя устройства</a></td>
<td><a href="an_devs.php?order=owner">Название локации</a></td>
<td><a href="an_devs.php?order=status">Статус</a></td>
<td><a href="an_devs.php?order=needaction">Необходимые действия</a></td>
</tr>
<?

/*require_once('KalturaAPI/KalturaClient.php');
$partnerId = 105;
$config = new KalturaConfiguration($partnerId);
$config->serviceUrl = 'http://console.rdsmedia.tv/';
$client = new KalturaClient($config);
$secret = null;
$userId = null;
$type = null;
$partnerId = null;
$expiry = null;
$privileges = null;
$secret = 'ae192d131f231a80a2cdd1ccda235466';
$results = $client->session->start($secret, $userId, $type, $partnerId, $expiry, $privileges);
$id = null;
$version = null;
$client->setKs($results);*/

session_start();

$mysqli = new mysqli("80.243.15.51","qwe","123", "RDSDB");
$mysqli->set_charset("utf8");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if ($_GET['order']) $res=$mysqli->query("SELECT * FROM devices ORDER BY ".$_GET['order']); 
else $res=$mysqli->query("SELECT * FROM devices ORDER BY name");
$row=$res->fetch_assoc();

$i=1;
while($row!=false)
{
?>
<tr>
<td><?=$i;?></td>
<td><a target="edit" href="an_dev_edit.php?id=<? echo $row['id'];?>" ><? echo $row['name']; ?></a></td>
<td><? 
$c_res=$mysqli->query("SELECT * FROM locations WHERE id='".$row['owner']."';");
$c_row=$c_res->fetch_assoc();
if($c_row!=false) echo $c_row['name'];
 ?></td>
<td><? echo $row['status'];?></td>
<td><? echo $row['needaction'];?></td>
</tr>
<? 
$row=$res->fetch_assoc();
$i++;} ?>
</table>
</body>
</html>
