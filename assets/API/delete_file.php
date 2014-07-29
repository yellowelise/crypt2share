<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

$json = array(
"code"=>""
);

$f = utf8_decode($_REQUEST['f']);
$file = $_SESSION['home'] . $f;
if (file_exists($file))
 {
   unlink($file);
   $json["code"] = "200";//"OK";
 }
else
   $json["code"] = "404";//"Il file non esiste";

echo json_encode($json);   
    

?>
