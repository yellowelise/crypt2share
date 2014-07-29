<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");
//include("../func/functions.php");

$json_header = array(
"code"=>"",
);

function format_size($size) {

    $mod = 1024;

    $units = explode(' ','B KB MB GB TB PB');

    for ($i = 0; $size > $mod; $i++) {

        $size /= $mod;
    }

    return round($size, 2) . ' ' . $units[$i];
}

$f = urldecode($_REQUEST['f']);
$idf = $_REQUEST['idf'];

function email_from_id($id)
{
	 $db1 = new MySQL(true);
	 if ($db1->Error()) $db1->Kill();
	 $db1->Open();
	 $sql = "select email from users where iduser ='".$id."'";
	// echo $sql."<br />";
	 $results = $db1->QueryArray($sql);
	return $results[0]['email'];
}

function notify($idto,$from,$title, $message)
{
 if ($from != '')
  $from = username_from_id($from);	
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "insert into notification (iduser,title,text,from_not) values ('".$idto."','".$title."','".$message."','".$from."')";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 
 $db1->Close();

}


function username_from_id($id)
{
	 $db1 = new MySQL(true);
	 if ($db1->Error()) $db1->Kill();
	 $db1->Open();
	 $sql = "select username from users where iduser ='".$id."'";
	// echo $sql."<br />";
	 $results = $db1->QueryArray($sql);
	return $results[0]['username'];
}




$username_f = username_from_id($idf);
if ($username_f != '')
{

	


$folder = $_SESSION['path'] . $username_f . "/files/ricevuti/";
if (!file_exists($folder))
 mkdir($folder); 


$folder .= $_SESSION['username'] . "/";
if (!file_exists($folder))
 mkdir($folder); 

$folder .= date("Y-m-d") . "/";  
if (!file_exists($folder))
 mkdir($folder);   
//echo $folder;

function new_name($d,$f,$i)
{
	$f_noext = str_replace(".".strtolower(substr(strrchr(basename($f), '.'), 1)),"",basename($f)); 
	$ext = strtolower(substr(strrchr(basename($f), '.'), 1)); 
	$new_name = $f_noext."(".$i.").".$ext;
	if (file_exists($d . $new_name))
	{
	 $ret = new_name($d,$f,$i+1);
	}
	else
	 $ret = $new_name;
 return $ret;	  
}




if (file_exists($folder.basename($f)))
	$fn = new_name($folder,basename($f),1); 
else
	$fn = basename($f); 
	



 if (copy($_SESSION['home'] . $f,$folder.$fn))
  {
      notify($idf,$_SESSION['iduser'],"un file per te!",basename($fn) . "<br /><b>controlla nella cartella <u>ricevuti</u></b>");
      $em_fr = email_from_id($idf);


	  $json_header["code"] = "200";
	  $json_header["friend"]["username"] = $username_f;
	  $json_header["friend"]["id_friend"] = $idf;
	  $json_header["friend"]["email"] = $em_fr;
	  $json_header["file"]["filename"] = basename($fn);
	  $json_header["file"]["dest_dir"] = "files/ricevuti/" . $_SESSION['username'] . "/";
	  $json_header["file"]["size"] = filesize($_SESSION['home'] . $f);
	  $json_header["file"]["human_size"] = format_size($json_header["file"]["size"]);
	  
	  
	  
	  
	   
  }
 else
  {
	        $em_fr = email_from_id($idf);
	  $json_header["code"] = "406";//"Errore nella copia";
	  $json_header["friend"]["username"] = $username_f;
	  $json_header["friend"]["id_friend"] = $idf;
	  $json_header["friend"]["email"] = $em_fr;
	  $json_header["file"]["filename"] = basename($f);
	  $json_header["file"]["dest_dir"] = "files/ricevuti/" . $_SESSION['username'] . "/";
	  $json_header["file"]["size"] = filesize($_SESSION['home'] . $f);
	  $json_header["file"]["human_size"] = format_size($json_header["file"]["size"]);
	  
  } 

}
else
{
	  $json_header["code"] = "406";//"Errore nella copia";
	  $json_header["friend"]["username"] = "";
	  $json_header["friend"]["id_friend"] = "0";
	  $json_header["friend"]["email"] = "";
	  $json_header["file"]["filename"] = "";
	  $json_header["file"]["dest_dir"] = "";
	  $json_header["file"]["size"] = "0";
	  $json_header["file"]["human_size"] = "0 B";
	  
	 
}

echo json_encode($json_header);
?>
