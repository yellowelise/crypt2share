<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
include("../class/mysql.class.php");
include("../config.php");
$u = strtolower($_POST['u']);
$u_epu = preg_replace('/[^a-zA-Z0-9.]/s', '', $u);
$p = $_POST['p'];
$m = $_POST['m'];
$ip = $_SERVER['REMOTE_ADDR'];



if ($u == $u_epu)
{
$path = $_SESSION['path'] . $u_epu . DIRECTORY_SEPARATOR;
//echo $path; 
if (!file_exists($path))
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();

 $db1->Open();
 $sql = "select email from users where email = '".$m."'";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $mail = $results[0]['email'];
 $db1->Close();



if ($mail == '')
{
 $db1->Open();
 $sql = "insert into users (username,password,email,ip,active) values ('".$u."','".sha1($p)."','".$m."','".$ip."','0') ";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 $db1->Close();
//   if (!file_exists($path))
//  mkdir($path, 0777);

 
  
  
mail("yellowelise@gmail.com","Nuova registrazione",$u . "\n".$m);
  
$res = mail($m,"Crypt2Share activation","Hi ".$u."\nClick or copy in browser this link to activate:\n https://www.crypt2share.com/activate.php?h=".sha1($p)."&u=".$u);
echo "Completa la registrazione seguendo le istruzioni via mail.";
}
else
{
echo "email già in uso";	
}
}
else
{
echo "username non disponibile!";
}
}
else
echo "Caratteri non permessi nel nome utente... (a-z A-Z 0-9 e . )";

?>
