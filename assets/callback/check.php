<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");



  $db1 = new MySQL(true);
  if ($db1->Error()) $db1->Kill();
  $db1->Open();
  $sql = "select * from notification where iduser = '".$_SESSION['iduser']."' and status = '-1' order by idnotification desc";
  //echo $sql."<br />";
  $results = $db1->QueryArray($sql);
  $db1->Close();
  if ($results)
  {
  echo "<div><img style='position:absolute;left:10px;cursor:pointer;' src='themes/oxygen/img/icons/delete_all.png' onclick=notification_read('-1') /> Elimina tutti<br /><hr><div id='notific'>"; 
  for ($i=0;$i<count($results);$i++)
   {
	   echo "<div style='border-bottom: 1px solid white;' id='not_".$results[$i]['idnotification']."'><img style='position:absolute;left:10px;cursor:pointer;' src='themes/oxygen/img/icons/delete.png' onclick=notification_read('".$results[$i]['idnotification']."') /><span>".$results[$i]['not_date']."</span><label>".$results[$i]['from_not']. ": ".$results[$i]['title']."</label><label>".$results[$i]['text']."</label></div>"; 
   }
  echo "</div></div>";
}
?>
