<!DOCTYPE HTML>
<html>
 <head>
  <BASE TARGET="_parent">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>RDS enter personal account</title>
</head>
<body>
<?

session_start();


//echo "<script> alert(".$_SESSION['name'].");</script>";
$mysqli = new mysqli("80.243.15.51","qwe","123", "RDSDB");
$mysqli->set_charset("utf8");

$res_loc=$mysqli->query("SELECT * FROM locations WHERE id = ".$_POST['owner']);
$row_loc=$res_loc->fetch_assoc();

$fp_user=fopen("logs/user/".$_SESSION['name'].".log","a");
fwrite($fp_user,iconv("UTF-8","WINDOWS-1251","\n".date("d.m.Y H:i:s")." added new minipc ".$_POST['name']." to location ".$row_loc['name']));
fclose($fp_user);

$fp_dev=fopen("logs/device/".$_POST['name'].".log","a");
fwrite($fp_dev,iconv("UTF-8","WINDOWS-1251","\n".date("d.m.Y H:i:s")." device created on location ".$row_loc['name']));
fclose($fp_dev);

$fp_dev=fopen("logs/location/".$row_loc['name'].".log","a");
fwrite($fp_dev,iconv("UTF-8","WINDOWS-1251","\n".date("d.m.Y H:i:s")." added device ".$_POST['name']));
fclose($fp_dev);



$res=$mysqli->query("INSERT INTO `devices` (
`id`, 
`name`, 
`owner`, 
`lastdate`, 
`content`,
`status`,
`needaction`,
`model`,
`firmware`,
`weblink`,
`comment`) 
VALUES (
NULL, 
'".$_POST['name']."', 
'".$_POST['owner']."', 
'".$_POST['lastdate']."', 
'".$_POST['content']."',
'".$_POST['status']."',
'".$_POST['needaction']."',
'".$_POST['model']."', 
'".$_POST['firmware']."', 
'".$_POST['weblink']."', 
'".$_POST['comm']."');");

$path="/server_minipc/".$_POST['name'];
mkdir($path);
if ($_SESSION['logged'])
header('Location: /an_panel.php?type=1');
else if ($_SESSION['g_logged'])
header('Location: /an_panel.php');
exit;	
?>

</body>
</html>
