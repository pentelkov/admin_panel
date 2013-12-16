<!DOCTYPE HTML>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>RDS enter personal account</title>
</head>
<?php session_start();if($_SESSION['logged']||$_SESSION['g_logged'])
{?>
<frameset rows="170, *, 65" border=1> 
<?php if ($_GET['mode']==1) {
echo '<frame name="head" src="g_index.php">';
}
else if ($_GET['type']==1) {
echo '<frame name="head" src="an_head.php?type=1">';
}
else echo '<frame name="head" src="an_head.php">';
?>
<frameset cols="165, * " > 
<frame name="menu" src="an_menu.php">
<frame name="main" src="an_devlist.php">
</frameset> 
<frame src="footer.html">
</frameset>
<?}
else header('Location: /an_login.php');?>
</html>
