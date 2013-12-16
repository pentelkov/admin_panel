<?php
session_start();
$fp=fopen("logs/user/".$_SESSION['name'].".log","a");
fwrite($fp,"\n".date("d.m.Y H:i:s")." logged out");
fclose($fp);
$_SESSION['name']=""; echo $_SESSION['name'];
$_SESSION['logged']=false;
//$_COOKIE['PHPSESSID'] = "";
setcookie('PHPSESSID', '');
header('Location: /an_login.php');
exit;
?>
