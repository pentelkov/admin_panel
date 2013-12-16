<!DOCTYPE HTML>
<html>
 <head>
  <BASE TARGET="_parent">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>RDS enter personal account</title>
</head>
<body>
<h2>Изменить устройство</h2> 
<?

session_start();


$mysqli = new mysqli("80.243.15.51","qwe","123", "RDSDB"); 
$mysqli->set_charset("utf8");
//echo "DELETE FROM `playlists` WHERE `id` = '".$_GET['id']."'";
if($_GET['id']!=NULL) { 
$res=$mysqli->query("SELECT * FROM `devices` WHERE `id` = ".$_GET['id'].";"); 
$row=$res->fetch_assoc();} 

$res2 = $mysqli->query("SELECT * FROM ips WHERE dev_id=".$_GET['id']);
if ($res2->num_rows < 1) {
   $res2 = $mysqli->query("SELECT * FROM ips WHERE dev_id=0");
   $non = 1;
}

if (!stristr($row['weblink'],"@")) {
  $row['weblink'] = str_ireplace("http://","http://adminpc:calgogminipc@",$row['weblink']);
}
?>
<img src=<?echo $row['weblink']."/screenshot.jpg"?> alt="Screen" height="300" ></img>
<form action="action.php" method="post" align="left">
    <p>ID устройства: <? echo $_GET['id']; ?> 
    <p>Инвентарный номер устройства:
    <input type="text" name="name" value="<? echo $row['name']; ?>">
    <p>Локация: 
    <select name="owner" required >
    <?
    $res_loc=$mysqli->query("SELECT * FROM locations ORDER BY name;");
    $row_loc=$res_loc->fetch_assoc();
    while($row_loc!=false) {
    if($row_loc['id']==$row['owner'])	
    echo "<option selected value=\"".$row_loc['id']."\">".$row_loc['name']."</option>";
    else
    echo "<option value=\"".$row_loc['id']."\">".$row_loc['name']."</option>";
    $row_loc=$res_loc->fetch_assoc();    
    }
    ?>
    </select></p>
    <p>Дата и время последнего обращения: 
    <input type="text" name="lastdate" value="<?echo $row['lastdate']; ?>" >
    <p>Версия контента: 
    <input type="text" name="content" value="<? echo $row['content']; ?>" > 
    <p>Статус:         
    <select name="status" required >
    <option <? if($row['status']=="Не установлено") echo "selected"; ?> value="Не установлено">Не установлено</option>
    <option <? if($row['status']=="В работе") echo "selected"; ?> value="В работе">В работе</option>
    <option <? if($row['status']=="Не доступен Webkey") echo "selected"; ?> value="Не доступен Webkey">Не доступен Webkey</option>
    <option <? if($row['status']=="Не обновляется") echo "selected"; ?> value="Не обновляется">Не обновляется</option>
    <option <? if($row['status']=="Нет сети (причина не известна)") echo "selected"; ?> value="Нет сети (причина не известна)">Нет сети (причина не известна)</option>
    <option <? if($row['status']=="Контент устарел") echo "selected"; ?> value="Контент устарел">Контент устарел</option>
    </select></p> 
    <p>Необходимые действия:         
    <select name="needaction" required >
    <option <? if($row['needaction']=="Не требуются") echo "selected"; ?> value="Не требуются">Не требуются</option>
    <option <? if($row['needaction']=="Удаленная диагностика") echo "selected"; ?> value="Удаленная диагностика">Удаленная диагностика</option>
    <option <? if($row['needaction']=="Связаться с администратором локации") echo "selected"; ?> value="Связаться с администратором локации">Связаться с администратором локации</option>
    <option <? if($row['needaction']=="Требуется выезд специалиста") echo "selected"; ?> value="Требуется выезд специалиста">Требуется выезд специалиста</option>
    <option <? if($row['needaction']=="Обновить контент") echo "selected"; ?> value="Обновить контент">Обновить контент</option>
    </select></p>             
    <p>Модель: 
    <input type="text" name="model" value="<? echo $row['model']; ?>" >
    <p>Прошивка: 
    <input type="text" name="firmware" value="<? echo $row['firmware']; ?>" >
    <p>Ссылка на управление: 
    <input type="text" name="weblink" value="<? echo $row['weblink']; ?>"> <a href="<? echo $row['weblink']; ?>" target="_blank">Открыть</a>
    <p>Логин VPN: 
    
        <?php
	if ($non == 1) {
	echo "<select name='vpn_id'>";
	echo "<option>Выберите логин VPN</option>";
	
	while ($row2 = $res2->fetch_assoc()) {
		echo "<option name='vpn_id' value='".$row2['id']."'>".$row2['login']."</option>";
	}
	echo "</select>";
	} 

	if ($non != 1) {
		$row2 = $res2->fetch_assoc();
		echo $row2['login']." (".$row2['ip_adr'].")";
	}

 	?>
    
    </p>
    <p>Комментарий: 
    <p><textarea cols="60" name="comm"><? echo $row['comment']; ?></textarea>
    <p><a href="http://adminpc:calgogminipc@androidwebkey.com/<?=$row['name']?>/files/mnt/external_sd/" target="_blank">Открыть список файлов в отдельном окне</a>
    <p><button formaction="an_dev_e.php?id=<? echo $_GET['id']; ?>">Сохранить</button>
</form>
</body>
</html>
