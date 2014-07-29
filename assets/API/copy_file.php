<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");
//include("../func/functions.php");

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

function notify($idto,$from,$title, $message,$filename)
{
 if ($from != '')
  $from = username_from_id($from);	
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "insert into notification (iduser,title,text,from_not,file_for_you) values ('".$idto."','".$title."','".$message."','".$from."','".$filename."')";
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

notify($idf,$_SESSION['iduser'],"un file per te!",basename($f) . "<br /><b>controlla nella cartella <u>ricevuti</u></b>",basename($f));
echo email_from_id($idf);


$folder = $_SESSION['path'] . $username_f . "/files/ricevuti/";
if (!file_exists($folder))
 mkdir($folder); 


$folder .= $_SESSION['username'] . "/";
if (!file_exists($folder))
 mkdir($folder); 
  
//echo $folder;
copy($_SESSION['home'] . $f,$folder.basename($f));
}

?>
