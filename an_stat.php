<?php
//15.51 user pass RDSDB
header("Content-type: text/html;charset=utf-8");

mysql_connect("80.243.15.51","user","pass");
mysql_select_db("RDSDB");


//if (!isset($_POST['date_from'])) {
//  $_POST['date_from'] = date("Y-m-d", strtodate("-7 days"));
//  $_POST['date_to']   = date("Y-m-d");
//}


$mini = mysql_query("SELECT * FROM devices") or die(mysql_error());
echo "<center><table border='2px'>";

echo "<tr style='position: fixed; background-color: white;'><td>Устройство</td>";
for ($k = 1; $k < 15; $k++) {
echo "<td>".date("d.m.Y", strtotime("-".$k." days"))."</td>";
}

echo "<tr style='position:;'><td>Устройство</td>";
for ($k = 1; $k < 15; $k++) {
echo "<td>".date("d.m.Y", strtotime("-".$k." days"))."</td>";
}


while ($dev = mysql_fetch_assoc($mini)) {
echo "<tr><td>".$dev['name']."</td>";
  // нужно теперь проверить каждый день из последних семи
  for ($i = 1; $i < 15; $i++) {
    // получаем дату этого дня
    $dd = date("Y-m-d", strtotime("-".$i." days"));
    $que = mysql_query("SELECT * FROM logs WHERE device='".$dev['name']."' AND date like '".$dd."%'") or die(mysql_error());

    if (mysql_num_rows($que) > 0) {
      echo "<td style='background-color: green; text-align: center;'><a href='an_stat_dev.php?dev=".$dev['name']."&date=".$dd."' target='main'>YES</a></td>"; 
    } else {
      echo "<td style='background-color: red; text-align: center;'>NO</td>";
    }

}

}

echo "</table></center>";

?>
