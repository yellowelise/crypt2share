<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");


function invite_history()
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();

 $sql = "select * from invited where id_sender = '".$_SESSION['iduser']."'";
 $results = $db1->QueryArray($sql);
 $db1->Close(); 
 if ($results)
  {
	for ($i = 0; $i < count($results); $i++)  
	 {
		$res .= "<div class='row-fluid'>";  
		$res .= "<div class='span4'>" . $results[$i]['friend_email'] . "</div>";
		$res .= "<div class='span4'>" . $results[$i]['invite_date'] . "</div>";
		if ($results[$i]['counted'] == '0')
		 {
		  $res .= "<div class='span2'>Non Ancora iscritto</div>";
		  $res .= "<div class='span2'></div>";
		 }
		else 
		 {
		  $res .= "<div class='span2'>Iscritto grazie a te</div>";
		  $res .= "<div class='span2'>Hai guadagnato 10MB</div>";
		 }
		$res .= "</div>"; 
     }
  } 
   
return $res;
}


echo invite_history();
?>
