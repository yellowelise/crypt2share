<?php
session_start();
//ini_set('display_errors', 'Off');
//ini_set('display_startup_errors', 'Off');
//error_reporting(0);

$d = utf8_decode($_REQUEST['d']);
$new_folder = $_SESSION['home'] . $d;
//echo $new_folder;

if (!file_exists($new_folder))
 {
	 mkdir($new_folder); 
 }
else
 echo "La cartelle esiste."; 

?>
