<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
include("../class/mysql.class.php");


 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select path from  public_upload where user = '".$_SESSION['username']."'";
 //echo $sql . "\n";
 $results = $db1->QueryArray($sql);
 $db1->Close();
 $res = "#";
 for ($i=0;$i < count($results);$i++)
  {
	  $res .= base64_decode($results[$i]['path']) . "#";
  }
echo $res;
?>
