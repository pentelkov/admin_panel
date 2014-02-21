<?php
print(date("H:i:s")."\r\n");

		// /var/log/proftpd
$file = file("/var/log/proftpd/proftpd.log");

$con = mysql_connect("80.243.15.51","qwe","123");
mysql_select_db("RDSDB",$con);
mysql_query("SET CHARACTER SET UTF8", $con);
mysql_query("SET NAMES UTF8", $con);

foreach ($file as $num => $str) {

  if (strstr($str, ": USER K") && strstr($str, ": Login successful.")) {
    // железка успешно пришла. выковыриваем её номер и время
    $info = explode(" ", $str);
    // Dec 20 16:11:13 BitTorrentSync proftpd[9099] bittorrentsync.rdsmedia.tv (pilgrim.compnet.ru[80.243.0.50]): USER K4248: Login successful.
    $herdate = date("Y-m-d H:i:s", strtotime($info[0]." ".$info[1]." ".$info[2]));
    $getinfo = mysql_query("SELECT time FROM log_new WHERE time='".$herdate."' AND action='AUTH'") or die(mysql_error());
    if (mysql_num_rows($getinfo) < 1) {
      $herid = str_replace(":","",$info[8]);
      mysql_query("INSERT INTO log_new (dev,time,action,comm,str) VALUES('".$herid."','".$herdate."','AUTH','[".date("d.m.Y H:i:s", strtotime($herdate))."] Устройство {$herid} успешно авторизовалось на сервере.','".$str."')") or die(mysql_error());
      mysql_query("UPDATE devices SET lastdate='".date("Y-m-d H:i:s", strtotime($herdate))."' WHERE name='{$herid}'") or die(mysql_error());
    }
  }

  if (strstr($str, "/var/ftp/K")) {
    // железка успешно скачала файл. выковыриваем её номер и время
    $info = explode(" ", $str);
    // Fri Dec 20 16:17:51 2013 94 pilgrim.compnet.ru 68336194 /var/ftp/K4111/001_food.1.3.mp4 b _ o r K4111 ftp 0 * c
    $herdate = date("Y-m-d H:i:s", strtotime($info[0]." ".$info[1]." ".$info[2]." ".$info[3]." ".$info[4]));
    $getinfo = mysql_query("SELECT time FROM log_new WHERE time='".$herdate."' AND action like '%MPLETE%'") or die(mysql_error());
    if (mysql_num_rows($getinfo) < 1) {
      $herid = $info[13]; //exit($info[17]);
      if (trim($info[17]) == "c") {
      	mysql_query("INSERT INTO log_new (dev,time,action,comm,str) VALUES('".$herid."','".$herdate."','COMPLETE','[".date("d.m.Y H:i:s", strtotime($herdate))."] Устройство {$herid} успешно загрузило файл ".basename($info[8]).".','".$str."')"); //$
        mysql_query("UPDATE devices SET lastdate='".date("Y-m-d H:i:s", strtotime($herdate))."' WHERE name='{$herid}'") or die(mysql_error());
      } else {
         mysql_query("INSERT INTO log_new (dev,time,action,comm,str) VALUES('".$herid."','".$herdate."','INCOMPLETE','[".date("d.m.Y H:i:s", strtotime($herdate))."] Устройству {$herid} не удалось загрузить файл ".basename($info[8]).".','".$str."')"); //$
         mysql_query("UPDATE devices SET lastdate='".date("Y-m-d H:i:s", strtotime($herdate))."' WHERE name='{$herid}'") or die(mysql_error());
      }
    }
  }

}

print(date("H:i:s")."\r\n");
?>
