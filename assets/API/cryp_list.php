<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");




$json_header = array(
"code"=>"",
"page"=>0,
"how_many_per_page"=>0,
"total_items"=>0,
"total_pages"=>0,
//"order"=>"",
"files"=>array()
);

if (isset($_REQUEST['p']))
 $p = $_REQUEST['p'];
else
 $p = 1;

$json_header['page'] = $p;


if (isset($_REQUEST['q']))
 $q = $_REQUEST['q'];
else
 $q = 15;

$json_header['how_many_per_page'] = $q;

  



//$a = session_id();
//if(empty($a)) session_start();
//echo "SID: ".SID."<br>session_id(): ".session_id()."<br>COOKIE: ".$_COOKIE["PHPSESSID"]."<br />";
//echo "un: ".$_SESSION['username'];
function format_size($size) {

    $mod = 1024;

    $units = explode(' ','B KB MB GB TB PB');

    for ($i = 0; $size > $mod; $i++) {

        $size /= $mod;
    }

    return round($size, 2) . ' ' . $units[$i];
}

 
if (isset($_SESSION['iduser']))
{ 
  
$start = ($p - 1) * $q;
$stop = $q;

 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select count(distinct uploadticket) as q from crypted where iduser ='".$_SESSION['iduser']."'";
 //echo $sql."<br />";
 $res = $db1->QueryArray($sql);
 $db1->Close();
 $quanti = $res[0]['q'];
 
 $db1->Open();
 $sql = "select distinct filename,uploadticket,date,file_size from crypted where iduser ='".$_SESSION['iduser']."' limit ".$start.",".$stop;
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $db1->Close();
 $lastfile = '';
 if ($results)
 {
 for ($i=0;$i<count($results);$i++) 
  {
    $json_header["files"][$i]['filename'] = basename($results[$i]['filename']);
    $json_header["files"][$i]['uploadticket'] = $results[$i]['uploadticket'];
    $json_header["files"][$i]['unsecure_path'] = str_replace(basename($results[$i]['filename']),"",$results[$i]['filename']);
    
    $json_header["files"][$i]['size'] = $results[$i]['file_size'];
    $json_header["files"][$i]['human_size'] = format_size($results[$i]['file_size']);
    $json_header["files"][$i]['last_modified'] = $results[$i]['date'];
    $json_header["files"][$i]['extension'] = substr(strrchr($results[$i]['filename'], '.'), 1);
  }


$json_header["total_items"] = $quanti;

if (($json_header["total_items"] % $q) == 0)
$json_header['total_pages'] = floor($json_header["total_items"] / $q);
else
$json_header['total_pages'] = floor($json_header["total_items"] / $q)+1;

$json_header['code'] = "200";//"OK";

}
else
$json_header['code'] = "405";//"Nessun file criptato";
	
}
else
$json_header['code'] = "100";
 
 
     echo json_encode($json_header);

?>
