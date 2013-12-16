<!DOCTYPE HTML>
<html>
 <head>
  <BASE TARGET="_parent">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>RDS enter personal account</title>
</head>
<body>
<h2>Добавить устройство</h2> 
<? session_start(); ?>
<form action="action.php" method="post" align="center">
    <p>Инвентарный номер устройства:
    <input type="text" name="name" >
    <p>ID локации: 
    <input type="text" name="owner" >
    <p>Модель: 
    <input type="text" name="model"  >
    <p>Прошивка: 
    <input type="text" name="firmware"  >
    <p>Ссылка на управление: 
    <input type="text" name="weblink" >
    <p>Комментарий: 
    <p><textarea cols="60" name="comm"> </textarea>
    <p><button formaction="an_dev_a.php">Сохранить</button>
</form>
</body>
</html>