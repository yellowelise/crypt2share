<?php
session_start();
//ini_set('display_errors', 'Off');
//ini_set('display_startup_errors', 'Off');
//error_reporting(0);

include("../class/mysql.class.php");
$f = utf8_decode($_REQUEST['f']);
$pass = $_REQUEST['p'];

$file = $_SESSION['home'] . $f;
$file_size = filesize($file);


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
 return $uploadticket;
}

function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    // Uncomment one of the following alternatives
    // $bytes /= pow(1024, $pow);
     $bytes /= (1 << (10 * $pow)); 

    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 


function mysql_escape_mimic($inp) {
    if(is_array($inp))
        return array_map(__METHOD__, $inp);

    if(!empty($inp) && is_string($inp)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
    }

    return $inp;
}

$start = microtime(true);
//echo $start;

$data = file_get_contents($file);
$data = mysql_escape_mimic($data);
//$data = mysql_real_escape_string($data);
$filename = $f;
$uploadticket = db_insert_chunk($filename,$file,$pass);
$db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "insert into crypted (filename,hash_crypted,iduser,uploadticket,file_size) values ('".$filename."','".sha1($pass)."','".$_SESSION['iduser']."','".$uploadticket."','".$file_size."') ";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 $db1->Close();

$size = filesize($file);
unlink($file);
echo formatBytes($size)."@". round((microtime(true) - $start),2);



?>
