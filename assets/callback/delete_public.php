<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
include("../class/mysql.class.php");


 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "delete from  public_upload where user = '".$_SESSION['username']."' and path = '".$_REQUEST['d']."'";
 //echo $sql . "\n";
 $results = $db1->Query($sql);
 $db1->Close();
?>
