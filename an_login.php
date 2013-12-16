<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>RDS Media enter personal account</title>
</head>
<body>
<a href="http://demo.rdsmedia.tv"><img src="logo.png" width=100 border="0" align="right" /></a>
<h1>
<p div="" align="center">Вход в Панель управления администратора RDSmedia</p>
</h1>
<?php
session_start();
if($_SESSION['logged']) {
header('Location: /an_panel.php?type=1');
}
else if($_SESSION['g_logged']){
header('Location: /an_panel.php');
exit;
}
?>
<a href='http://bk.rdsmedia.tv' align='center'>Back to home page</a><p>
<table width="100%" height="90%" border="0" cellspacing="0" cellpadding="5" align=left valign=top>
<tbody> 
 <tr align=CENTER  height="80%" valign=middle > 
  <td>
<?if($_GET['error']==115) echo "Ошибка 115: Неверный логин или пароль.";
if($_GET['error']==116) echo "Ошибка 116: Вы не имеете права доступа к данному ресурсу.";

if($_GET['error']==1) echo "Ошибка! Введенный e-mail отсутствует в базе данных пользователей"?>
   <form action="action.php" method="post" align="center">
    <p>Login: 
    <input type="text" name="login" />
    <p>Password: 
    <input type="password" name="pass" />
    <p><button formaction="an_loged.php">OK</button>
   </form>
   <form action='http://demo.rdsmedia.tv/glogin/index.php?mode=3' method='post'>
   <input type='hidden' value='truya' name='gauth'>
   <input type='image' src='http://profile.directphone.net/images/login_google.png' width='220px'>
<!-- a href="google_login.php?mode=3" target="" title = "login with Google" align="center"><Img src= "http://todocamp.com/media/i/google-login-button.png"></a -->
   </form>

  </td>
 <tr height="10%" valign=bottom>
  <td ALIGN=CENTER >
   <hr />
   <h4>
   <p div="" align="center">Copyright &copy; 2012-2013 RDSmedia <span class="Apple-tab-span" style="white-space:pre">	</span>+7(495) 983-01-83 <span class="Apple-tab-span" style="white-space:pre">	</span>info@rdsmedia.tv  <span class="Apple-tab-span" style="white-space:pre">	</span>demo.rdsmedia.tv     </p>
   </h4>
   </td>
 </tr>
</tbody>
</table>

</body>
</html>
