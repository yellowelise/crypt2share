<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");


if (isset($_REQUEST['q']))
$pagesize = $_REQUEST['q']; 
else
$pagesize = 10;


if (isset($_REQUEST['s']))
$search = $_REQUEST['s'];
else
$search = '';


if (isset($_REQUEST['o']))
$option = $_REQUEST['o']; // o=1 : in attesa // o=2 : amici // 0=0 : cerca
else
$option = '0';


if (isset($_REQUEST['p']))
$page = $_REQUEST['p'] -1; 
else
$page = 0;


$json = array(
"code"=>"",
"page"=>0,
"how_many_per_page"=>0,
"total_items"=>0,
"total_pages"=>0,


);

$sql_limit = " limit ". ($page * $pagesize) . "," . $pagesize;


 
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 
 if ($option == '0')
  $sql = "select count(iduser) as q from users where username like '%".$search."%' and iduser <> '".$_SESSION['iduser']."'";

 if ($option == '2')
  $sql = "select count(iduser) as q from users where username like '%".$search."%' and iduser <> '".$_SESSION['iduser']."' and (iduser in (select id1 from friendship where id2 = '".$_SESSION['iduser']."' and status = '1') or iduser in (select id2 from friendship where id1 = '".$_SESSION['iduser']."' and status = '1'))  ";

 if ($option == '1')
  $sql = "select count(iduser) as q from users where username like '%".$search."%' and iduser <> '".$_SESSION['iduser']."' and (iduser in (select id1 from friendship where id2 = '".$_SESSION['iduser']."' and status = '-1') or iduser in (select id2 from friendship where id1 = '".$_SESSION['iduser']."' and status = '-1')) ";
 
 $results = $db1->QueryArray($sql);
 $db1->Close();


 $quanti = $results[0]["q"];


$json["total_items"] = $quanti;
if (($json["total_items"] % $pagesize) == 0)
$json['total_pages'] = floor($json["total_items"] / $pagesize);
else
$json['total_pages'] = floor($json["total_items"] / $pagesize)+1;

$json["how_many_per_page"] = $pagesize;
$json["page"] = $page +1;


 $db1->Open();
 
 if ($option == '0')
  $sql = "select username,iduser,email from users where username like '%".$search."%' and iduser <> '".$_SESSION['iduser']."' " .$sql_limit;

 if ($option == '2')
  $sql = "select username,iduser,email from users where username like '%".$search."%' and iduser <> '".$_SESSION['iduser']."' and (iduser in (select id1 from friendship where id2 = '".$_SESSION['iduser']."' and status = '1') or iduser in (select id2 from friendship where id1 = '".$_SESSION['iduser']."' and status = '1'))  " .$sql_limit;

 if ($option == '1')
  $sql = "select username,iduser,email from users where username like '%".$search."%' and iduser <> '".$_SESSION['iduser']."' and (iduser in (select id1 from friendship where id2 = '".$_SESSION['iduser']."' and status = '-1') or iduser in (select id2 from friendship where id1 = '".$_SESSION['iduser']."' and status = '-1')) " .$sql_limit;
 
 
 
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $db1->Close();
 if ($results)
 {
  $json["code"] = "200";	 
 for ($i=0;$i<count($results);$i++) 
  {
    $json["users"][$i]["id_user"] = $results[$i]['iduser'];
    $json["users"][$i]["username"] = $results[$i]['username'];
    $json["users"][$i]["email"] = $results[$i]['email'];
   
  }	  
  
  
 }
else //nessun risultato
 {
  $json["code"] = "415";	 
  
 } 

echo json_encode($json);
?>
