<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

function format_size($size) {

    $mod = 1024;

    $units = explode(' ','B KB MB GB TB PB');

    for ($i = 0; $size > $mod; $i++) {

        $size /= $mod;
    }

    return round($size, 2) . ' ' . $units[$i];
}


include("../class/mysql.class.php");
$id = $_REQUEST['id'];
$pass = $_REQUEST['p'];


$json_header = array(
"code"=>""
);

 
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select filename, AES_DECRYPT(contents,'".$pass."') as contents,date from cry_contents where iduser ='".$_SESSION['iduser']."' and uploadticket = '".$id."' and hash_crypted = '".sha1($pass)."'";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $db1->Close();
 //echo "file:" . $results[0]['filename'];
 if ($results[0]['filename'] != '')
 {
  $path_file = explode("/",str_replace(basename($results[0]['filename']),"",$results[0]['filename']));
  $curr_path =    $_SESSION['home'];
  for ($j=0;$j<count($path_file);$j++)
   {
	$curr_path =   $curr_path . $path_file[$j] . "/";
	//echo    $_SESSION['home'].$path_file[$j] . "\n";
	 if (!file_exists($curr_path)) {
	   //echo "Creo la cartella: " . $path_file[$j] . "\n"; 
	   mkdir($curr_path);  
     }
   }	 
 $file = $_SESSION['home'] . $results[0]['filename'];

 $json_header["code"] = "200";
 $json_header["file"]["filename"] = basename($file);
 $json_header["file"]["dir"] = str_replace(basename($results[0]['filename']),"",$results[0]['filename']);
 $json_header["file"]["crypt_date"] = $results[0]['date'];
 $json_header["file"]["uploadticket"] = $id;


 //echo $file;
  for ($i=0;$i<count($results);$i++)
  file_put_contents($file,$results[$i]['contents'], FILE_APPEND);

 
  $db1->Open();
  $sql = "delete from cry_contents where iduser ='".$_SESSION['iduser']."' and uploadticket = '".$id."' and hash_crypted = '".sha1($pass)."'";
  $results = $db1->Query($sql);
  $db1->Close(); $db1->Open();
  
  $sql = "delete from crypted where iduser ='".$_SESSION['iduser']."' and uploadticket = '".$id."' and hash_crypted = '".sha1($pass)."'";
  $results = $db1->Query($sql);
  $db1->Close();

 $json_header["file"]["size"] = filesize($file);
 $json_header["file"]["human_size"] = format_size($json_header["file"]["size"]);

}
else
$json_header["code"] = "103";//"Password errata";

echo json_encode($json_header);
 ?>
