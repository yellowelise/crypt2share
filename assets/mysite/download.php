<?php
session_start();
include("../config.php");

$f = utf8_decode($_REQUEST['fn']);

$file = $_SESSION["path"] . $f;
 
 if (file_exists($file))
  {
   header("X-Sendfile: $file");
   header("Content-type: application/octet-stream");
   header('Content-Disposition: attachment; filename="' . basename($file) . '"');
   header("Content-Length: ".filesize($file)); 
   readfile($file);
   // Leggo il contenuto del file
  
  }  
?>
