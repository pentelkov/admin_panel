<!DOCTYPE HTML>
<html>
 <head>
  <BASE TARGET="_parent">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>RDS enter personal account</title>
</head>
<body>
<?
$mysqli = new mysqli("80.243.15.51","qwe","123", "RDSDB");
$mysqli->set_charset("utf8");
$res=$mysqli->query("INSERT INTO `devices` (
`id`, 
`name`, 
`owner`, 
`model`, 
`firmware`, 
`weblink`, 
`comment`) 
VALUES (
NULL, 
'".$_POST['name']."', 
'".$_POST['owner']."', 
'".$_POST['model']."', 
'".$_POST['firmware']."', 
'".$_POST['weblink']."', 
'".$_POST['comm']."');");

$path="/server_minipc/".$_POST['name'];
mkdir($path);
header('Location: /an_panel.php');
exit;	
?>

</body>
</html>

