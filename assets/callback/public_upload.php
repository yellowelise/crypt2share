<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");

$d = base64_encode($_REQUEST['dir']);
$p = $_REQUEST['p'];


function rand_string( $length ) {

$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
return substr(str_shuffle($chars),0,$length);

} 








function create_public_upload($d,$p,$ticket)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "delete from public_upload where path = '".$d."' and user = '".$_SESSION['username']."'";
 $results2 = $db1->Query($sql);
 $db1->Close(); 

 $db1->Open();
 $sql = "insert into  public_upload (user,path,IP,password,ticket) values ('".$_SESSION['username']."','".$d."','".$_SERVER['REMOTE_ADDR']."','".sha1($p)."','".$ticket."') ";
 $results2 = $db1->Query($sql);
 $db1->Close(); 
	
}

function ticket_exists($ticket)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select idpublic_upload from  public_upload where ticket = '".$ticket."'";
 //echo $sql . "\n";
 $results = $db1->QueryArray($sql);
 $db1->Close(); 
 if ($results[0]['idpublic_upload']>'')
  return true;
 else
  return false; 
}

function create_ticket($q)
{
  $ticket = rand_string($q);
  if (ticket_exists($ticket))
   $ticket = create_ticket($q+1);


 return $ticket;
}


$ticket = create_ticket(4);

create_public_upload($d,$p,$ticket);

echo $ticket;


?>
