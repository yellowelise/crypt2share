<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
include("class/mysql.class.php");

$id = $_REQUEST['id'];
$pass_decrypt = $_SESSION['download_pass'];
//echo $pass_decrypt;
$pass = $_REQUEST['h'];
$path = dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . "tmp" . DIRECTORY_SEPARATOR;
//echo $path . "<br />";
$ip = $_SERVER['REMOTE_ADDR'];

 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "insert into downloads (uploadticket,ip) values ('".$id."','".$ip."')";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 $db1->Close();


 
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();

 $db1->Open();
 $sql = "select count(filename) as quanti from cry_contents where uploadticket = '".$id."' and hash_crypted = '".$pass."' order by idcry_contents";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $quantipezzi = $results[0]['quanti'];
 $db1->Close();

 $db1->Open();
 $sql = "select distinct filename as nome from cry_contents where uploadticket = '".$id."' and hash_crypted = '".$pass."' order by idcry_contents";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $nome = $results[0]['nome'];
 $db1->Close();

 $file = $path . basename($nome);
 if (file_exists($file))
  unlink($file);


//echo "quanti pezzi: ". $quantipezzi . "<br />";
$moltogrande = $quantipezzi / 50;
if ($moltogrande > 1)
 {
  $cinquantine = intval($moltogrande) + 1;
 }
else
 {
  $cinquantine = 1;
 } 

//echo $cinquantine;



for ($j=0;$j<$cinquantine;$j++)
 {

$start = $j * 50;
 $db1->Open();
 $sql = "select filename, AES_DECRYPT(contents,'".$pass_decrypt."') as contents from cry_contents where uploadticket = '".$id."' and hash_crypted = '".$pass."' order by idcry_contents limit " .$start.",50";
//echo "j: " . $j . "   ----   ".$sql."<br />";



 $results = $db1->QueryArray($sql);
 $db1->Close();

 
 
 if ($j == 0)
  { 
   //echo "creo file<br />";
   $handle = fopen($file, "w");
  }
 else
  {
   //echo "appendo al file<br />";
   $handle = fopen($file, "a");
  } 
 for ($i=0;$i<count($results);$i++)
 // echo "scrivo nel file --- ";
  fwrite($handle, $results[$i]['contents']);
 
 fclose($handle);

}




   
 
 // file_put_contents($file,$results[$i]['contents'], FILE_APPEND);
  
    $exp_file = preg_replace("/[^[:alnum:][:punct:]]/","_",basename($file)); 

header("X-Sendfile: $file");
header("Content-type: application/octet-stream");
header('Content-Disposition: attachment; filename="' . $exp_file . '"');
 header("Content-Length: ".filesize($file)); 
 readfile($file);
    
// echo $file;   
/* header("Content-Disposition: attachment; filename='".$exp_file."'");
 header('Expires: 0');
 header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
 header("Content-Transfer-Encoding: binary"); 
 header('Pragma: public'); 
 header("Content-Length: ".filesize($file)); 
 readfile($file);
 exit;    
    
    
  */  
//  header("Cache-Control: public");
//  header("Content-Description: File Transfer");
//  header("Content-Disposition: attachment; filename= " . $exp_file);
//  header("Content-Transfer-Encoding: binary");
  // Leggo il contenuto del file
//  readfile($file); 
 //unlink($file);

?>
