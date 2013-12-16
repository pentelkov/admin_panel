<!DOCTYPE HTML>
<html>
 <head>
  <BASE TARGET="_parent">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF8">
  <title>RDS enter personal account</title>
</head>
<body>
<h2>Изменить локацию</h2> 
<?

session_start();
$mysqli = new mysqli("80.243.15.51","qwe","123", "RDSDB"); 
$mysqli->set_charset("utf8");
//echo "DELETE FROM `playlists` WHERE `id` = '".$_GET['id']."'";
if($_GET['id']!=NULL) { 
$res=$mysqli->query("SELECT * FROM `locations` WHERE `id` = ".$_GET['id'].";"); 
$row=$res->fetch_assoc();} 
?>
<form action="action.php" method="post" align="left">
    <p>ID локации: <? echo $_GET['id']; ?> 
    <p>Название локации:
    <input type="text" name="name" value='<? echo $row['name']; ?>'>
    <p>Адрес: 
    <input type="text" name="addr" value="<? echo $row['addr']; ?>">
    <p>Статус:         
    <select name="status" required >
    <?
		$res_i=$mysqli->query("SELECT * FROM image;"); 
		$row_i=$res_i->fetch_assoc();
		while($row_i!=NULL)
		{
			if($row['status']==$row_i['i_status'])
			echo "<option selected value='".$row_i['i_status']."'>".$row_i['i_status']."</option>";
			else echo "<option value='".$row_i['i_status']."'>".$row_i['i_status']."</option>";
			$row_i=$res_i->fetch_assoc();
		}    
    ?>
    </select></p> 
    <p>Подключенные устройства:
    <?
		$res_d=$mysqli->query("SELECT * FROM devices WHERE owner=".$_GET['id'].";"); 
      if($res_d!=NULL)
      {
		$row_d=$res_d->fetch_assoc();
		while($row_d!=NULL)
		{
			echo "<a TARGET=\"_self\" href=an_dev_edit.php?id=".$row_d['id'].">".$row_d['name']."</a>, ";
			$row_d=$res_d->fetch_assoc();
		}   
   	} 
    ?>         
    <p>Координаты на карте: 
    <input type="text" id= "x" name="map_x" value="<? echo $row['map_x']; ?>" >
    <input type="text" name="map_y" value="<? echo $row['map_y']; ?>" >
    <p><a href="/map/index.php?id=<? echo $_GET['id']; ?>">Показать на карте</a>
    <p>Ближайшее метро: 
    <input type="text" name="metro" value="<? echo $row['metro']; ?>" >
    <p>Количество панелей: 
    <input type="text" name="num_panels" value="<? echo $row['num_panels']; ?>">
    <p>Ссылка на карточку в Trello: 
    <input type="text" name="trello" value="<? echo $row['trello']; ?>">
    <p>Интернет: 
    <input type="text" name="internet" value="<? echo $row['internet']; ?>">
    <p>Комментарий: 
    <p><textarea cols="60" name="comm"><? echo $row['comment']; ?> </textarea>
    <p><button formaction="an_loc_e.php?id=<? echo $_GET['id']; ?>">Сохранить</button>
    <button formaction="an_loc_del.php?id=<? echo $_GET['id']; ?>">Удалить</button>
</form>
</body>
</html>
