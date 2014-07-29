<?php
session_start();
//ini_set('display_errors', 'Off');
//ini_set('display_startup_errors', 'Off');
//error_reporting(0);
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);


include("../class/mysql.class.php");
$f = utf8_decode($_REQUEST['f']);
$pass = $_REQUEST['p'];
$file = $_SESSION['home'] . $f;

//echo $file;
/*
function db_insert($filename,$tmp,$pass)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "insert into cry_contents (filename,contents,hash_crypted,iduser) values ('".$filename."',AES_ENCRYPT('".$tmp."','".$pass."'),'".sha1($pass)."','".$_SESSION['iduser']."') ";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 $db1->Close();
 
}

*/

function db_insert($filename,$tmp,$pass,$uploadticket)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "insert into cry_contents (filename,contents,hash_crypted,iduser,uploadticket) values ('".$filename."',AES_ENCRYPT('".$tmp."','".$pass."'),'".sha1($pass)."','".$_SESSION['iduser']."','".$uploadticket."') ";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 $db1->Close();
 
}

function db_insert_chunk($filename,$tmp,$pass)
{
    $fp = fopen($tmp, 'r');	
	$btotal = filesize($tmp);
	
	$da = 0;
	$quanti = 200000;
    //echo $btotal . "<br />";
    $uploadticket = rand(100,1000000000);
//	$part = stream_get_contents($fp,$da,$quanti);
//echo "un pezzo:".utf8_encode($part) . "<br />";    
	while (($da)< $btotal)
	 {
	   $part = stream_get_contents($fp,$quanti,$da);
	  // echo "da: ". $da." quanto: " . $quanti."<br />";
	  // echo "pezzo: ". $part . "<br />";
	   $da = $da + $quanti;
	   db_insert($filename,mysql_escape_mimic($part),$pass,$uploadticket);
	 }
	 
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "insert into crypted_file (complete_path,userid,hash_crypted) values ('".$_SESSION['home']."files/crypt/".basename($filename)."','".$_SESSION['iduser']."','".sha1($pass)."') ";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 $db1->Close();
 return $uploadticket;
}


function mysql_escape_mimic($inp) {
    if(is_array($inp))
        return array_map(__METHOD__, $inp);

    if(!empty($inp) && is_string($inp)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
    }

    return $inp;
}

function delete_from_db($uploadticket,$pass)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "delete from cry_contents where uploadticket = '".$uploadticket."' and hash_crypted = '".sha1($pass)."'";
 echo $sql."<br />";
 $results = $db1->Query($sql);
 $db1->Close();
}



function db_to_disk($ticket,$pass)
{
$id = $ticket;
$pass_decrypt = $pass;
//echo $pass_decrypt;
$pass = sha1($pass_decrypt);
$path =  $_SESSION['home'] . "files/crypt" . DIRECTORY_SEPARATOR;
//echo $path . "<br />";

//$path = "/var/www/crypt/tmp/";

 
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
 $sql = "select filename, contents from cry_contents where uploadticket = '".$id."' and hash_crypted = '".$pass."' order by idcry_contents limit " .$start.",50";
//echo "j: " . $j . "   ----   ".$sql."<br />";



 $results = $db1->QueryArray($sql);
 $db1->Close();

 echo $file . " ---";
 
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







}





//$data = file_get_contents($file);
//$data = mysql_escape_mimic($data);
//$data = mysql_real_escape_string($data);
$filename = $f;
$ticket = db_insert_chunk($filename,$file,$pass);
unlink($file);
db_to_disk($ticket,$pass);
delete_from_db($ticket,$pass);
?>
