<?php
//15.51 user pass RDSDB
header("Content-type: text/html;charset=utf-8");

mysql_connect("80.243.15.51","user","pass");
mysql_select_db("RDSDB");


//if (!isset($_POST['date_from'])) {
//  $_POST['date_from'] = date("Y-m-d", strtodate("-7 days"));
//  $_POST['date_to']   = date("Y-m-d");
//}



echo "<center><h2>".$_GET['dev']."</h2><table border='2px'>";

echo "<tr style='background-color: white;'><td>Время</td>";
echo "<td>".date("d.m.Y", strtotime($_GET['date']))."</td>";




  for ($i = 0; $i < 25; $i++) {
    // получаем дату этого дня
    
    if (strlen($i) == 1) {
      $ii = "0".$i;
    } else {
      $ii = $i;
    }
    
    $que = mysql_query("SELECT * FROM logs WHERE device='".$_GET['dev']."' AND date like '".$_GET['date']." {$ii}:%'") or die(mysql_error());
    
    if (mysql_num_rows($que) > 0) {
      $res = mysql_fetch_assoc($que);
      echo "<tr><td>".date("d.m.Y H:i:s", strtotime($res['date']))."</td>";
      echo "<td style='background-color: green; text-align: center;'>YES</td>";
    } else {
      echo "<tr><td>".date("d.m.Y H:i:s", strtotime($_GET['date']." {$ii}:00:00"))."</td>";
      echo "<td style='background-color: red; text-align: center;'>NO</td>";
    }

}



echo "</table></center>";

?>
