<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");

$e = $_REQUEST['e'];

$db1 = new MySQL(true);
if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "update users set email = '".$e."' where username='".$_SESSION['username']."'";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 $db1->Close();


 $db1->Open();
 $sql = "select username, generate_pass from users where username='".$_SESSION['username']."'";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $db1->Close();


 mail($e,"Credenziali accesso Crypt2Share","Ciao ".$_SESSION['username']."\nLa tua password da noi generata è: ". $results[0]['generate_pass'] . " la puoi cambiare in ogni istante andando a questo link:\n https://www.crypt2share.com/index.php?cID=132 \n Questa password è indispensabile per accedere al tuo MySite http://my.crypt2share.com/".$_SESSION['username']);
 

?>
