<?php
header("Content-type: text/html;charset=utf-8");
error_reporting(E_ALL);
$playlist    = $_GET['plid'];

$con = mysql_connect("80.243.15.51","qwe","123");
mysql_select_db("RDSDB",$con);
mysql_query("SET CHARACTER SET UTF8", $con);
mysql_query("SET NAMES UTF8", $con);

if (isset($_GET['action']) && $_GET['action'] == "add") {
  
  if (mysql_num_rows(mysql_query("SELECT * FROM files_plist WHERE pl_id=".$_GET['plid']." AND source='".$_GET['link1']."' AND dest='".$_GET['filename']."'")) > 0) {
    // exists
    echo "Добавление неудачно - такой файл уже существует.<br><br>";
  } else {
    mysql_query("INSERT INTO files_plist (pl_id,source,dest) VALUES (".$_GET['plid'].",'".$_GET['link1']."','".$_GET['filename']."')") or die(mysql_error());
  }
  
}

if (isset($_GET['action']) && $_GET['action'] == "edit") {
  
    mysql_query("UPDATE files_plist SET source='".$_GET['source']."', dest='".$_GET['dest']."' WHERE id=".$_GET['id']) or die(mysql_error());
  
}

if (isset($_GET['action']) && $_GET['action'] == "delete") {
  
    mysql_query("DELETE FROM files_plist WHERE id=".$_GET['id']) or die(mysql_error());
  
}


$que = mysql_query("SELECT * FROM files_plist WHERE pl_id='{$playlist}' ORDER BY dest");
while ($res = mysql_fetch_assoc($que)) {

echo "<form target='second' method='get' action='getlinks.php'>";
  echo "<input type='text' value='".$res['source']."' size='40' name='source'> | <input type='text' value='".$res['dest']."' size='40' name='dest'>&nbsp;

        <input type='hidden' name='id' value='".$res['id']."'>
        <input type='hidden' name='plid' value='{$playlist}'>
        <input type='hidden' name='action' value='edit'>
        <input type='image' src='http://profile.directphone.net/templates/images/edit.png'>&nbsp;
        
        
        <a href='getlinks.php?action=delete&id=".$res['id']."&plid={$playlist}' target='second'><img src='http://profile.directphone.net/templates/images/delete.png'></a></br>";
echo "</form>";

}


?>