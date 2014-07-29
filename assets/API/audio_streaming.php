<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../config.php");

$f = $_REQUEST['f'];
$file = $_SESSION['site_address'] ."homes/".$_SESSION['username']."/" . $f;
$real_file = $_SESSION["home"] . $f;


if (file_exists($real_file))

{
	//echo get_mime_type($real_file);
header('Content-type: audio/mpeg');
header('Content-Length: '.filesize($real_file)); // provide file size
header("Expires: -1");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
readfile($file);

}
else
 header('HTTP/1.0 404 Not Found');
?>
