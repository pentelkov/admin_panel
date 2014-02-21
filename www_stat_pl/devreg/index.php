<?php

if (!isset($_GET['dev']) || strlen($_GET['dev']) < 5 || !strstr($_GET['dev'], "K")) {
  exit("Грусть - данные введены не верно.");
}

$device = $_GET['dev'];

mkdir("/var/ftp/".$device."/", 0755);

$file = file("/etc/proftpd/ftpd.passwd");

$isset = false;

foreach ($file as $str_ => $str) {

  if (strstr($str,$device)) {
    $isset = true;
  }

}

if (!$isset) {
  $file2 = fopen("/etc/proftpd/ftpd.passwd", "a");
  
  fwrite($file2, "
".$device.":\$1\$D6pm6KV5\$ynZcHEXVLKBQDaPbT7os1.:1002:1002::/var/ftp:/bin/false");
  
  fclose($file2);
  
}

echo "мы плотнеги";
 

?>