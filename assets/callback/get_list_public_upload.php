<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
include("../class/mysql.class.php");


 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select path,ticket from  public_upload where user = '".$_SESSION['username']."'";
 //echo $sql . "\n";
 $results = $db1->QueryArray($sql);
 $db1->Close();
 $res = "<div class='row-fluid'><div class='span12'><h3>Condivisioni esistenti</h3></div></div>";
 if ($results)
 for ($i=0;$i < count($results);$i++)
  {
	  $res .= "<div class='row-fluid' id='cont_pu_".$i."'><div class='span1'><img src='../images/public.png' /></div><div class='span6'><h5>" . base64_decode($results[$i]['path']) . "</h5></div><div class='span3'>Ticket: <input type='text' value='".$results[$i]['ticket']."' style='width:80px;'></div><div class='span2'><img onclick=delete_public('".$results[$i]['path']."','pu_".$i."') src='../images/delete.png' style='cursor:pointer;' />&nbsp;Elimina condivisione</div></div>";
	  $res .= "<div class='row-fluid' id='hr_pu_".$i."'><div class='span12'><hr /></div></div>";
  }
 else
   $res .= "<div class='row-fluid'><div class='span12'><h5>Nessuna cartella condivisa</h5></div></div>";
   
echo $res;
?>
