<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");

$e = $_REQUEST['e'];






 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();

 $ret = insert_invite($e);
// echo $ret;
	  if ( $ret == "-1")
	   {
		   echo "Utente già invitato"; 
	   }
	  if ( $ret == "-2")
	   {
		   echo "Utente già Iscritto"; 
	   }
	   
 

  
  
function insert_invite($email)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();


 $sql = "select iduser from users where email = '".$email."'";
 $results2 = $db1->QueryArray($sql);
 $db1->Close(); 
 if (($results2)&&($results2[0]['iduser'] > '1')&&($results2[0]['iduser'] != ''))
  {
	  return "-2";
  }
 else
  {
	  
	 $sql = "select idinvited from invited where friend_email = '".$email."'";
	 //echo $sql;
	 $db1->Open();
	 $results = $db1->QueryArray($sql);
//	 print_r($re);
//	 $q = $re['q'];
//	 echo "q:".$q;
	 $db1->Close(); 
	 
	 //echo "idinv:".$results[0]['idinvited'] . "-";
	 //return $results[0]['idinvited'];
	 
	if (($results)&&($results[0]['idinvited'] > '1')&&($results[0]['idinvited'] != ''))
	  {
		//echo "invited != ''";  
		return "-1";
	  }
	 else
	  {
		 $db1->Open();
		 $sql = "insert into  invited (id_sender,friend_email) values ('".$_SESSION['iduser']."','".$email."')";
		 $results3 = $db1->Query($sql);
		 $db1->Close(); 
  
		return "1";  
      }  
  }
/*
 $sql = "select idinvited from invited where friend_email = '".$email."'";
 $results = $db1->QueryArray($sql);
 $db1->Close(); 
 
 //echo "idinv:".$results[0]['idinvited'] . "-";
 //return $results[0]['idinvited'];
 
if (($results)&&($results[0]['idinvited'] != ''))
  {
	echo "invited != ''";  
    $retu = "-1";
  }
 else
  {
	 $sql = "select iduser from users where email = '".$email."'";
	 $results2 = $db1->QueryArray($sql);
	 $db1->Close(); 
	 if (($results2)&&($results2[0]['iduser'] > '1')&&($results2[0]['iduser'] != ''))
	  {
	   echo "sono in iduser" .$results2[0]['iduser'] . " ---- à";  
		
        $retu =  "-2";
	  }
	 else
	  { 
		 $db1->Open();
		 $sql = "insert into  idinvited (id_sender,friend_email) values ('".$_SESSION['iduser']."','".$email."')";
		 $results3 = $db1->Query($sql);
		 $db1->Close(); 
		 $retu =  "1";  
	  }
  } 
   
return $retu;
*/
}



?>
