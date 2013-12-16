<!DOCTYPE HTML>
<html>
 <head>
  <BASE TARGET="_parent">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>RDS enter personal account</title>
</head>
<body>
<?php session_start();?>
<img src="logo.png" height=120 border="0" align="right" />
<h1>
<p div="" align="center">Панель администратора RDS</p>
</h1>
<?php 

//------------------------------------

echo "Welcome, ".$_SESSION['name'];  if (isset($_SESSION['g_logged']) && $_SESSION['g_logged'] == true) { echo " <img src='https://cdn1.iconfinder.com/data/icons/yooicons_set01_socialbookmarks/512/social_google_box_white.png' width='16px'>"; }
print('<br><a href="an_logout.php" target="_parent">logout</a>');

?>
</body>
</html>
