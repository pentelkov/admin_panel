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
$res=$mysqli->query("UPDATE `locations` SET 
`name`='".$_POST['name']."', 
`addr`='".$_POST['addr']."', 
`status`='".$_POST['status']."', 
`map_x`='".$_POST['map_x']."', 
`map_y`='".$_POST['map_y']."', 
`metro`='".$_POST['metro']."', 
`num_panels`='".$_POST['num_panels']."', 
`trello`='".$_POST['trello']."', 
`internet`='".$_POST['internet']."', 
`comment`='".$_POST['comm']."' 
WHERE id=".$_GET['id'].";");
header('Location: /an_loclist.php');
exit;	
$path="/server_minipc/".$_POST['name'];
mkdir($path);
?>

</body>
</html>
