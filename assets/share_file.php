<?php
session_start();
//ini_set('display_errors', 'Off');
//ini_set('display_startup_errors', 'Off');
//error_reporting(0);

include("class/mysql.class.php");



$id = $_REQUEST['f'];
//$pass_decrypt = base64_encode($_REQUEST['pass']);
//$_SESSION['download_pass'] = $_REQUEST['pass'];
//echo $pass_decrypt . "<br>";
//$pass = sha1($_REQUEST['pass']);


//$path = dirname ( __FILE__ );


function curPageURL($id) {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return str_replace("f=".$id,"", $pageURL);
}

function insert_file_in_db($file)
{
	 $db1 = new MySQL(true);
	 if ($db1->Error()) $db1->Kill();
	 $db1->Open();
	 $sql = "insert into file_to_download (complete_path,username) values ('".$file."','".$_SESSION['username']."')";
	// echo $sql."<br />";
	 $results = $db1->Query($sql);
    //$last = $db1->GetLastInsertID;
	 $db1->Close();
    return $results;
}


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

function update_count($id)
{
	 $db1 = new MySQL(true);
	 if ($db1->Error()) $db1->Kill();
	 $db1->Open();
	 $sql = "update cry_contents set download_count = download_count + 1 where uploadticket ='".$id."'";
	 //echo $sql."<br />";
	 $results = $db1->Query($sql);
	 $db1->Close();

}
function update_view($id)
{
	 $db1 = new MySQL(true);
	 if ($db1->Error()) $db1->Kill();
	 $db1->Open();
	 $sql = "update cry_contents set download_view = download_view + 1 where uploadticket ='".$id."'";
	 //echo $sql."<br />";
	 $results = $db1->Query($sql);
	 $db1->Close();

}


function file_div($id,$pass)
 { 
	 $db1 = new MySQL(true);
	 if ($db1->Error()) $db1->Kill();
	 $db1->Open();
	 $sql = "select filename,uploadticket,hash_crypted,iduser from cry_contents where uploadticket ='".$id."' and hash_crypted = '".$pass."'";
	 //echo $sql."<br />";
	 $results = $db1->QueryArray($sql);
	 $db1->Close();
	 if ($results)
	 {
	  echo "<div class='row-fluid'><div class='span12'>	 <a href='index.php'> <img src='images/logook200.png' /><font style='font-size:34.5px;'><b>Crypt2Share.com</b></font></a></div></div>";  
      echo "<hr />";

	  echo "<div class='row-fluid'><div class='span1'><img src='img.php?fn=images/".findexts($results[0]['filename'])."_crypt.png&s=50' /></div><div class='span4' style='word-wrap:break-word;'><label>".$results[0]['filename']."</label></div><div class='span2'><a class='btn' onclick=download('".$results[0]['uploadticket']."','".$results[0]['hash_crypted']."') ><img src='images/download.png' />&nbsp;Download</a></div><div class='span2'>Share from: ".username_from_id($results[0]['iduser'])."</div><div class='span2'></div><div class='span1'></div></div>";  
     }
 }
function file_name($id)
 { 
	 $db1 = new MySQL(true);
	 if ($db1->Error()) $db1->Kill();
	 $db1->Open();
	 $sql = "select filename,uploadticket,hash_crypted,iduser from cry_contents where uploadticket ='".$id."'";
	 //echo $sql."<br />";
	 $results = $db1->QueryArray($sql);
	 $db1->Close();
	 if ($results){
		 
	  echo "<div class='row-fluid'><div class='span12'>	 <a href='index.php'> <img src='images/logook200.png' /><font style='font-size:34.5px;'><b>Crypt2Share.com</b></font></a></div></div>";  
      echo "<hr />";
	  echo "<div class='row-fluid'><div class='span1'><img src='img.php?fn=images/".findexts($results[0]['filename'])."_crypt.png&s=50' /></div><div class='span4' style='word-wrap:break-word;'><label>".$results[0]['filename']."</label></div><div class='span2'></div><div class='span2'>Share from: ".username_from_id($results[0]['iduser'])."</div><div class='span2'></div><div class='span1'></div></div>";  
      echo "<hr />";
	  echo "<div class='row-fluid'><div class='span2'>Usa questo indirizzo</div><div class='span8'><input type='text' style='width:100%;' value='".curPageURL($id)."'></div><div class='span2'></div></div>"; 
	  echo "<div class='row-fluid'><div class='span2'>Oppure</div><div class='span8'><button onclick='send()'>Send via Mail</button><div class='span2'></div></div>"; 
	    
  } 
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
 <head>
  <title>Crypt2Share</title>
    <!-- Bootstrap -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">

  <!-- Generic page styles -->
<link rel="stylesheet" href="css/style.css">

 </head>

	<body>
		
		
	<div class="container">

<hr />
  <div class="row-fluid">
	  <div class="span12">
	    <?php
	     $id_dwn = insert_file_in_db( $_SESSION['home'] . $id);// . "<br />";
	     echo "File da condividere: " . $id;
	     
	    ?>
	  </div> 
	<?php
	  echo "<div class='row-fluid'><div class='span2'>Usa questo indirizzo</div><div class='span8'><input type='text' style='width:100%;' value='".curPageURL($id)."id=".$id_dwn."'></div><div class='span2'></div></div>"; 
	  echo "<div class='row-fluid'><div class='span2'>Invia una mail</div><div class='span8'><button onclick='send()'>Send via Mail</button><div class='span2'></div></div>"; 
    ?>
  </div>	  

<hr />    


	</div>
	</html>	
<script>
	
function send()
{
  var email = prompt("Indirizzo email","inserisci l'indirizzo del destinatario");
  if (email)
   {
     var subject = prompt("Oggetto della mail","un file per te!");
		  var text = prompt("Small text","");
		  var $param = "e=" + email + "&s=" + subject + "&t=" + text + "&l=" + "<? echo $_SESSION['server_path'] . 'download_file.php?id=' .$id_dwn ;?>";
		  //alert($param);	
		  var res = aPost("callback/sendMail.php",$param);
		  if (res != '')
		   if (res == '1')
		    {
		     alert('Email inviata');
		    }
		   else
		    {
			 alert("errore: " + res);	 
			}  
  }		    
}

function download(id,hash)
{
	alert("la fase di decriptaggio potrebbe richiedere qualche minuto, attendi...");
	window.open('decrypt_download.php?id=' + id + '&h=' + hash,'Download','width=400,height=200');
}

function aPost(url, parameters)
{
		if (window.XMLHttpRequest) { AJAX=new XMLHttpRequest(); } 
		else {  AJAX=new ActiveXObject("Microsoft.XMLHTTP");  }
		
		if (AJAX) {
					AJAX.open("POST", url, false);
					AJAX.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					AJAX.send(parameters);
					
					return AJAX.responseText;                                         
		} else { return false; }     
}  
</script>
