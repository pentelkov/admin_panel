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
  $res = mysql_query("SELECT * FROM playlists WHERE device='{$device}'");

  while ($mysql = mysql_fetch_assoc($res)) {
  $del = false;
  
    for ($i = 0; $i < count($arr); $i++) {
      $arr[$i] = str_ireplace("\t", "", $arr[$i]);
      if ($arr[$i] == $mysql['source']."|".$mysql['dest']) {
        $del = true; echo $arr[$i]." ".$mysql['source']."|".$mysql['dest']; break;
      } else {
        $del = false;
      }
    }
  
    if ($del) {
      mysql_query("DELETE FROM playlists WHERE device='".$device."' AND source='".$mysql['source']."' AND dest='".$mysql['dest']."'");
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