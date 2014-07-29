<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);


$json = array(
"code"=>""
);



include("../class/mysql.class.php");
$id = $_REQUEST['id'];
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();


  $db1->Open();
  $sql = "select filename from crypted where iduser ='".$_SESSION['iduser']."' and uploadticket = '".$id."'";
  $results = $db1->QueryArray($sql);
  $db1->Close();
  if ($results[0]["filename"] != '')
   {


	  $db1->Open();
	  $sql = "delete from cry_contents where iduser ='".$_SESSION['iduser']."' and uploadticket = '".$id."'";
	  $results = $db1->Query($sql);
	  $db1->Close();
	  
	  $db1->Open();
	  $sql = "delete from crypted where iduser ='".$_SESSION['iduser']."' and uploadticket = '".$id."'";
	  $results = $db1->Query($sql);
	  $db1->Close();
     $json["code"] = "200";
    }
   else
    {
     $json["code"] = "404";//"Nessuna corrispondenza";
		 
	} 
echo json_encode($json);
?>
