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
$device    = "{DEVICE}";
$path      = "/var/ftp/main_season3/";
$ftp_path  = "/var/ftp/";
$files     = scandir($path);

$con = mysql_connect("80.243.15.51","qwe","123");
mysql_select_db("RDSDB",$con);
mysql_query("SET CHARACTER SET UTF8", $con);
mysql_query("SET NAMES UTF8", $con);


if (isset($_POST['links'])) {

$all = fopen("/var/ftp/temp/links.txt", "w+");
if (!fwrite($all, $_POST['links'])) exit("Нужно построить зиккурат.");
fclose($all);

foreach ($_POST as $key => $val) {
  
  if (stristr($key, "check_")) {
        
    $mydev = str_replace("check_","", $key);
    if (!is_dir($ftp_path.$mydev)) {
      if (!mkdir ($ftp_path.$mydev, 0777)) exit("Не могу сотворить здесь.");
    }
    
    $oldie = scandir($ftp_path.$mydev);
    foreach($oldie as $os => $oldief) {
      if (!is_dir($ftp_path.$oldief)) {
        unlink($ftp_path.$mydev."/".$oldief);
      }
    }
  
    $file = fopen("/var/ftp/{$mydev}/links.txt","w+");
    $arr = explode("\n", $_POST['links']);
  
    $i = 110;
    foreach ($arr as $str => $ar) {
    //$i++;
      if (strlen($ar) > 10 && !stristr($ar,"-------------")) {
        $i++;
        $link = explode("|", trim($ar));
        $mydev = str_replace("_","", $mydev);
        $link[1] = str_replace("{DEVICE}", $mydev, $link[1]);
        //$link[1] = str_replace("_", "", $link[1]);
        
        $info = pathinfo($link[0]);

        $link[0] = trim($link[0]);
        $link[1] = trim($link[1]);

        link(trim($link[0]),trim("/var/ftp/{$mydev}/".$i.".".$info['extension']));
  
        if (strlen(trim($link[0])) < 32) {
          fwrite($file, $link[0]."\t\t|\t"."/var/ftp/{$mydev}/".$i.".".$info['extension']."\n----------------------------------------------------------------------------------------------\n");
        } else {
          fwrite($file, $link[0]."\t|\t"."/var/ftp/{$mydev}/".$i.".".$info['extension']."\n----------------------------------------------------------------------------------------------\n");
        }
      }
    }

  fclose($file);
  
  }
  }
}


$lindktxt = fopen("/var/ftp/temp/links.txt", "a+");
$linktxt = fread($lindktxt,filesize("/var/ftp/temp/links.txt"));

  echo "Все файлы успешно заебись.";
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

<center><table width="900px" border="0px">

  <tr>
    <td width='450px'>
<form method="post">
      <select name="blahs[]" id='mama' multiple size="30" onchange="document.getElementById('tx').value += options[selectedIndex].text + ttab(options[selectedIndex].text) + '|\t' + '<?php echo $ftp_path.$device; ?>/' + options[selectedIndex].value + '\n----------------------------------------------------------------------------------------------' + '\n'">
        <?php
        
          foreach ($files as $key => $val) {
            
            if (strlen($val) > 3 &&  $val{0} != ".") {
              echo "<option value='{$val}'>{$path}{$val}</option>";
            }
            
          }
        
        ?>
      </select>
    
    </td>
    
    
    <td width='450px'>
    
      <textarea cols="70" rows="30" id="tx" name="links" style="width: 781px; height: 512px;"><?=$linktxt;?></textarea> 
      </select>
    </td>
  
  <tr>
    <td colspan="2"><input type="submit"></td>
</table>

Приложить список загрузки к следующим устройствам:<br><br>

<?php

  $res = mysql_query("SELECT name,num_h,num_4x FROM devices");
  
  while ($dev = mysql_fetch_assoc($res)) {
    
    if (strstr($dev['name'], "K"))
    echo "<div style='width: 90px; float: left;'><label><input type='checkbox' name='check_".$dev['name']."'>".$dev['name']."</label> | </div>";
    
  }

?>

</form>
</center>

<?php
fclose($lindktxt);

?>
