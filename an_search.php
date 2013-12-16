<!DOCTYPE HTML>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>SEX, drugs & rock-n-roll</title>
</head>
<body>
<?
session_start();
if((!$_SESSION['logged']) &&  (!$_SESSION['g_logged']))
echo "<script> window.top.location='an_login.php';</script>";
?>
<form action="action.php" method="get" align="left">
    <p>Найти:
    <input type="text" name="query" value=''>
    <button formaction="an_search.php">Найти</button> 
    <p><input type="checkbox" checked name="loc">Искать в локациях</input> 
    <input type="checkbox" checked name="dev">Искать в устройствах</input>     
</form>
<?
session_start();
$mysqli = new mysqli("80.243.15.51","qwe","123", "RDSDB");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->set_charset("utf8");
if($_GET['query']!=NULL && $_GET['loc']==TRUE)
{
	
	echo "Результаты поиска по запросу \"".$_GET['query']."\" в локациях:";
$res=$mysqli->query("SELECT * FROM locations;");
?>
<table border="2">
<tr>
<td>#</td>
<td>Название локации</td>
<td>Адрес</td>
<td>Ближайшее метро</td>
<td>Статус</td>
<td>Интернет</td>
<td>Число панелей</td>
<td>Комментарий</td>
</tr>
<?
$i=1;
$row=$res->fetch_assoc();
while($row!=false)
{
if(
mb_strripos($row['name'],$_GET['query'],0,"utf-8")!==FALSE ||
mb_strripos($row['addr'],$_GET['query'],0,"utf-8")!==FALSE ||
mb_strripos($row['metro'],$_GET['query'],0,"utf-8")!==FALSE ||
mb_strripos($row['status'],$_GET['query'],0,"utf-8")!==FALSE ||
mb_strripos($row['internet'],$_GET['query'],0,"utf-8")!==FALSE ||
mb_strripos($row['comment'],$_GET['query'],0,"utf-8")!==FALSE ||
$row['name']==$_GET['query'] ||
$row['addr']==$_GET['query'] ||
$row['metro']==$_GET['query'] ||
$row['status']==$_GET['query'] ||
$row['internet']==$_GET['query'] ||
$row['comment']==$_GET['query'])
{
?>
<tr>
<td><? echo $i++ ; ?></td>
<td><? echo $row['name']; ?></td>
<td><? echo $row['addr']; ?></td>
<td><? echo $row['metro']; ?></td>
<td><? echo $row['status']; ?></td>
<td><? echo $row['internet']; ?></td>
<td><? echo $row['num_panels']; ?></td>
<td><textarea cols="60" name="comm"><? echo $row['comment']; ?> </textarea></td>
</tr>
<?
}
$row=$res->fetch_assoc();
}
echo "</table>";
}
?>

<? 
if($_GET['query']!=NULL && $_GET['dev']==TRUE)
{
echo "<p>Результаты поиска по запросу \"".$_GET['query']."\" в устройствах:";
$res=$mysqli->query("SELECT * FROM devices;");
?>
<table border="2">
<tr>
<td>#</td>
<td>Номер</td>
<td>Контент</td>
<td>Статус</td>
<td>Необходимые действия</td>
<td>Модель</td>
<td>Прошивка</td>
<td>Ссылка на управление</td>
<td>Комментарий</td>
</tr>
<?
$i=1;
$row=$res->fetch_assoc();
while($row!=false)
{
if(
mb_strripos($row['name'],$_GET['query'],0,"utf8")!==FALSE ||
mb_strripos($row['content'],$_GET['query'],0,"utf-8")!==FALSE ||
mb_strripos($row['status'],$_GET['query'],0,"utf-8")!==FALSE ||
mb_strripos($row['needaction'],$_GET['query'],0,"utf-8")!==FALSE ||
mb_strripos($row['model'],$_GET['query'],0,"utf-8")!==FALSE ||
mb_strripos($row['firmware'],$_GET['query'],0,"utf-8")!==FALSE ||
mb_strripos($row['weblink'],$_GET['query'],0,"utf-8")!==FALSE ||
mb_strripos($row['comment'],$_GET['query'],0,"utf-8")!==FALSE ||
$row['comment']==$_GET['query'] )
{
?>
<tr>
<td><? echo $i++ ; ?></td>
<td><? echo $row['name']; ?></td>
<td><? echo $row['content']; ?></td>
<td><? echo $row['status']; ?></td>
<td><? echo $row['needaction']; ?></td>
<td><? echo $row['model']; ?></td>
<td><? echo $row['firmware']; ?></td>
<td><? echo $row['weblink']; ?></td>
<td><textarea cols="60" name="comm"><? echo $row['comment']; ?> </textarea></td>
</tr>
<?
}
$row=$res->fetch_assoc();
}
echo "</table>";
}
?>
</body>
</html>
