<!DOCTYPE HTML>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>RDS enter personal account</title>
</head>
<?
session_start();
if((!$_SESSION['logged']) &&  (!$_SESSION['g_logged']))
echo "<script> window.top.location='an_login.php';</script>";
?>
<frameset cols="50%,50%" border=1> 
<frame name="devs" src="an_devs.php">
<frame name="edit" src="an_dev_edit.php">
</frameset>

</html>
