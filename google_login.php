<?php
require_once('/var/simplesamlphp/lib/_autoload.php');
$auth = new SimpleSAML_Auth_Simple('rds-sp');
$auth->requireAuth(array(
	'saml:sp' => 'rds-sp',
	'saml:idp' => 'http://80.243.15.5/simplesaml/saml2/idp/metadata.php'
	)
);
//-----------------------------------------------------------------------
$attrs = $auth->getAttributes();
$email= $attrs['http://axschema.org/contact/email'][0];
print($email);
echo $email; 
session_start();
$mysqli = new mysqli("80.243.15.5","user","pass", "idp_db");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->set_charset("unicode");
$res=$mysqli->query("SELECT * FROM users WHERE u_email = '".$email."';");
$row=$res->fetch_assoc();
if($row[u_email]==$email)
{
//----------------------------------------------------------------------
$_SESSION['g_logged']=true;
$_SESSION['name']=$row['u_login'];
if ($_GET['mode']==1){
header('Location: /cm_panel.php');
}
else if ($_GET['mode']==2){
header('Location: /cl_panel.php');
}
else 
{

header('Location: /an_panel.php'); 
}
}
else if ($_GET['mode']==1){
header('Location: /google_logout.php?err=1');
}
else if ($_GET['mode']==2){
header('Location: /google_logout.php?err=2');
}
else 
header('Location: /google_logout.php?err=3');

?>