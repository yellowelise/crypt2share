<?php
session_start();
include("class/mysql.class.php");
$f = utf8_decode($_REQUEST['fn']);


 
 if (file_exists($_SESSION['home'] . $f))
  {
	
/*	   header("Cache-Control: public");
	   header("Content-Description: File Transfer");
	   header("Content-Disposition: attachment; filename= " . basename($f));
	   header("Content-Transfer-Encoding: binary");
	   // Leggo il contenuto del file
	   readfile($_SESSION['home'] . $f);
  */
  
  $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
  if ($ext == 'pdf')
    header("location: ../desk/viewer/pdf/web/viewer.php?fn=".str_replace("\\","/",$f) . "&w=" . $_REQUEST['w']. "&h=" . $_REQUEST['h']);
  if (($ext == 'gif')||($ext == 'jpg')||($ext == 'jpeg')||($ext == 'png'))
    header("location: " . '../app/sly/gallery_desk.php?w='.$_REQUEST['w'].'&h='.$_REQUEST['h'].'&f='.basename($f).'&d='.str_replace(basename($f),"",$f));
  if (($ext == 'mp4')||($ext == '3gp')||($ext == 'avi')||($ext == 'webm')||($ext == 'ogv'))
    header("location: ../desk/viewer/audiovideo/player/index.php?fn=".str_replace("\\","/",$f) . "&w=" . $_REQUEST['w']. "&h=" . $_REQUEST['h']);

  }  
  
?>
