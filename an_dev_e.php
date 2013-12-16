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


$mysqli = new mysqli("80.243.15.51","qwe","123", "RDSDB");
$mysqli->set_charset("utf8");

$res_dev=$mysqli->query("SELECT * FROM devices WHERE id=".$_GET['id']);
$row_dev=$res_dev->fetch_assoc();

$res_loc=$mysqli->query("SELECT * FROM locations WHERE id=".$row_dev['owner']);
$row_loc=$res_loc->fetch_assoc();
$res_loc_new=$mysqli->query("SELECT * FROM locations WHERE id=".$_POST['owner']);
$row_loc_new=$res_loc_new->fetch_assoc();


$fp_dev=fopen("logs/device/".$_POST['name'].".log","a");
$fp_user=fopen("logs/user/".$_SESSION['name'].".log","a");
$fp_loc=fopen("logs/location/".$row_loc['name'].".log","a");
$fp_loc_new=fopen("logs/location/".$row_loc_new['name'].".log","a");

if ($row_dev['name']!=$_POST['name']){
fwrite($fp_user,iconv("UTF-8","WINDOWS-1251","\n".date("d.m.Y H:i:s")." changed name of device from ".$row_dev['name']." to ".$_POST['name']));
fwrite($fp_dev,iconv("UTF-8","WINDOWS-1251","\n".date("d.m.Y H:i:s")." changed name from ".$row_dev['name']." to ".$_POST['name']." by ".$_SESSION['name']));
}
if ($row_dev['owner']!=$_POST['owner']){
fwrite($fp_user,iconv("UTF-8","WINDOWS-1251","\n".date("d.m.Y H:i:s")." changed location of device ".$_POST['name']." from ".$row_loc['name']." to ".$row_loc_new['name']));
fwrite($fp_dev,iconv("UTF-8","WINDOWS-1251","\n".date("d.m.Y H:i:s")." changed location from ".$row_loc['name']." to ".$row_loc_new['name']." by ".$_SESSION['name']));
fwrite($fp_loc,iconv("UTF-8","WINDOWS-1251","\n".date("d.m.Y H:i:s")." device ".$_POST['name']." moved from here to ".$row_loc_new['name']." by ".$_SESSION['name']));
fwrite($fp_loc_new,iconv("UTF-8","WINDOWS-1251","\n".date("d.m.Y H:i:s")." device ".$_POST['name']." moved here from ".$row_loc['name']." by ".$_SESSION['name']));
}
if ($row_dev['lastdate']!=$_POST['lastdate']){
fwrite($fp_user,iconv("UTF-8","WINDOWS-1251","\n".date("d.m.Y H:i:s")." changed lastdate of device ".$row_dev['name']." from ".$row_dev['lastdate']." to ".$_POST['lastdate']));
fwrite($fp_dev,iconv("UTF-8","WINDOWS-1251","\n".date("d.m.Y H:i:s")." changed lastdate from ".$row_dev['lastdate']." to ".$_POST['lastdate']." by ".$_SESSION['name']));
}
if ($row_dev['content']!=$_POST['content']){
fwrite($fp_user,iconv("UTF-8","WINDOWS-1251",
"\n".date("d.m.Y H:i:s")." changed content of device ".$row_dev['name']." from ".$row_dev['content']." to ".$_POST['content']));
fwrite($fp_dev,iconv("UTF-8","WINDOWS-1251",
"\n".date("d.m.Y H:i:s")." changed lastdate from ".$row_dev['content']." to ".$_POST['content']." by ".$_SESSION['name']));
}
if ($row_dev['status']!=$_POST['status']){
fwrite($fp_user,iconv("UTF-8","WINDOWS-1251",
"\n".date("d.m.Y H:i:s")." changed status of device ".$row_dev['name']." from ".$row_dev['status']." to ".$_POST['status']));
fwrite($fp_dev,iconv("UTF-8","WINDOWS-1251",
"\n".date("d.m.Y H:i:s")." changed status from ".$row_dev['status']." to ".$_POST['status']." by ".$_SESSION['name']));
}
if ($row_dev['needaction']!=$_POST['needaction']){
fwrite($fp_user,iconv("UTF-8","WINDOWS-1251",
"\n".date("d.m.Y H:i:s")." changed needaction of device ".$row_dev['name']." from ".$row_dev['needaction']." to ".$_POST['needaction']));
fwrite($fp_dev,iconv("UTF-8","WINDOWS-1251",
"\n".date("d.m.Y H:i:s")." changed needaction from ".$row_dev['needaction']." to ".$_POST['needaction']." by ".$_SESSION['name']));
}
if ($row_dev['model']!=$_POST['model']){
fwrite($fp_user,iconv("UTF-8","WINDOWS-1251",
"\n".date("d.m.Y H:i:s")." changed model of device ".$row_dev['name']." from ".$row_dev['model']." to ".$_POST['model']));
fwrite($fp_dev,iconv("UTF-8","WINDOWS-1251",
"\n".date("d.m.Y H:i:s")." changed model from ".$row_dev['model']." to ".$_POST['model']." by ".$_SESSION['name']));
}
if ($row_dev['firmware']!=$_POST['firmware']){
fwrite($fp_user,iconv("UTF-8","WINDOWS-1251",
"\n".date("d.m.Y H:i:s")." changed firmware of device ".$row_dev['name']." from ".$row_dev['firmware']." to ".$_POST['firmware']));
fwrite($fp_dev,iconv("UTF-8","WINDOWS-1251",
"\n".date("d.m.Y H:i:s")." changed firmware from ".$row_dev['firmware']." to ".$_POST['firmware']." by ".$_SESSION['name']));
}
if ($row_dev['weblink']!=$_POST['weblink']){
fwrite($fp_user,iconv("UTF-8","WINDOWS-1251",
"\n".date("d.m.Y H:i:s")." changed weblink of device ".$row_dev['name']." from ".$row_dev['weblink']." to ".$_POST['weblink']));
fwrite($fp_dev,iconv("UTF-8","WINDOWS-1251",
"\n".date("d.m.Y H:i:s")." changed weblink from ".$row_dev['weblink']." to ".$_POST['weblink']." by ".$_SESSION['name']));
}
if ($row_dev['comment']!=$_POST['comm']){
fwrite($fp_user,iconv("UTF-8","WINDOWS-1251",
"\n".date("d.m.Y H:i:s")." changed comment of device ".$row_dev['name']." from ".$row_dev['comment']." to ".$_POST['comm']));
fwrite($fp_dev,iconv("UTF-8","WINDOWS-1251",
"\n".date("d.m.Y H:i:s")." changed comment from ".$row_dev['comment']." to ".$_POST['comm']." by ".$_SESSION['name']));
}

fclose($fp_dev);
fclose($fp_user);
fclose($fp_loc);
fclose($fp_loc_new);

$res=$mysqli->query("UPDATE `devices` SET 
`name`='".$_POST['name']."', 
`owner`='".$_POST['owner']."',
`lastdate`='".$_POST['lastdate']."', 
`content`='".$_POST['content']."',
`status`='".$_POST['status']."',
`needaction`='".$_POST['needaction']."',
`model`='".$_POST['model']."', 
`firmware`='".$_POST['firmware']."', 
`weblink`='".$_POST['weblink']."',
`comment`='".$_POST['comm']."' 
WHERE id=".$_GET['id'].";");

$mysqli->query("UPDATE ips SET dev_id=".$_GET[id]." WHERE id=".$_POST['vpn_id']);

header('Location: /an_devlist.php?id='.$_GET['id']);
exit;	
$path="/server_minipc/".$_POST['name'];
mkdir($path);
?>

</body>
</html>
