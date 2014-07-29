<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
include("../class/mysql.class.php");
include("../config.php");

$id = $_REQUEST['ut'];
$pass_decrypt = $_REQUEST['p'];

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
 $sql = "select count(filename) as quanti from cry_contents where uploadticket = '".$id."' and hash_crypted = '".sha1($pass_decrypt)."' order by idcry_contents";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $quantipezzi = $results[0]['quanti'];
 $db1->Close();

 $db1->Open();
 $sql = "select distinct filename as nome from cry_contents where uploadticket = '".$id."' and hash_crypted = '".sha1($pass_decrypt)."' order by idcry_contents";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $nome = $results[0]['nome'];
 $db1->Close();

 $file = $path . basename($nome);
 if (file_exists($file))
  unlink($file);

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



if ($quantipezzi > 0)
{
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
 $sql = "select filename, AES_DECRYPT(contents,'".$pass_decrypt."') as contents from cry_contents where uploadticket = '".$id."' and hash_crypted = '".sha1($pass_decrypt)."' order by idcry_contents limit " .$start.",50";
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
        
        $fil_nam = str_replace('"', "_", $exp_file);
        $ext = strtoupper(substr($fil_nam, (strrpos($fil_nam, '.')+1)));
        $nome = substr($fil_nam, 0,(strrpos($fil_nam, '.')+1));
        $res_fil_nam = $nome . $ext;    




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

 unlink($file);
} // nessunfile
else
{
    header('HTTP/1.0 401 Unauthorized');
   //header('WWW-Authenticate: Basic realm="My Realm"');
//    echo "male";
}
//echo json_encode($json);
?>
