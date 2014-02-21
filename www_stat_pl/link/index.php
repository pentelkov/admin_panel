<?php
header("Content-type: text/html;charset=utf-8");
error_reporting(E_ERROR);
$playlist    = $_GET['plid'];
$path      = "/var/ftp/main_season3/";
$ftp_path  = "/var/ftp/";
$files     = scandir($path);

$con = mysql_connect("80.243.15.51","qwe","123");
mysql_select_db("RDSDB",$con);
mysql_query("SET CHARACTER SET UTF8", $con);
mysql_query("SET NAMES UTF8", $con);

$res = mysql_query("SELECT * FROM playlist_id WHERE id='{$playlist}'");
?>
<a href="/playlist/index.php">Вернуться назад</a><br>
<center><table width="900px" border="0px">

  <tr>
    <td width='450px'>

      <!-- select name="blahs[]" id='mama' multiple size="30" onchange="document.getElementById('tx').value += options[selectedIndex].text + ttab(options[selectedIndex].text) + '|\t' + '<?php echo $ftp_path.$device; ?>/' + options[selectedIndex].value + '\n----------------------------------------------------------------------------------------------' + '\n'" -->
        <?php
        
          foreach ($files as $key => $val) {
            
            if (strlen($val) > 3 &&  $val{0} != ".") {
              echo "{$path}{$val} | <a href='getlinks.php?action=add&link1=".urlencode($path.$val)."&filename=".basename($path.$val)."&plid={$playlist}' target='second'><span style='font-size: 14pt;'>+</span></a><br>";
            }
            
          }
        
        ?>
    
    </td>
    
    
    <td width='450px'>
    
     <iframe name="second" width="700px" style="position: fixed; top: 0px; bottom: 0px; height: 100%; right: 250px;" src="getlinks.php?plid=<?=$playlist;?>"></iframe>
      
    </td>
  
  <tr>
    <td colspan="2"><input type="submit"></td>
</table>
</center>