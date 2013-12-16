<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>RIMHD-TV enter personal account</title>
</head>
<body>
<?php
$_POST[login]=strtolower($_POST[login]);

$mysqli = new mysqli("80.243.15.5","user","pass", "idp_db");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->set_charset("unicode");
$res=$mysqli->query("SELECT * FROM users WHERE u_login = '".$_POST[login]."';");
$row=$res->fetch_assoc();

if($row[u_login]==$_POST[login] && $row[u_pass]==$_POST[pass] && $row[u_role_rds]=="admin")
{
session_start();
$_SESSION['name']=$row['u_login'];
$_SESSION['logged']=true;
$fp=fopen("logs/user/".$row['u_login'].".log","a");
fwrite($fp,"\n".date("d.m.Y H:i:s")." logged in");
fclose($fp);
header('Location: /an_panel.php?type=1');
exit;
}
else if ($row[u_role_rds]=="client_man"){
header('Location: /an_login.php?error=116');
}
else {
header('Location: /an_login.php?error=115');
exit;
}
?>
</body>
</html>
