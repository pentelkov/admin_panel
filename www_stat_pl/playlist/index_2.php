<script src="http://code.jquery.com/jquery-2.0.3.min.js" type="text/javascript"></script>
	<script type="text/javascript">
    	var lastChecked = null;
 
    	$(document).ready(function() {
            	$('input:checkbox').click(function(event) {
                    	if(!lastChecked) {
                            	lastChecked = this;
                            	return;
                    	}
 
                    	if(event.shiftKey) {
                        	var start = $('input:checkbox').index(this);
                        	var end = $('input:checkbox').index(lastChecked);
 
                        	for(i=Math.min(start,end);i<=Math.max(start,end);i++) {
                                    	$('input:checkbox')[i].checked = lastChecked.checked;
                            	}
                    	}
 
                    	lastChecked = this;
            	});
    	});
	</script>

<?php
header("Content-type: text/html;charset=utf-8");
error_reporting(E_ERROR);
$ftp_path  = "/var/ftp/";
$files     = scandir($path);

$con = mysql_connect("80.243.15.51","qwe","123");
mysql_select_db("RDSDB",$con);
mysql_query("SET CHARACTER SET UTF8", $con);
mysql_query("SET NAMES UTF8", $con);


if (isset($_POST['create']) && $_POST['create'] == "true") {

  foreach ($_POST as $key => $val) {
    if (stristr($key, "check_")) {
      
      $rest_id = str_ireplace("check_","",$key);
      
      $que = mysql_query("SELECT name FROM devices WHERE owner=".$rest_id);
      while ($res = mysql_fetch_assoc($que)) {
        
        $files = scandir($ftp_path.$res['name']);
        foreach ($files as $pp => $file) {
          if (strlen($file) > 5) {
            if (!unlink($ftp_path.$res['name']."/".$file)) exit("Нужно больше золота (cant delete".$ftp_path.$res['name']."/".$file.").");
          }
        }
        
        $que2 = mysql_query("SELECT * FROM files_plist WHERE pl_id=".$_POST['id']);
        while ($res2 = mysql_fetch_assoc($que2)) {
          
          //if (!link($res2['source'], $ftp_path.$res['name']."/".$res2['dest'])) exit("Не могу сотворить здесь. (cant create ".$res2['source']."|".$ftp_path.$res['name']."/".$res2['dest'].")");
          //link($res2['source'], $ftp_path.$res['name']."/".$res2['dest']);
          
          if (!link($res2['source'], $ftp_path.$res['name']."/".$res2['dest'])) {
            
            if (file_exists($ftp_path.$res['name']."/".$res2['dest'])) {
              unlink($ftp_path.$res['name']."/".$file);
              //exit("Не могу создать линк ".$ftp_path.$res['name']."/".$file." because не могу удалить устаревший линк по этому пути.");
              link($res2['source'], $ftp_path.$res['name']."/".$res2['dest']);
            } else {
              exit("Нельзя сотворить здесь (can`t create link ".$ftp_path.$res['name']."/".$res2['dest'].").");
            }
          
          }
          
          mysql_query("UPDATE devices SET pl_id=".$res2['pl_id']." WHERE owner=".$rest_id);
          
        }
        
      }
      
    }
  }

echo "<script>alert('Линки успешно созданы, во имя Луны.');</script>";

} 
?>

<script>

  function ttab(pepepe) {
    
    if (pepepe.length < 32) {
      return "\t\t";
    } else {
      return "\t";
    }
    
  } 

</script>
<a href="/playlist/index.php">Вернуть назад</a><br>
<center>
<form action='' method='post'>
Плейлист: <b><?=$_GET['name'];?></b><br><br>
Следующие рестораны используют этот плейлист:<br>
<div>
<?php
  $r = mysql_query("SELECT * FROM devices WHERE pl_id=".$_GET['id']." GROUP BY owner");
  while ($p = mysql_fetch_assoc($r)) {
  if ($color == '#e6e3d9') $color='white';
  else $color='#e6e3d9';
  
  $vah[]=$p['owner'];
    $rest = mysql_fetch_assoc(mysql_query("SELECT * FROM locations WHERE id=".$p['owner']));
    echo "<div style='background-color: {$color}; width: 500px; float: left; text-align: left;'><label><input type='checkbox' name='check_".$rest['id']."'>".$rest['name']."</label> "; 
    
    echo "<a href='http://demo.rdsmedia.tv/an_loc_edit.php?id=".$p['owner']."' title='";
    $rq = mysql_query("SELECT * FROM devices WHERE owner=".$p['owner']);
    while ($rs = mysql_fetch_assoc($rq)) {
      echo $rs['name']." ";
    }
    echo "'>Инфо</a>";
    
    echo "</div>";
  }
  echo "<br><br>";

?>
</div>
<div style=' width: 100%; float: left; text-align: left;'><br><br><br><br>Приложить список загрузки к следующим ресторанам:</div>
<input type='submit' value='Создать линки'><br><br>
<input type='hidden' name='id' value='<?=$_GET['id'];?>'>
<input type='hidden' name='create' value='true'>
<div>
<?php

  $res = mysql_query("SELECT id,name FROM locations");
  
  while ($dev = mysql_fetch_assoc($res)) {
  
  
  if (!in_array($dev['id'],$vah)) {
  if ($color == '#e6e3d9') $color='white';
  else $color='#e6e3d9';
    echo "<div style='background-color: {$color}; width: 500px; float: left; text-align: left;'><label><input type='checkbox' name='check_".$dev['id']."'>".$dev['name']."</label> ";
    echo "<a href='http://demo.rdsmedia.tv/an_loc_edit.php?id=".$dev['id']."' title='";
    $rq = mysql_query("SELECT * FROM devices WHERE owner=".$dev['id']);
    while ($rs = mysql_fetch_assoc($rq)) {
      echo $rs['name']." ";
    }
    echo "'>Инфо</a>";
    echo "</div>";
  }
    
  }

?>

<br><br><div style="float: left; width: 1000px; padding-top: 50px; margin-bottom: 100px;"><input type='submit' value='Создать линки'></div><br><br>
</form>
</div>
</center>

<?php

?>
