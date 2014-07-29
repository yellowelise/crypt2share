<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);


$path = $_SESSION['home'];

if (isset($_REQUEST['fn']))
  $fn = urldecode($_REQUEST['fn']);
 else 
  $fn = '';


if (isset($_REQUEST['s']))
  $s = $_REQUEST['s'];
 else 
  $s = 0;
  

if (isset($_REQUEST['c']))
 $c = 1;
else
 $c = 0; 

if (isset($_REQUEST['w']))
 $w = $_REQUEST['w'];
else
 $w = 0; 
 
 
if (isset($_REQUEST['h']))
 $h = $_REQUEST['h'];
else
 $h = 0; 

function writelog($file,$start,$stop,$time)
{
//	file_put_contents("logtime.txt", basename($file) . ": ".round($time,2) . "\n" . $start . " - " . $stop . "\n", FILE_APPEND | LOCK_EX);
	file_put_contents("logtime.txt", basename($file) . ": ".round($time,4) . "\n", FILE_APPEND | LOCK_EX);
}

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

include("img_res.php");

 $ext = strtolower(substr(strrchr($fn, '.'), 1));

 header('Content-Type: ' . extension_to_image_type($ext));
 resize($path . $fn, $w,$h,$c,$s);

 
 
	   //echo "esiste: ". $cachedfile; 
	   
   
?>
