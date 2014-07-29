<?php
session_start();
//ini_set('display_errors', 'Off');
//ini_set('display_startup_errors', 'Off');
//error_reporting(0);
include("class/mysql.class.php");

$id = $_REQUEST['id'];
//echo "id: ".$id;
$ip = $_SERVER['REMOTE_ADDR'];

$pass = $_REQUEST['p'];



function validate_pass($file_to_download,$pass)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select idcrypted_file from crypted_file where complete_path ='".$file_to_download."' and hash_crypted = '".sha1($pass)."'";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 
 $db1->Close();
 return $results;   	
}


function filename_from_id($id)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select complete_path from file_to_download where idfile_to_download ='".$id."'";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $db1->Close();
 return $results[0]['complete_path'];
}

function downloaded($id,$ip)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "insert into downloaded (idfile_to_download,ip,complete_path) values ('".$id."','".$ip."','".filename_from_id($id)."')";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 $db1->Close();
}


function db_insert($tmp,$pass)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "insert into decrypt (contents) values ('".$tmp."') ";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 $db1->Close();

 $db1->Open();
 $sql = "select AES_DECRYPT(contents,'".$pass."') as contents from decrypt where iddecrypt = '".$results."' ";
 echo $sql."<br />";
 $result = $db1->QueryArray($sql);
 $db1->Close();
 
 return $result[0]['contents'];
}

function db_decrypt($file,$tmp,$pass)
{
    $handle = fopen($tmp,"w");
    //echo $tmp;
    fclose($handle);
    $handle = fopen($tmp,"a");
    
    
    $fp = fopen($file, 'r');	
	$btotal = filesize($file);
	
	$da = 0;
	$quanti = 200000;
    //echo $btotal . "<br />";
  //  $uploadticket = rand(100,1000000000);
//	$part = stream_get_contents($fp,$da,$quanti);
//echo "un pezzo:".utf8_encode($part) . "<br />";    
	while (($da)< $btotal)
	 {
	   $part = stream_get_contents($fp,$quanti,$da);
	   //echo "da: ". $da." quanto: " . $quanti."<br />";
	   //echo "pezzo: ". $part . "<br /><br /><br />";
	   $da = $da + $quanti;
	   $partdecrypt = db_insert(mysql_escape_mimic($part),$pass);
	   echo substr($partdecrypt,1,200) . "<br />";
	   fwrite($handle,$partdecrypt);   
	 }
	 
fclose($fp);	
fclose($handle);	
}

function mysql_escape_mimic($inp) {
    if(is_array($inp))
        return array_map(__METHOD__, $inp);

    if(!empty($inp) && is_string($inp)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
    }

    return $inp;
}


$file_to_download = filename_from_id($id);
//echo $file_to_download;
 
 if (file_exists($file_to_download))
 if (validate_pass($file_to_download,$pass)>1)
  {
	 downloaded($id,$ip);  
	  
	 $temp_file = $_SESSION['temp_path'] . rand(1000000,10000020202) ;
	 db_decrypt($file_to_download,$temp_file,$pass); 
	  
	  
	  
    $exp_file = preg_replace("/[^[:alnum:][:punct:]]/","_",basename($file_to_download)); 
  /*  header("X-Sendfile: $file");
    header("Content-type: application/octet-stream");
    header('Content-Disposition: attachment; filename="' . $exp_file . '"');
    header("Content-Length: ".filesize($file_to_download)); 
    readfile($file_to_download);
	*/   
  }
 else
  {
	   echo "abbellire!!!<br /><form><input type='hidden' name='id' value='".$id."'><input type='password' name='p'><button>submit</button></form>";
  } 





   
 
 // file_put_contents($file,$results[$i]['contents'], FILE_APPEND);
   
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
