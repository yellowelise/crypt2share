<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
include("../class/mysql.class.php");
include("../config.php");

$f = $_REQUEST['f'];
$file = $_SESSION['home'] . $f;


if (isset($_REQUEST['t']))
{
$type = $_REQUEST['t'];
}
else
$type = '1';

//echo $pass_decrypt;
//$pass = $_REQUEST['h'];
$path = $_SESSION['temp_path'];//dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . "tmp" . DIRECTORY_SEPARATOR;
//echo $path . "<br />";
$ip = $_SERVER['REMOTE_ADDR'];



 


$json = array(
"code"=>"103"
);

function get_mime_type($filename, $mimePath = '../etc') {
   $fileext = substr(strrchr($filename, '.'), 1);
   if (empty($fileext)) return (false);
   $regex = "/^([\w\+\-\.\/]+)\s+(\w+\s)*($fileext\s)/i";
   $lines = file("$mimePath/mime.types");
   foreach($lines as $line) {
      if (substr($line, 0, 1) == '#') continue; // skip comments
      $line = rtrim($line) . " ";
      if (!preg_match($regex, $line, $matches)) continue; // no match to the extension
      return ($matches[1]);
   }
   return (false); // no match at all
} 



 // file_put_contents($file,$results[$i]['contents'], FILE_APPEND);
  
    $exp_file = preg_replace("/[^[:alnum:][:punct:]]/","_",basename($file)); 
        
        $fil_nam = str_replace('"', "_", $exp_file);
        $ext = strtoupper(substr($fil_nam, (strrpos($fil_nam, '.')+1)));
        $nome = substr($fil_nam, 0,(strrpos($fil_nam, '.')+1));
        $res_fil_nam = $nome . $ext;    


if (file_exists($file))
{

if ($type == '1')
{
header("X-Sendfile: $file");
header("Content-type: application/octet-stream");
header('Content-Disposition: attachment; filename="' . $res_fil_nam . '"');
 header("Content-Length: ".filesize($file)); 
 readfile($file);
}

    
if ($type == '2')
{
 header("Content-Disposition: attachment; filename='".$res_fil_nam."'");
 header('Expires: 0');
 header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
 header("Content-Transfer-Encoding: binary"); 
 header("Content-type: ".get_mime_type($file));
 header('Pragma: public'); 
 header("Content-Length: ".filesize($file)); 
 readfile($file);
// exit;    
}    
    
if ($type == '3')
{
  header("Cache-Control: public");
  header("Content-Description: File Transfer");
  header("Content-Disposition: attachment; filename= " . $res_fil_nam);
  header("Content-Transfer-Encoding: binary");
  header("Content-type: application/octet-stream");
  // Leggo il contenuto del file
  readfile($file); 
}
}
else
 header('HTTP/1.0 404 Not Found');
?>
