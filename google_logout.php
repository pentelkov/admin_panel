<?php
session_start();


if ($_GET['err']==1){
header('Location: http://demo.rdsmedia.tv/simplesaml/module.php/core/as_logout.php?AuthId=rds-sp&ReturnTo=http%3A%2F%2Fdemo.rdsmedia.tv%2Fcm_login.php?error=1');
}
else if ($_GET['err']==2){
header('Location: http://demo.rdsmedia.tv/simplesaml/module.php/core/as_logout.php?AuthId=rds-sp&ReturnTo=http%3A%2F%2Fdemo.rdsmedia.tv%2Fcl_login.php?error=2');
}
else if ($_GET['err']==3){
header('Location: http://demo.rdsmedia.tv/simplesaml/module.php/core/as_logout.php?AuthId=rds-sp&ReturnTo=http%3A%2F%2Fdemo.rdsmedia.tv%2Fan_login.php?error=3');
}
 
else if ($_GET['mode']==1){
header('Location: http://demo.rdsmedia.tv/simplesaml/module.php/core/as_logout.php?AuthId=rds-sp&ReturnTo=http%3A%2F%2Fdemo.rdsmedia.tv%2Fcm_login.php');
}
else if ($_GET['mode']==2){
header('Location: http://demo.rdsmedia.tv/simplesaml/module.php/core/as_logout.php?AuthId=rds-sp&ReturnTo=http%3A%2F%2Fdemo.rdsmedia.tv%2Fcl_login.php');
}
else 
{
$fp=fopen("logs/user/".$_SESSION['name'].".log","a");
fwrite($fp,"\n".date("d.m.Y H:i:s")." glogged out");
fclose($fp);
header('Location: http://demo.rdsmedia.tv/simplesaml/module.php/core/as_logout.php?AuthId=rds-sp&ReturnTo=http%3A%2F%2Fdemo.rdsmedia.tv%2Fan_login.php');
}

$_SESSION['login']="";
$_SESSION['g_logged']=false;

exit;
?>
