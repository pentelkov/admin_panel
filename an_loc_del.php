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
$res=$mysqli->query("DELETE FROM `locations` WHERE id=".$_GET['id'].";");
header('Location: /an_loclist.php');
exit;	
$path="/server_minipc/".$_POST['name'];
mkdir($path);
?>

</body>
</html>
