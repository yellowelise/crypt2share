<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("class/mysql.class.php");
include("config.php");



$id = $_REQUEST['id'];
$download = $_REQUEST['d'];
$pass_decrypt = base64_encode($_REQUEST['pass']);
$_SESSION['download_pass'] = $_REQUEST['pass'];
//echo $pass_decrypt . "<br>";
$pass = sha1($_REQUEST['pass']);
$path = dirname ( __FILE__ );

if (file_exists($_SESSION['home'] .$id))
 {
	 $db1 = new MySQL(true);
	 if ($db1->Error()) $db1->Kill();
	 $db1->Open();
	 $sql = "select username from users where iduser ='".$id."'";
	// echo $sql."<br />";
	 $results = $db1->QueryArray($sql);
	return $results[0]['username'];
	  
 }


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


function send_via_mail($url)
{
	//mail(); 
}

function findexts($filename) 
{ 
 $filename = strtolower($filename) ; 
 $exts = substr(strrchr($filename, '.'), 1);
 return $exts; 
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

function valid_pass($pass,$id)
{
	 $db1 = new MySQL(true);
	 if ($db1->Error()) $db1->Kill();
	 $db1->Open();
	 $sql = "select filename from crypted where uploadticket ='".$id."' and hash_crypted = '".$pass."'";
	// echo $sql."<br />";
	 $results = $db1->QueryArray($sql);
	 $db1->Close();
	 if ($results)
	  if ($results[0]['filename'] != '')
	   return $results[0]['filename'];
	
}

function drop_contacts()
{
	 $db1 = new MySQL(true);
	 if ($db1->Error()) $db1->Kill();
	 $db1->Open();
	 $sql = "select * from contacts where iduser ='".$_SESSION['iduser']."' order by used desc";
	 // echo $sql."<br />";
	 $results = $db1->QueryArray($sql);
	 $db1->Close();
	 if ($results)
      {
    	$res = "<select id='db_contacts'>";
        $res .= "<option value='-1'>Seleziona tra i contatti</option>";
    	
    	 for ($k=0;$k<count($results);$k++)
    	  {
			  $res .= "<option value='".$results[$k]['email']."'>".$results[$k]['name']. " " . $results[$k]['last'] . " \"". $results[$k]['email']."\"</option>";
		  }
    	$res .= "</select>";
    	
	  }
     else
      {
    	$res = "<select id='db_contacts'>";
        $res .= "<option value='-1'>Nessun contatto</option>";
    	$res .= "</select>";
	  }
	 return $res; 
}

function file_div($id,$pass)
 { 
	 $db1 = new MySQL(true);
	 if ($db1->Error()) $db1->Kill();
	 $db1->Open();
	 $sql = "select filename,uploadticket,hash_crypted,iduser from crypted where uploadticket ='".$id."' and hash_crypted = '".$pass."'";
	 //echo $sql."<br />";
	 $results = $db1->QueryArray($sql);
	 $db1->Close();
	 if ($results)
	 {
      $copy="<button onclick='login()'>login per copiare nel tuo ambiente</button>";
      if ($_SESSION['iduser'])
       if ($_SESSION['iduser']>0)
        $copy = "<button onclick=javascript:decrypt_shared(".$results[0]['uploadticket'].")><img src='images/download.png' />&nbsp;Copia nell'ambiente di ".$_SESSION['username']."</button>";
  

	  echo "
	  <div class='row-fluid'>
	  <div class='span12'>
	  <a href='".$_SESSION['site_address']."'><img src='images/logook200.png' /> Crypt2Share.com</a>
	  </div>
	  </div> ";	
	  
	    
	  echo "
	  <div class='row-fluid'>
	  <div class='span4' style='word-wrap:break-word;'>
	  <h3>".$results[0]['filename']."</h3>
	  </div>
	  <div class='span2'>
	  <button onclick=javascript:download('".$results[0]['uploadticket']."','".$results[0]['hash_crypted']."') ><img src='images/download.png' />&nbsp;Download</button>
	  </div>
	  <div class='span4'>".$copy."
	  </div>
	  
	  <div class='span2'>Share from: ".username_from_id($results[0]['iduser'])."
	  </div>
	  </div>";  
      
   }  
 }
function file_name($id)
 { 
	 $db1 = new MySQL(true);
	 if ($db1->Error()) $db1->Kill();
	 $db1->Open();
	 $sql = "select filename,uploadticket,hash_crypted,iduser from crypted where uploadticket ='".$id."' limit 1";
	 //echo $sql."<br />";
	 $results = $db1->QueryArray($sql);
	 $db1->Close();
	 if ($results){
	  	 
	  echo "<div class='row-fluid'><div class='span10' style='word-wrap:break-word;'><h3>".$results[0]['filename']."</h3></div><div class='span2'>Share from: ".username_from_id($results[0]['iduser'])."</div></div>";  
      //echo "<hr />";
	  if (isset($_SESSION['iduser']) && ($results[0]['iduser'] == $_SESSION['iduser']))
	   {
	    echo "
	    <div class='row-fluid'>
	    <div class='span2'>Opzione 1<br /><font style='font-size:10px;'>Copia il link ed invialo come meglio credi</font>
	    </div>
	    <div class='span6'>Usa questo indirizzo: <input type='text' style='width:100%;' value='".curPageURL()."'>
	    </div>
	    </div>"; 
        echo "<div class='row-fluid'><div class='span12'><hr /></div></div>";  
	    echo "
	    <div class='row-fluid'>
	    <div class='span2'>Opzione 2<br /><font style='font-size:10px;'>Invia una mail con le istruzioni per il download</font>
	    </div>
	    <div class='span3'>Nuovo:<br /><input type='text' id='new_contact' /> 
	    </div>
	    <div class='span3'>Esistente:<br />".drop_contacts()."
	    </div>
	    <div class='span4'><button class='btn' onclick='send()'>Send via Mail</button></div>
	    </div>"; 
        echo "<div class='row-fluid'><div class='span12'><hr /></div></div>";  
	    echo "
	    <div class='row-fluid'>
	    <div class='span2'>Opzione 3<br /><font style='font-size:10px;'>Manda una notifica ad uno dei tuoi amici.</font>
	    </div>
	    <div id='my_friends' class='span6'>
	    </div>
	    <div class='span4'><button class='btn' onclick=notify('".$id."')>Manda ad un amico</button></div>
	    </div>";
	   } 
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
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.blockUI.js"></script>

 </head>

	<body style="background: transparent;" <? if (isset($_SESSION['iduser'])) echo "onload='my_friend()'"; ?> >
<div class="container">
	<? if ((valid_pass($pass,$id) != null) && (valid_pass($pass,$id) != ''))
	 { 
	  update_count($id);
	  echo file_div($id,$pass);
     }
    else
     {
	   update_view($id);
	   //echo $download;
       if ($download != 'n')
        {		  
          	  echo "<div class='row-fluid'><div class='span12'><a href='".$_SESSION['site_address']."'><img src='images/logook200.png' /> Crypt2Share.com</a></div>";	  

          
          file_name($id);
		  if (isset($_POST['pass']))
		  echo "<br /><h4>Password errata!!!</h4>";
		  echo "<div class='row-fluid'><div class='span12'><h1>Per Scaricare il file:</h1></div></div>";  

		  echo "<form action='#' method='POST'><div class='row-fluid'><div class='span4'>Password di decriptaggio</div><div class='span4'><input type='password' name='pass' /></div><div class='span4'><button>Decripta e Scarica</button></div></div></form>";

        }
       else
        {
          file_name($id);
			 
		} 
     } 
    ?>

</div>
</body>   
	</html>	
<script>

function decrypt_shared(id)
{
	non_rompere = 1;	
	var pass = '<? echo $_SESSION['download_pass']?>'; 
	if (pass)
	 {
		var $param = "id=" + id + "&p=" + pass;
		var res = aPost("callback/decrypt_copy.php",$param);
		if (res == '')
		 {
		$.blockUI({ message: '<div id="downloading" ><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="kc/themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a><br /><h3>File copiato nel tuo ambiente</h3></div>', css: { 
   		height: ($(window).height() - 100) +'px',
		width: ($(window).width() -100) + 'px',
		top: "50px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "50px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
            
	     }
	    else 
         {
			 alert("Errore, prova il download!"); 
		 }

     }
}

	
function send()
{
  var email = document.getElementById("db_contacts").value;
  if (email == '-1')
   {
    email = document.getElementById("new_contact").value;
   // alert(email);
    var param = "e=" + email;	
    var res = aPost("callback/contacts_add.php",param);
   }
  
  var confermi = confirm("Vuoi inviare una segnalazione via mail all'indirizzo:" + email);
  if (confermi) 
  if (email!='')
   {
     var subject = prompt("Oggetto della mail","un file per te!");
		  var text = prompt("Small text","");
		  var $param = "e=" + email + "&s=" + subject + "&t=" + text + "&l=" + "<? echo curPageURL();?>";
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
 else
  {
    alert("inserisci la mail del nuovo contatto o selezionalo dai tuoi contatti.");
  } 
}

function _send()
{
  var email = prompt("Indirizzo email","inserisci l'indirizzo del destinatario");
  if (email)
   {
     var subject = prompt("Oggetto della mail","un file per te!");
		  var text = prompt("Small text","");
		  var $param = "e=" + email + "&s=" + subject + "&t=" + text + "&l=" + "<? echo curPageURL();?>";
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
//	alert('decrypt_download.php?id='+id+'"&h=' + hash);
		$.blockUI({ message: '<div id="downloading" style="width:100%;height:100%;"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="kc/themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a><br /><h3>Scarica il file<br />Controlla i progressi nella finestra di download.</h3> <br /><iframe frameborder=0 src="decrypt_download.php?id='+id+'&h=' + hash + '"></iframe></div>', css: { 
   		height: ($(window).height() - 150) +'px',
		width: ($(window).width()/2) + 'px',
		top: "75px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: (($(window).width()/2)/2) + "px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
     setTimeout($.unblockUI, 5000); 
	//alert("la fase di decriptaggio potrebbe richiedere qualche minuto, attendi...");
	//window.open('decrypt_download.php?id=' + id + '&h=' + hash,'Download','width=200,height=200');
}


function login()
{
//	alert('decrypt_download.php?id='+id+'"&h=' + hash);
		$.blockUI({ message: '<div id="login" style="width:100%;height:100%;"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="kc/themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a><div style="position:absolute;top:60px;left:20px;"><div class="row-fluid"><div class="span4">	Username:</div>	<div class="span8">	<input type="text" id="username" />	</div>	</div>	<div class="row-fluid">	<div class="span4">	Password:	</div><div class="span8"><input type="password" id="password" /><input type="hidden" id="pass" value="<? echo $_SESSION['download_pass']?>" /></div></div><div class="row-fluid"><div class="span4"></div><div class="span8"><button onclick="signin()">Signin</button></div></div></div>	</div>', css: { 
   		height: "250px", //($(window).height() - 150) +'px',
		width: "500px", //($(window).width() - 150) + 'px',
		top: (($(window).height() - 250)/2) + "px",
		left:(($(window).width() - 500)/2) + "px"// "75px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
   //  setTimeout($.unblockUI, 5000); 
	//alert("la fase di decriptaggio potrebbe richiedere qualche minuto, attendi...");
	//window.open('decrypt_download.php?id=' + id + '&h=' + hash,'Download','width=200,height=200');
}
function signin()
{
	var u = document.getElementById("username").value;
	var p =document.getElementById("password").value;
	var param = "u=" + u + "&p=" + p;
	res = aPost("callback/signin.php",param);
	if (res == '')
	 {
		 parent.window.location.href = '<?echo curPageURL() . "&pass=" . $_SESSION['download_pass'];?>'; 
	 }
	else
	 {
		 alert(res); 
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

function notify(ut)
{
	var id = document.getElementById("friends").value;
	//alert('ut: ' + ut + ' ida:' +id);
	var param = "ut=" + ut + "&id=" + id;
	var res = aPost("callback/notify.php",param);
    alert("Hai mandato una notifica a: " + res);
    
    
    var $param = "e=" + res + "&s=Un file per te&t=ciao, <?echo $_SESSION['username']?> ha condiviso un file con te.&l=" + "<? echo $_SESSION['site_address'];?>";
		  //alert($param);	
	res = aPost("callback/sendMail.php",$param);
    // parent.window.location.reload();
}

function my_friend()
{
	var param = "";
	var res = aPost("callback/my_friends.php");
	document.getElementById("my_friends").innerHTML = res ;
}

 function close()
{
	$.unblockUI();
	non_rompere = 0;
}    

</script>
