<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
include("../class/mysql.class.php");


$pass= sha1($_REQUEST['pass']);
$tk= ($_REQUEST['tk']);


 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select path,user from  public_upload where ticket = '".$tk."' and password = '".$pass."'";
 //echo $sql . "\n";
 $results = $db1->QueryArray($sql);
 $db1->Close(); 
 if ($results[0]['path'] > '')
   echo "<iframe style='width:100%;height:100%' frameborder=0 src='".$_SESSION['app_address']."/plupload/examples/jquery/jupload.php?u=".base64_encode($results[0]['user'])."&p=".urlencode(base64_decode($results[0]['path']))."'></iframe>";
 else
   echo "<h1>Password errata</h1>"; 


?>
