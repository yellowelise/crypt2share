<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
if (!$_SESSION['iduser'])
 if ($_SESSION['iduser']<1)
  exit;

include("class/mysql.class.php");


function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return str_replace("&d=n","",$pageURL);
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
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.blockUI.js"></script>

 </head>

	<body style="background:transparent; cursor:pointer;" onload="load()">
<div class="container">		
<div class="row-fluid">
<div class="span4">Inserisci email</div>
<div class="span4"><input type="text" id="email" /></div>
<div class="span4"><input type="checkbox" id="add" checked="checked" > Aggiungi alla rubrica </div>
</div>
<div class="row-fluid">
<div class="span4">Oggetto mail</div>
<div class="span4"><input type="text" id="sub" /></div>
<div class="span4"></div>
</div>
<div class="row-fluid">
<div class="span4">Testo</div>
<div class="span4"><textarea id="testo"></textarea></div>
<div class="span4"></div>
</div>
<div class="row-fluid">
<div class="span4"></div>
<div class="span4"><button onclick="send()">Invita Amico</button></div>
<div class="span4"></div>
</div>

<div class="row-fluid">
<div class="span12"><h3>Cronologia inviti</h3></div>
</div>

<div id="history">

</div>


</div>

</body>   
</html>	
<script>
	
function load()
{
  var res = aPost("callback/invite_history.php",'');
  document.getElementById("history").innerHTML = res;
 
}
	
function send()
{
	
 	
  var email = document.getElementById("email").value;
  
  var confermi = confirm("Vuoi invitare il tuo amico mandando una mail a:" + email + "?");
  if (confermi) 
  if (email!='')
   {

	  var $param = "e=" + email;
	 // alert($param);	
	  var res = aPost("callback/invite_add.php",$param);
      if (res =='')
       {
          load();

          var subject = document.getElementById("sub").value;
	      var text = document.getElementById("testo").value;
		  var $param = "e=" + email + "&s=" + subject + "&t=" + text + "&l=" + "<? echo $_SESSION['site_address']?>";
		 // alert($param);	
		  var res = aPost("callback/sendMail.php",$param);
		  if (res != '')
		   if (res == '1')
		    {
		     alert('Email inviata');
             if (document.getElementById("add").checked === true)
              {
				  $param = "e=" + email;
				  aPost("callback/contacts_add.php",$param);
				  
			  }  
		    }
		   else
		    {
			 alert("errore: " + res);	 
			}  
        }
       else
        alert(res); 

  }		    
 else
  {
    alert("inserisci la mail del'amico da invitare");
  } 
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
