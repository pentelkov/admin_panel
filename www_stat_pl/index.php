<?php
header("Content-type: text/html;charset=utf-8");
error_reporting(E_ERROR);
$device    = $_GET['dev'];
$path      = "/var/ftp/main_season3/";
$ftp_path  = "/var/ftp/";
$files     = scandir($path);

if (!is_dir($ftp_path.$device)) {
  mkdir ($ftp_path.$device, 0777);
}

$con = mysql_connect("80.243.15.51","qwe","123");
mysql_select_db("RDSDB",$con);
mysql_query("SET CHARACTER SET UTF8", $con);
mysql_query("SET NAMES UTF8", $con);

if (isset($_POST['links'])) {
  
  $arr = explode("\n", $_POST['links']);
  
  for ($i = 0; $i < count($arr); $i++) {
    
    if (strlen($arr[$i]) > 10) {
      
      $link = explode("|", trim($arr[$i]));
      $link[0] = trim($link[0]);
      $link[1] = trim($link[1]);
      
    /*$oldie = scandir($ftp_path.$device);
      foreach($oldie as $os => $oldief) {
        if (!is_dir($ftp_path.$oldief)) {
          unlink($ftp_path.$device."/".$oldief);
        }
      }*/
      
      $res = mysql_query("SELECT * FROM playlists WHERE device='".$device."' AND source='".$link[0]."' AND dest='".$link[1]."'") or die(mysql_error());
      
      if (mysql_num_rows($res) < 1) {
        // если хардлинка нет
        mysql_query("INSERT INTO playlists (device,source,dest) VALUES('".$device."','".$link[0]."','".$link[1]."')") or die(mysql_error());
        link($link[0],$link[1]);
      }
      
    }
    
  }
  
  $ress = mysql_query("SELECT * FROM playlists WHERE device='".$device."'");
  // удаляем хардлинки
    $carr = count($arr);
  while ($delh = mysql_fetch_assoc($ress)) {
    
    
    if ($carr < 1) {
      mysql_query("DELETE FROM playlists WHERE device='".$delh['device']."' AND source='".$delh['source']."' AND dest='".$delh['dest']."'") or die(mysql_error());
      unlink($delh['dest']);
      //echo "Сюда, блядь, провалился.";
    } else {
      //echo "Провалился куда надо.";
      for ($j = 0; $j < count($arr); $j++) {
        //echo "Проверяем: Тут:'".$arr[$j]."' есть ли '".$delh['source']." | ".$delh['dest']."'<br>";
        if (strstr($arr[$j], $delh['source']) && strstr($arr[$j], $delh['dest'])) {
          //unset($arr[$j]); echo empty($arr[$j]);
          $carr = $carr - 1; //echo $carr;
          $del = false;
        } else {
          $del = true;
          //print("нет, идем дальше.<br>");
          //mysql_query("DELETE FROM playlists WHERE device='".$delh['device']."' AND source='".$delh['source']."' AND dest='".$delh['dest']."'") or die(mysql_error());
        }
      }
      
      if (!$del) echo "Элемент ".$delh['id']." удалялся";
      else echo "Элемент ".$delh['id']." ne удалялся";
    }
  $del = false;
  }

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

<center><table width="900px" border="0px">

  <tr>
    <td width='450px'>
<form method="post">
      <select name="blahs[]" id='mama' multiple size="30" onchange="document.getElementById('tx').value += options[selectedIndex].text + ttab(options[selectedIndex].text) + '|\t' + '<?php echo $ftp_path.$device; ?>/' + options[selectedIndex].value + '\n'">
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
    
      <textarea cols="70" rows="30" id="tx" name="links" style="width: 781px; height: 512px;"><?php
      
      $qq = mysql_query("SELECT * from playlists WHERE device='{$device}' ORDER BY dest");
      
      while ($rr = mysql_fetch_assoc($qq)) {
      
        if (strlen($rr['source']) < 40) {
          echo $rr['source']."\t\t|\t".$rr['dest']."\n";
        } else {
          echo $rr['source']."\t|\t".$rr['dest']."\n";
        }
      
      }
      
      ?></textarea> 
      </select>
    </td>
  
  <tr>
    <td colspan="2"><input type="submit"></td>
</form>
</table>
</center>