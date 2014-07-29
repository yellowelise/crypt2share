<?php
session_start();
include("class/mysql.class.php");
$f = utf8_decode($_REQUEST['f']);


 
 if (file_exists($_SESSION['home'] . $f))
  {
   header("Cache-Control: public");
   header("Content-Description: File Transfer");
   header("Content-Disposition: attachment; filename= " . $f);
   header("Content-Transfer-Encoding: binary");
   // Leggo il contenuto del file
   readfile($_SESSION['home'] . $f);
  }  
?>
