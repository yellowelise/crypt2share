<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");
//include("../func/functions.php");

$f = urldecode($_REQUEST['f']);


$folder = $_SESSION['path'] . $_SESSION['username'] . "/files/mysite/";
if (!file_exists($folder))
 mkdir($folder); 


//echo $folder;
copy($_SESSION['home'] . $f,$folder.basename($f));

?>
