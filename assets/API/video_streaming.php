<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../config.php");

$f = $_REQUEST['f'];
$file = $_SESSION['server_path'] ."homes/".$_SESSION['username']."/" . $f;
$real_file = $_SESSION["home"] . $f;

function ret_mime($ext)
{
if ($ext == 'flv')
 return	"video/x-flv";
 
if ($ext == 'avi')
 return "video/mpeg";

if ($ext == 'mp4')
 return	"video/mp4";

if ($ext == 'ogg')
 return	"video/ogg";

if ($ext == 'mov')
 return	"video/quicktime";
 
 

}

if (file_exists($real_file))

{
	 $ext = strtolower(substr($real_file, (strrpos($real_file, '.')+1)));
	//echo $ext;
	//echo "nome del file:" . $real_file . "<br />";
	//echo get_mime_type($real_file);
header('Content-type: ' . ret_mime($ext));
header("Accept-Ranges:bytes");
header('Content-Length: '.filesize($real_file)); // provide file size
//header("Expires: -1");
//header("Cache-Control: no-store, no-cache, must-revalidate");
//header("Cache-Control: post-check=0, pre-check=0", false);
readfile($file);
//echo "stream:" . $file . "<br />";

//header("X-Sendfile: $file");
//header('Content-type: ' . ret_mime($ext));
//header('Content-Disposition: attachment; filename="' . basename($real_file) . '"');
// header("Content-Length: ".filesize($real_file)); 
// readfile($file);
}
else
 header('HTTP/1.0 404 Not Found');
?>
