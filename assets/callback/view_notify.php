<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);


include("../class/mysql.class.php");


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


function view_notify()
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select idnotification,title, text,from_not,not_date,status from notification where iduser = '".$_SESSION['iduser']."' order by not_date desc";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $db1->Close();
 $res = "<div class='container'><div class='row-fluid'><div class='span1'>Elimina</div><div class='span1'>Mittente</div><div class='span2'>Data</div><div class='span3'>Titolo</div><div class='span4'>Testo</div><div class='span1'>Stato</div></div>";
 for ($i=0;$i<count($results);$i++)
  {
	  $res .= "<div class='row-fluid'><div class='span1'><a href=javascript:h_delete_not('".$results[$i]['idnotification']."')><img src='themes/oxygen/img/icons/delete.png' /></a></div><div class='span1'>".$results[$i]['from_not']."</div><div class='span2'>".$results[$i]['not_date']."</div><div class='span3'>".$results[$i]['title']."</div><div class='span4'>".$results[$i]['text']."</div><div class='span1'>".$results[$i]['status']."</div></div>"; 
  }
return $res . "</div>";
}

echo view_notify();
?>
