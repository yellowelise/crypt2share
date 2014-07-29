<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");

$pagesize = 6;


if (isset($_REQUEST['s']))
$search = $_REQUEST['s'];
else
$search = '';
if (isset($_REQUEST['o']))
$option = $_REQUEST['o']; // o=1 : in attesa // o=2 : amici // 0=0 : cerca
else
$option = '0';


if (isset($_REQUEST['p']))
$page = $_REQUEST['p']; 
else
$page = 0;


$sql_limit = " limit ". ($page * $pagesize) . "," . $pagesize;

//echo $_REQUEST['p'];
if ($page > 0)
 {
	 $prev_page = $page - 1; 
	 $succ_page = $page + 1; 
	 
 }
else
 {
	 $prev_page = 0; 
	 $succ_page = $page + 1; 
	 $prev_disable = "disabled";
 } 

function buttonize($id)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select status,id1,id2 from friendship where (id1 =  '".$id."' or id1='".$_SESSION['iduser']."') and (id2 =  '".$id."' or id2='".$_SESSION['iduser']."')";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 
 $db1->Close();
 $ret = '';
if ($results)
 {
	// echo "tuoid:" . $_SESSION['iduser'] ." - " . $results[0]['status'] . " id1:".$results[0]['id1'] . " id2:" . $results[0]['id2'];
	 if ($results[0]['status'] == '-1') 
	  {
    	 if (($results[0]['id1'] == $_SESSION['iduser']) and ($results[0]['id2'] == $id)) //appeso ed inserita da te
		  $ret = "<div class='span3'><span>Hai inviato la richiesta</span></div><div class='span3'><button class='btn' style='width:145px;' onclick='remove(".$id.")'>Annulla</button></div>"; 
    	 if (($results[0]['id2'] == $_SESSION['iduser']) and ($results[0]['id1'] == $id)) //appeso ed inserita dal'altro
		  $ret =  "<div class='span3'><span>Richiesta di amicizia</span></div><div class='span3'><button class='btn' style='width:70px;'  onclick='reject(".$id.")'>Rifiuta</button>&nbsp;<button class='btn' style='width:70px;'  onclick='accept(".$id.")'>Accetta</button></div>"; 
	  }
	 if ($results[0]['status'] == '1') //già amici
	  {
		  $ret = "<div class='span3'><span>Amico</span></div><div class='span3'><button class='btn' style='width:145px;' onclick='remove(".$id.")'>Rimuovi da Amici</button></div>"; 
	  }
	 if ($results[0]['status'] == '2') //già amici
	  {
         
		  $ret = "<div class='span6'><span>Non potete essere amici</span></div>"; 
	  }
   
 }	

if ($ret == '')
  return "<div class='span3'></div><div class='span3'><button class='btn' style='width:145px;'  onclick=request('".$id."')>Richiedi Amicizia</button></div>";
else
  return $ret;  
}
 
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 
 if ($option == '0')
  $sql = "select username,iduser from users where username like '%".$search."%' and iduser <> '".$_SESSION['iduser']."' " .$sql_limit;

 if ($option == '2')
  $sql = "select username,iduser from users where username like '%".$search."%' and iduser <> '".$_SESSION['iduser']."' and (iduser in (select id1 from friendship where id2 = '".$_SESSION['iduser']."' and status = '1') or iduser in (select id2 from friendship where id1 = '".$_SESSION['iduser']."' and status = '1'))  " .$sql_limit;

 if ($option == '1')
  $sql = "select username,iduser from users where username like '%".$search."%' and iduser <> '".$_SESSION['iduser']."' and (iduser in (select id1 from friendship where id2 = '".$_SESSION['iduser']."' and status = '-1') or iduser in (select id2 from friendship where id1 = '".$_SESSION['iduser']."' and status = '-1')) " .$sql_limit;
 
 
 
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $db1->Close();
 if ($results)
 {
 for ($i=0;$i<count($results);$i++) 
  {
    echo "<div class='row-fluid'><div class='span6'>".$results[$i]['username']."</div>".buttonize($results[$i]['iduser'])."</div>";
  }	  
  echo '<ul class="pager">
    <li class="previous '.$prev_disable.'">
    <a href=javascript:friend_prev('.$prev_page.',"'.$search.'","'.$option.'")>&larr; Precedenti</a>
    </li>
    <li class="next '.$next_disable.'">
    <a href=javascript:friend_next('.$succ_page.',"'.$search.'","'.$option.'")>Successivi &rarr;</a>
    </li>
    </ul>';	 
 }
else
 {
  echo "<div class='row-fluid'><div class='span12'><h4>Non ci sono altri dati da visualizzare.</h4> </div></div>";
	 
  echo '<ul class="pager">
    <li class="previous '.$prev_disable.'">
    <a href=javascript:friend_prev('.$prev_page.',"'.$search.'","'.$option.'")>&larr; Precedenti</a>
    </li>
    <li class="next disabled">
    <a href=javascript:friend_next('.$succ_page.',"'.$search.'","'.$option.'")>Successivi &rarr;</a>
    </li>
    </ul>';	 	 
 } 

?>
