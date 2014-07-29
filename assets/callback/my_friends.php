<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");



  $db1 = new MySQL(true);
  if ($db1->Error()) $db1->Kill();
  $db1->Open();
  $sql = "select distinct username,iduser,email from users where (iduser in (select id1 from friendship where id2 = '".$_SESSION['iduser']."' and status = 1)) or (iduser in (select id2 from friendship where id1 = '".$_SESSION['iduser']."' and status = 1))";
  //echo $sql."<br />";
  $results = $db1->QueryArray($sql);
  $db1->Close();
  if ($results[0]['username'] !='')
  {
  $res = "<select id='friends'>";

  for ($i=0;$i<count($results);$i++)
   {
	   $res .=  "<option value='".$results[$i]['iduser']."'>" .$results[$i]['username'] . " (". $results[$i]['email'].")</option>"; 
   }
  $res .= "</select>";
  }
  else
  $res = "<button onclick='javascript:friendship()'>Vai a gestione amici</button>"; 
  
  echo $res;
?>
