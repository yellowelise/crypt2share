<?php
session_start();
//ini_set('display_errors', 'Off');
//ini_set('display_startup_errors', 'Off');
//error_reporting(0);

include("../class/mysql.class.php");

$id = $_REQUEST['id'];

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



notify($id,$_SESSION['iduser'],"Amicizia rifiutata","");
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "update  friendship set status = 2 where id2='".$_SESSION['iduser']."' and id1='".$id."'";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 
 $db1->Close();

?>
