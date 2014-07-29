<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");


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

function cry_dim($uploadticket,$file_size)
{
if ($file_size == 0)
 {	
  $db1 = new MySQL(true);
  if ($db1->Error()) $db1->Kill();
  $db1->Open();
  $sql = "select count(uploadticket) as q from cry_contents where uploadticket ='".$uploadticket."'";
 //echo $sql."<br />";
  $results = $db1->QueryArray($sql);
  $db1->Close();
  $q = $results[0]['q']*200000;
  return "~".format_size($q);	
 }
else
 {
  $q = $file_size;	  
  return format_size($q);	
 }  
  
}	


function findexts($filename) 
{ 
 $filename = strtolower($filename) ; 
 $exts = substr(strrchr($filename, '.'), 1);
 return $exts; 
}

 
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select distinct filename,uploadticket,date,file_size from crypted where iduser ='".$_SESSION['iduser']."'";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $db1->Close();
 $lastfile = '';
 echo "<div id=crfiles style='width:99%;'>";
 if ($results)
 {
 for ($i=0;$i<count($results);$i++) 
  {
   if ($lastfile!=$results[$i]['filename'] . $results[$i]['uploadticket'])
    {

//echo ( __FILE__ );
echo "<div class='crfile' style='float: left;overflow:auto;' onmouseover=startmq('".$results[$i]['uploadticket']."') onmouseout=stopmq('".$results[$i]['uploadticket']."')>
<div class='crthumb' ><div style='position:relative;height:100px;'>
<button onclick=delete_secure('".$results[$i]['uploadticket']."','".base64_encode( basename($results[$i]['filename']))."')><img src='themes/oxygen/img/icons/delete.png'></button>
<button onclick=share('".$results[$i]['uploadticket']."','".base64_encode(basename($results[$i]['filename']))."') style='float:right;'><img src='themes/oxygen/img/icons/share.png'></button>
<button onclick=download_cry('".$results[$i]['uploadticket']."','".base64_encode(basename($results[$i]['filename']))."') style='position:absolute;bottom:0;left:0;'><img src='themes/oxygen/img/icons/download.png'></button>
<button onclick=moveto_unsecure('".$results[$i]['uploadticket']."') style='position:absolute;bottom:0;right:0;'><img src='themes/oxygen/img/icons/decrypted.png'></button></div></div>
<div class='crname' style='display: block;'>
<marquee id='mq_".$results[$i]['uploadticket']."' behavior='scroll' direction='left'  scrollamount='1'> ".(basename($results[$i]['filename']))."</marquee></div>
<div class='crtime' style='display: block;'>".$results[$i]['date']."</div>
<div class='crsize' style='display: block;'>".cry_dim($results[$i]['uploadticket'],$results[$i]['file_size'])."</div>
</div>";



/*	 if (!$results[$i]['date'])
	  {
	   echo "<div class='row-fluid'><div class='span1'><img src='img.php?fn=images/".findexts($results[$i]['filename'])."_crypt.png&s=50' /></div><div class='span11'><h4>".$results[$i]['filename']."</h4></div></div>";
	  }
	 else
	  {
	   echo "<div class='row-fluid'><div class='span1'><img src='img.php?fn=images/".findexts($results[$i]['filename'])."_crypt.png&s=50' /></div><div class='span9'><h4>".$results[$i]['filename']."</h4></div><div class='span2'><h4>". $results[$i]['date']."</h4></div></div>";
	  } 
	 echo "<div class='row-fluid'>
	           <div class='span3'><a style='width:90%;height:25px;' class='btn' href='secure_download.php?id=".$results[$i]['uploadticket']."'><img src='images/download.png' />&nbsp;Download</a></div>
	           <div class='span3'><a style='width:90%;height:25px;' class='btn' onclick=moveto_unsecure('".$results[$i]['uploadticket']."') ><img src='images/decrypt.png' /> &nbsp;Move to Unsecure</a></div>
	           <div class='span3'><a style='width:90%;height:25px;' class='btn btn-danger' onclick=delete_secure('".$results[$i]['uploadticket']."')><i class='icon-trash icon-white'></i>&nbsp;<span>Delete</span></a></div>
	           <div class='span3'><a style='width:90%;height:25px;' href='share.php?id=".$results[$i]['uploadticket']."' class='btn' >SHARE</a></div>
	       </div>";  
     echo "<hr />";
     */ 
     $lastfile = $results[$i]['filename'] . $results[$i]['uploadticket'];
    }
  }
}
else
 {
	 echo "<div class='row-fluid'><div class='span12'><h3>Nessun File nella zona sicura</h3></div></div>";
	 echo "<div class='row-fluid'><div class='span12'><h5>Seleziona il file nel file manager e clicca su Crypt/Move to secure</h5></div></div>";
 }	  
 echo "</div>";
?>
