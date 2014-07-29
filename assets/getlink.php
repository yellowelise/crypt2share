<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
include('config.php');
$l = $_REQUEST['l'];
//echo $l;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
 <head>
  <title>Crypt2Share</title>
    <!-- Bootstrap -->
  <link href="https://www.crypt2share.com/app/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">

  <!-- Generic page styles -->
  <link rel="stylesheet" href="https://www.crypt2share.com/app/css/style.css">
 </head>

	<body style="background:transparent; cursor:pointer;">
<div class="row-fluid">
<div class="span12"><img src="https://www.crypt2share.com/files/2413/5481/6407/logook.png" /></div>
</div>
<div class="row-fluid">
<div class="span12"><hr /></div>
</div>

<?php


if (($_SESSION['iduser'])&&($_SESSION['iduser'] != ''))
   {
	   if (!file_exists($_SESSION['home'] . "files/Chrome EXT/"))
	    mkdir($_SESSION['home'] . "files/Chrome EXT/");
	
	
 
    $ch = curl_init($l);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
    $data = curl_exec($ch);
 
    curl_close($ch);
    $filename = basename($l);
    if (strpos($filename,"?") !== false)
     $filename = substr($filename,0,strpos($filename,"?"));
     
    //echo "FN: ".$filename; 
    file_put_contents($_SESSION['home'] . "files/Chrome EXT/" . $filename, $data);
	
	/*   $handle = fopen($l, 'rb');
	   $stream = stream_get_contents($handle,-1);
	   $data = stream_get_meta_data($handle);
	   
       file_put_contents($_SESSION['home'] . "files/Chrome EXT/" . basename($l),  $stream);
	  */
	   if (filesize($_SESSION['home'] . "files/Chrome EXT/" . $filename)< "2000")
	     {
		   echo "<div class='row-fluid><div class='span12'>Copiato in Chrome EXT/" . $filename . "<br />Ma potrebbero esserci degli errori, controlla il file.</div></div>";	  
		 }
	   else
	     {
	       echo "<div class='row-fluid><div class='span12'>Copiato in Chrome EXT/" . $filename . "</div></div>"; 
	     }
	   // get content link 
   }
 else
   {
	   echo "<div class='row-fluid'>
				<div class='span6'>Username:</div>
				<div class='span6'><input type='text' id='user' /></div>
			 </div>
			 <div class='row-fluid'>
				<div class='span6'>Password:</div>
				<div class='span6'><input type='password' id='pass' /></div>
			</div>
			<div class='row-fluid'>
				<div class='span6'></div>
				<div class='span6'><button onclick='login()'>Login</button></div>
			</div>";
   }
?>
<div class='row-fluid'><div class='span12'><hr /></div></div>
<div class="row-fluid">
<div class="span6"><button onclick='javascript:window.close()'>Chiudi</button></div>
<div class="span6"><button onclick=javascript:window.open('https://www.crypt2share.com/app/kc/browse.php','C2S','left=0,top=0,width=1024,height=700')>Vai a C2S</button></div>
</div>



</div>
</div>


</body>   
</html>	

<script>
	function login()
	 {
		 var u = document.getElementById('user').value;
		 var p = document.getElementById('pass').value;
		 var l = '<?php echo $l?>';
		 var param = "u=" + u + "&p=" + p;
		 //alert(param);
		 var res = aPost('callback/signin.php',param);
		  if (res == '')
		   {
			  // alert('getlink.php?'+l);
			   window.location.href='getlink.php?l='+l; 
		   }
		  else
		   {
			   document.getElementById('user').value = '';
		       document.getElementById('user').value = '';
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
</script>
