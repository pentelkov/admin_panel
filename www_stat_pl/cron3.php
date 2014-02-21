<?php

$con = mysql_connect("80.243.15.51","qwe","123");
mysql_select_db("RDSDB",$con);
mysql_query("SET CHARACTER SET UTF8", $con);
mysql_query("SET NAMES UTF8", $con);

$res = mysql_query("SELECT name,num_h,num_4x FROM devices");

while ($info = mysql_fetch_assoc($res)) {
  $log_r = mysql_query("SELECT * FROM log_new WHERE dev='".$info['name']."' AND time > '".date("Y-m-d H:00:01")."' AND time < '".date("Y-m-d H:59:59")."'") or die(mysql_error());
  if (mysql_num_rows($log_r) < 1) {
    mysql_query("UPDATE devices SET num_h=num_h+1 WHERE name='".$info['name']."'");
    $noupdate = $noupdate.$info['name'].", ";
  } else {
    while ($log = mysql_fetch_assoc($log_r)) {
      if ($log['action'] == "INCOMPLETE") /*mysql_query("UPDATE devices SET num_4x=num_4x+1 WHERE name='".$info['name']."'");*/ $pizda2 = $pizda2.$info['name'].", ";
    }
    $update = $update.$info['name'].", ";
  }

    if ($info['num_h'] > 6) {
      $pizda = $pizda.$info['name'].", ";
      mysql_query("UPDATE devices SET num_h=0 WHERE name='".$info['name']."'");
    }

    //if ($info['num_4x'] > 150) {
    //  $pizda2 = $pizda2.$info['name'].",";
    //  mysql_query("UPDATE devices SET num_4x=0 WHERE name='".$info['name']."'");
    //}

}

function get_data($smtp_conn) {
  $data="";
  while($str = fgets($smtp_conn,515)) {
    $data .= $str;
    if(substr($str,3,1) == " ") { break; }
  }
  return $data;
}

        $smtp_conn = fsockopen("tls://smtp.gmail.com", 465, $errno, $errstr, 10);
        $data = get_data($smtp_conn);
        
        fputs($smtp_conn,"EHLO 80.243.0.50\r\n");
        $code = substr(get_data($smtp_conn),0,3);
        if($code != 250) { $error = "Ошибка приветсвия EHLO ".substr(get_data($smtp_conn),0,3)."."; exit($error); }
                
        fputs($smtp_conn,"AUTH LOGIN\r\n");
        $code = substr(get_data($smtp_conn),0,3);
        if($code != 334) { $error = "Сервер не разрешил начать авторизацию."; exit($error); }

        fputs($smtp_conn,base64_encode("is-alliance.supervisor@is-alliance.net")."\r\n");
        $code = substr(get_data($smtp_conn),0,3);
        if($code != 334) { $error = "Ошибка доступа к такому логину (is-alliance.supervisor@is-alliance.net)."; exit($error); }

        fputs($smtp_conn,base64_encode("3suhiy4r")."\r\n");
        $code = substr(get_data($smtp_conn),0,3);
        if($code != 235) { $error = "Не правильный пароль."; exit($error); }
        
      // Заголовок письма. Указывает кодировку, время, кто, кому и что отправил.
      $header="Date: ".date("D, j M Y G:i:s")." +0400\r\n";
      $header.="From: <is-alliance.supervisor@is-alliance.net>\r\n";
      $header.="Reply-To: 'DirectPhone 2.0' <noreply@directphone.net>\r\n";
      $header.="To: <artem.savateev@compnet.ru>\r\n";
      $header.="Subject: Отчет по устройствам\r\n";
      $header.="Content-Type: text/html;charset=utf-8\r\n";
      $header.="Content-Transfer-Encoding: 8bit\r\n\r\n";

      $text = "Следующие устройства отметились на сервере за последний час:<br>{$update}<br>Следующие устройства не отмечались:<br>{$noupdate}<br>Устройства не появившиеся на сервере за последние 6 часов:<br>{$pizda}<br>Устройства у которых проблемы с загрузкой файлов:<br>{$pizda2}";

      fputs($smtp_conn,"MAIL FROM: <noreply@directphone.net>\r\n");
      $code = substr(get_data($smtp_conn),0,3);
      if($code != 250) {$error = "сервер отказал в команде MAIL FROM"; exit($error); }

      fputs($smtp_conn,"RCPT TO: <sth@compnet.ru>\r\n");
      $code = substr(get_data($smtp_conn),0,3);
      if($code != 250 AND $code != 251) {$error = "Сервер не принял команду RCPT TO"; exit($error); }

      fputs($smtp_conn,"DATA\r\n");
      $code = substr(get_data($smtp_conn),0,3);
      if($code != 354) {$error = "сервер не принял DATA"; exit($error); }

      fputs($smtp_conn,$header."\r\n".$text."\r\n.\r\n");
      $code = substr(get_data($smtp_conn),0,3);
      if($code != 250) {$error = "ошибка отправки письма"; exit($error); }

      fputs($smtp_conn,"RSET\r\n");
      $code = substr(get_data($smtp_conn),0,3);
      if($code != 250) {$error = "ошибка инициализации отправки нового письма"; exit($error); }

      fputs($smtp_conn,"QUIT\r\n");
      fclose($smtp_conn);
?>
