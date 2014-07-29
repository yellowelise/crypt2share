<?php
session_start();
include("class/mysql.class.php");
$id = $_REQUEST['id'];


 
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select filename, contents from cry_contents where iduser ='".$_SESSION['iduser']."' and uploadticket = '".$id."' order by idcry_contents";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $db1->Close();
 //echo "file:" . $results[0]['filename'];
 if (!file_exists($_SESSION['home'] . ".temp".DIRECTORY_SEPARATOR))
  mkdir($_SESSION['home'] . ".temp".DIRECTORY_SEPARATOR, 0777);
  
 $file = $_SESSION['home'] . ".temp" . DIRECTORY_SEPARATOR.basename($results[0]['filename']) .".aes";
  if (file_exists($file))
  unlink($file);
 for ($i=0;$i<count($results);$i++)
  file_put_contents($file,$results[$i]['contents'], FILE_APPEND);
  
  
  //$exp_file = preg_replace("/[^a-zA-Z0-9_ -.]/s", "", basename($file) .".aes");
  $exp_file = preg_replace("/[^[:alnum:][:punct:]]/","_",basename($file)); 
  header("Cache-Control: public");
  header("Content-Description: File Transfer");
  header("Content-Disposition: attachment; filename= " . $exp_file); 
  header("Content-Transfer-Encoding: binary");
  // Leggo il contenuto del file
  readfile($file); 
?>
