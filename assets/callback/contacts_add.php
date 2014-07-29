<?php
session_start();
//ini_set('display_errors', 'Off');
//ini_set('display_startup_errors', 'Off');
//error_reporting(0);

include("../class/mysql.class.php");

$e = $_REQUEST['e'];






 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select idcontacts from  contacts where iduser = '".$_SESSION['iduser']."' and email = '".$e."'";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 
 $db1->Close();

if (!$results)
 {
 $db1->Open();
 $sql = "insert into contacts (iduser,email) values ('".$_SESSION['iduser']."','".$e."')";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 
 $db1->Close();
}
?>
