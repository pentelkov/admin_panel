<?php
header("Content-type: text/html;charset=utf-8");
$con = mysql_connect("80.243.15.51","qwe","123");
mysql_select_db("RDSDB",$con);
mysql_query("SET CHARACTER SET UTF8", $con);
mysql_query("SET NAMES UTF8", $con);

$ddevid = mysql_fetch_assoc(mysql_query("SELECT * FROM devices WHERE name='".$_GET['dev']."'"));

echo "<a href='http://demo.rdsmedia.tv/an_dev_edit.php?id=".$ddevid['id']."' target='edit'>Назад</a><br><br>";

if (isset($_GET['dev']) && isset($_GET['date'])) {
  // http://demo.rdsmedia.tv/an_stat_dev.php?dev=K3623&date=2013-12-08
  $res = mysql_query("SELECT * FROM log_new WHERE dev='".$_GET['dev']."' AND time like '".$_GET['date']."%'") or die(mysql_error());
  while ($info = mysql_fetch_assoc($res)) {  
    switch ($info['action']) {
    case "AUTH":$color="gray"; break;
    case "COMPLETE":$color="green"; break;
    case "INCOMPLETE":$color="red"; break;
    }
  echo "<span style='color: {$color};'>".$info['comm']."</span><br>";
  }
} else {
  exit("Беда");
}

?>
