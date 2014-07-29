<?php
session_start();
//ini_set('display_errors', 'Off');
//ini_set('display_startup_errors', 'Off');
//error_reporting(0);

include("../class/mysql.class.php");



$db1 = new MySQL(true);
if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select email from users where username='".$_SESSION['username']."'";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $db1->Close();
 if ($results)
 echo $results[0]['email'];

?>
