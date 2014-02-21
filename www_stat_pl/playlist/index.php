<?php
error_reporting(E_ERROR);

$con = mysql_connect("80.243.15.51","qwe","123");
mysql_select_db("RDSDB",$con);
mysql_query("SET CHARACTER SET UTF8", $con);
mysql_query("SET NAMES UTF8", $con);

if (isset($_POST['action']) && $_POST['action'] == "create") {
  mysql_query("INSERT INTO playlist_id (name) VALUES ('".$_POST['name']."')");
}

if (isset($_POST['action']) && $_POST['action'] == "edit") {
  mysql_query("UPDATE playlist_id SET name='".$_POST['name']."' WHERE id=".$_POST['id']);
}

if (isset($_GET['action']) && $_GET['action'] == "delete") {
  mysql_query("DELETE FROM playlist_id WHERE id=".$_GET['id']);
  mysql_query("DELETE FROM files_plist WHERE pl_id=".$_GET['id']);
  header("Location: index.php");
}

if (isset($_GET['action']) && $_GET['action'] == "copy") {
  mysql_query("INSERT INTO playlist_id (name) VALUES ('".$_GET['name']." (копия)')");
  $id = mysql_fetch_assoc(mysql_query("SELECT id FROM playlist_id WHERE name='".$_GET['name']." (копия)'")) or die(mysql_error());
  
  $q = mysql_query("SELECT * FROM files_plist WHERE pl_id=".$_GET['id']) or die(mysql_error());
  while ($r = mysql_fetch_assoc($q)) {
    mysql_query("INSERT INTO files_plist (pl_id,source,dest) VALUES (".$id['id'].",'".$r['source']."','".$r['dest']."')") or die(mysql_error());
  }
  
  header("Location: index.php");
}
header("Content-type: text/html;charset=utf-8");

$que = mysql_query("SELECT * FROM playlist_id");
?>

<center><table width="" border="0px" cellspacing="20px">

  <tr>
    <td width=''>

        <?php
        
          while ($res = mysql_fetch_assoc($que)) {
            
          echo "<form method='post' action='index.php'><input type='hidden' name='action' value='edit'><input type='hidden' name='id' value='".$res['id']."'>";
            echo "<input type='text' name='name' value='".$res['name']."' size='40'> | <input type='image' src='http://profile.directphone.net/templates/images/edit.png'> <a href='index.php?action=delete&id=".$res['id']."' onclick=\"return confirm('Вы уверены, что хотите удалить плейлист &laquo;".$res['name']."&raquo;?');\"><img src='http://profile.directphone.net/templates/images/delete.png'></a> <a href='/link/index.php?plid=".$res['id']."'>Содержание</a> <a href='index.php?action=copy&id=".$res['id']."&name=".$res['name']."'>Копировать</a> <a href='index_2.php?id=".$res['id']."&name=".$res['name']."'>Рестораны</a><br>";
          echo "</form>";
            
          }
        
        ?>
    
    </td>
    
    
    <td width='450px'>
    
     <form method='post' action='index.php'>
     Добавить новый плейлист:<br>
      Укажите имя: <input type='text' name='name'><input type='hidden' name='action' value='create'> | <input type="submit" value='Создать'>
     
     </form>
      
    </td>
  
  <tr>
    <td colspan="2"></td>
</table>
<a href="http://demo.rdsmedia.tv/an_panel.php">Вернуться в админ-панель RDS Media</a><br><br>
</center>