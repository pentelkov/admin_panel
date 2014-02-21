<?php
error_reporting(E_ERROR);
header("Content-type: text/html;charset=utf-8");
clearstatcache();

// получаем список папок
$folderlist = scandir("/var/ftp/");

foreach ($folderlist as $n => $folder) {
if (strlen($folder) > 3) {
  // фильтруем ненужные папки
  if (substr(sprintf('%o', fileperms("/var/ftp/".$folder)), -4) == "0755" && fileowner("/var/ftp/".$folder) == "1001") {

    // получаем файлы в папке
    $filelist = scandir("/var/ftp/".$folder);
    foreach ($filelist as $f => $file) {
    
      if (strlen($file) > 5) {
        
        if (!substr(sprintf('%o', fileperms("/var/ftp/".$folder."/".$file)), -4) == "0644" && !fileowner("/var/ftp/".$folder."/".$file) == "1001") {
         $text = $text."права на файл "."/var/ftp/".$folder."/".$file." (".substr(sprintf('%o', fileperms("/var/ftp/".$folder."/".$file)), -4).") - кривые.<br>";
        } 
        
      }
    
    }
    
  } else {
    // если на папке кривой юзер или кривые права
    $text = $text."Права на папку "."/var/ftp/".$folder." - кривые (должно 0755 владелец 1001, стоит ".substr(sprintf('%o', fileperms("/var/ftp/".$folder)), -4)." владелец ".fileowner("/var/ftp/".$folder).")<br>";
  }

}
}

if (strlen($text) > 10) {
  maill($text);
}

function get_data($smtp_conn) {
  $data="";
  while($str = fgets($smtp_conn,515)) {
    $data .= $str;
    if(substr($str,3,1) == " ") { break; }
  }
  return $data;
}

function maill($what) {

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
      $header.="Subject: Обнаружена ошибка с chmod на FTP сервере RDS\r\n";
      $header.="Content-Type: text/html;charset=utf-8\r\n";
      $header.="Content-Transfer-Encoding: 8bit\r\n\r\n";

      $text = $what."<br><br>";

      fputs($smtp_conn,"MAIL FROM: <noreply@directphone.net>\r\n");
      $code = substr(get_data($smtp_conn),0,3);
      if($code != 250) {$error = "сервер отказал в команде MAIL FROM"; print($error); }

      fputs($smtp_conn,"RCPT TO: <sth@compnet.ru>\r\n");
      $code = substr(get_data($smtp_conn),0,3);
      if($code != 250 AND $code != 251) {$error = "Сервер не принял команду RCPT TO"; print($error); }

      fputs($smtp_conn,"DATA\r\n");
      $code = substr(get_data($smtp_conn),0,3);
      if($code != 354) {$error = "сервер не принял DATA"; print($error); }

      fputs($smtp_conn,$header."\r\n".$text."\r\n.\r\n");
      $code = substr(get_data($smtp_conn),0,3);
      if($code != 250) {$error = "ошибка отправки письма"; print($error); }

      fputs($smtp_conn,"RSET\r\n");
      $code = substr(get_data($smtp_conn),0,3);
      if($code != 250) {$error = "ошибка инициализации отправки нового письма"; print($error); }

      fputs($smtp_conn,"QUIT\r\n");
      fclose($smtp_conn);

}
?>