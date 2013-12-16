<!DOCTYPE HTML>
<html>
 <head>
  <BASE TARGET="_parent">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF8">
  <title>RDS enter personal account</title>
</head>
<body>
<?
session_start();


$mysqli = new mysqli("80.243.15.51","qwe","123", "RDSDB");
$mysqli->set_charset("utf8");


$fp_user=fopen("logs/user/".$_SESSION['name'].".log","a");
fwrite($fp_user,iconv("UTF-8","WINDOWS-1251","\n".date("d.m.Y H:i:s")." created new location ".$_POST['name']));
fclose($fp_user);

$fp_loc=fopen("logs/location/".$_POST['name'].".log","a");
fwrite($fp_loc,iconv("UTF-8","WINDOWS-1251","\n".date("d.m.Y H:i:s")." location created"));
fclose($fp_loc);

$res=$mysqli->query("INSERT INTO `locations` (
`id`, 
`name`, 
`addr`,
`status`,
`map_x`,
`map_y`,
`metro`,
`num_panels`,
`trello`,
`internet`,
`comment`) 
VALUES (
NULL, 
'".$_POST['name']."', 
'".$_POST['addr']."',
'".$_POST['status']."',
'".$_POST['map_x']."', 
'".$_POST['map_y']."', 
'".$_POST['metro']."', 
'".$_POST['num_panels']."',
'".$_POST['trello']."', 
'".$_POST['internet']."', 
'".$_POST['comm']."');");
if ($_SESSION['g_logged'])
header('Location: /an_panel.php');
else if ($_SESSION['logged'])
header('Location: /an_panel.php?type=1');
exit;	
?>

</body>
</html>
