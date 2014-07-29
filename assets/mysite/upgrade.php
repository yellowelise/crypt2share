<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
include("../class/mysql.class.php");
include("../config.php");

 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select username from users where active = '1'";
 echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 echo "<pre>";
 print_r($results);
 echo $_SESSION['app_path'];
 echo "</pre>";
 $db1->Close();
for ($i=0;$i<count($results);$i++)
if (($results[$i]['username'] > ''))
{
 if (file_exists($_SESSION['app_path'] . "/mysite/".$results[$i]['username']))	
  if ((md5_file($_SESSION['app_path'] . "mysite/.mysite_template/1/index.php") != md5_file($_SESSION['app_path'] . "/mysite/".$results[$i]['username']."/index.php")) || (md5_file($_SESSION['app_path'] . "mysite/.mysite_template/1/callback.php") != md5_file($_SESSION['app_path'] . "/mysite/".$results[$i]['username']."/callback.php")))
   {
    copy($_SESSION['app_path'] . "mysite/.mysite_template/1/index.php",$_SESSION['app_path'] . "/mysite/".$results[$i]['username']."/index.php");
    copy($_SESSION['app_path'] . "mysite/.mysite_template/1/callback.php",$_SESSION['app_path'] . "/mysite/".$results[$i]['username']."/callback.php");
    echo "mysite ".$results[$i]['username']." aggiornato<br />";
   }
}
 ?>
