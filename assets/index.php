<?php
session_start();
include("config.php");


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
 <head>
  <title>Crypt2Share</title>
    <!-- Bootstrap -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">

  <!-- Generic page styles -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/mob_style.css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.blockUI.js"></script>

 </head>

<body>
<div class="row-fluid">
	  <div class="span4">	
	  </div>	
	  <div class="span4">	
			<div class="row-fluid">
				  <div class="span12">	
					<h1><span >Login</span></h1>
				  </div>	
				</div>	 

				<div class="row-fluid">
				  <div class="span4">
					  Username	
				  </div>	
				  <div class="span8">
					  <input style="width:160px" type="text" id="a_user">	
				  </div>	
				</div>	 

				<div class="row-fluid">
				  <div class="span4">
					  Password	
				  </div>	
				  <div class="span8">
					  <input style="width:152px" type="password" id="a_pass">	
				  </div>	
				</div>	 

				<div class="row-fluid">
				  <div class="span4">
				  </div>	
				  <div class="span8">
					  <button onclick="login()">Login</button>	
				  </div>	
				</div>	 
	  </div>	
	  <div class="span4">	
	  </div>	

</div>

</body>   
</html>	




<script>
	var server = "<?php echo $_SESSION['app_address'];?>";
	//alert(server);
function login()
{
var $param = "u=" + document.getElementById("a_user").value + "&p=" + document.getElementById("a_pass").value;
//alert($param);
var res = aPost(server + "callback/signin.php",$param);
window.location.href = "../app/kc/browse.php";
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