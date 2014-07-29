<?php
session_start();
//ini_set('display_errors', 'Off');
//ini_set('display_startup_errors', 'Off');
//error_reporting(0);


  $path = $_SESSION['path'];

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

if (isset($_REQUEST['dwn']))
 $dwn = $_REQUEST['dwn'];
else
 $dwn = 0; 

include("../img_res.php");

 
   $ext = strtolower(substr(strrchr($fn, '.'), 1));

	if ($dwn == 1)
	 {
       header("X-Sendfile: $cachedfile");
	   header("Content-type: application/octet-stream");
	   header('Content-Disposition: attachment; filename="' . basename($fn) . '"');
	   header("Content-Length: ".filesize($cachedfile)); 
	 
	 }
	else
	 { 
	   //echo "esiste: ". $cachedfile; 
	   header('Content-Type: ' . extension_to_image_type($ext));
	  // echo "esisto in cache" . $cachedfile; 
     }
  resize($path . $fn, $w,$h,$c,$s);

?>
