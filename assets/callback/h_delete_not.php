<?php
session_start();
//ini_set('display_errors', 'Off');
//ini_set('display_startup_errors', 'Off');
//error_reporting(0);

include("../class/mysql.class.php");

$id = $_REQUEST['id'];

 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "delete from  notification  where idnotification = '".$id."' and iduser = '".$_SESSION['iduser']."'";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 
 $db1->Close();

?>
