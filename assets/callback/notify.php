<?php
session_start();

if (!$_SESSION['iduser'])
 if ($_SESSION['iduser']<1)
  break;

include("../class/mysql.class.php");

$id = $_REQUEST['id'];
$ut = $_REQUEST['ut'];


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


function filename_from_ut($ut)
{
	 $db1 = new MySQL(true);
	 if ($db1->Error()) $db1->Kill();
	 $db1->Open();
	 $sql = "select filename from crypted where uploadticket ='".$ut."'";
	// echo $sql."<br />";
	 $results = $db1->QueryArray($sql);
	return basename($results[0]['filename']);
}



function notify($idto,$from,$title, $message,$ut)
{
 if ($from != '')
  $from = username_from_id($from);	
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "insert into notification (iduser,title,text,from_not) values ('".$idto."','".$title."','".$message."','".$from."','".$ut."')";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 
 $db1->Close();

}


 notify($id,$_SESSION['iduser'],"Un file criptato per te!",filename_from_ut($ut) . "&nbsp;<button onclick=shared_decrypt(\'".$ut."\')>Decripta e copia</button>",$ut);
echo email_from_id($id);

?>
