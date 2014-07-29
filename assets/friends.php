<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("class/mysql.class.php");
include("config.php");
$s = $_GET['s'];

if (($s == '') || (!$_GET['s']) || ($s == '1'))
 {
  $s = '1';	  
  $s1_class = "class='active'";
  $s2_class = "";
  $s3_class = "";
  $onload = "onload='cerca()'";
 }
if ($s =='2')
 {
  $s2_class = "class='active'";
  $s1_class = "";
  $s3_class = "";
  $onload = "onload='in_attesa()'";
 }
if ($s =='3')
 {
  $s3_class = "class='active'";
  $s1_class = "";
  $s2_class = "";
  $onload = "onload='amici()'";
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

<body style="background: transparent; cursor:pointer;" <?php echo $onload; ?>>
 <div class="container">
  <div class="row-fluid">
   <div class="span12">
    <ul class="nav nav-tabs">
     <li <?php echo $s1_class;?> ><a href="friends.php?s=1">Cerca Utenti</a></li>
     <li <?php echo $s2_class;?> ><a href="friends.php?s=2">Richieste in attesa</a></li>
     <li <?php echo $s3_class;?> ><a href="friends.php?s=3">I miei amici</a></li>
    </ul>
    </div>
   </div>	 

<?php
 if ($s == '1')
  {
?>
  <div class="row-fluid">
   <div class="span12"><h4>Cerca Utenti</h4></div>
  </div>
  <div class="row-fluid">
   <div class="span2">Ricerca Utente:</div><div class="span9"><input style="width:100%" type="text" id="search" /></div><div class="span1"><button class="btn" onclick="cerca()">Cerca</button></div>
  </div>
  <div class="row-fluid">
   <div class="span12"><hr /></div>
  </div>
<?
  }
 if ($s == '2')
  {
?>
  <div class="row-fluid">
   <div class="span12"><h4>Richieste in attesa di risposta</h4></div>
  </div>
  <div class="row-fluid">
   <div class="span2">Ricerca Utente:</div><div class="span9"><input style="width:100%" type="text" id="search" /></div><div class="span1"><button class="btn" onclick="in_attesa()">Cerca</button></div>
  </div>
  <div class="row-fluid">
   <div class="span12"><hr /></div>
  </div>
<?
  }
 if ($s == '3')
  {
?>
  <div class="row-fluid">
   <div class="span12"><h4>I miei amici</h4></div>
  </div>
  <div class="row-fluid">
   <div class="span2">Ricerca Utente:</div><div class="span9"><input style="width:100%" type="text" id="search" /></div><div class="span1"><button class="btn" onclick="amici()">Cerca</button></div>
  </div>
  <div class="row-fluid">
   <div class="span12"><hr /></div>
  </div>

<?
  }
  ?>
  <div id="search_res"></div>
 </div>  
</body>   
</html>	




<script>
	
function remove(id)
{
	var $param = "id=" + id;
	var res = aPost("callback/friend_rem.php",$param);
//	alert(res);
  <?
    if ($s =='1')
	  echo "cerca();";
    if ($s =='2')
	  echo "in_attesa();";
    if ($s =='3')
	  echo "amici();";
?>
}
function reject(id)
{
	var $param = "id=" + id;
	var res = aPost("callback/friend_rej.php",$param);
	//alert(res);
  <?
    if ($s =='1')
	  echo "cerca();";
    if ($s =='2')
	  echo "in_attesa();";
    if ($s =='3')
	  echo "amici();";
?>

}
function accept(id)
{
	var $param = "id=" + id;
	var res = aPost("callback/friend_acp.php",$param);
//	alert(res);
  <?
    if ($s =='1')
	  echo "cerca();";
    if ($s =='2')
	  echo "in_attesa();";
    if ($s =='3')
	  echo "amici();";
?>

}
	
function request(id)
{
	var $param = "id=" + id;
	var res = aPost("callback/friend_add.php",$param);
//	alert(res);
  <?
    if ($s =='1')
	  echo "cerca();";
    if ($s =='2')
	  echo "in_attesa();";
    if ($s =='3')
	  echo "amici();";
?>

}
	
function cerca(p)
{
    if (p == 'undefined')
	 p = 0;

//	alert(document.getElementById("search").value);
	var $param = "s=" + document.getElementById("search").value + "&o=0&p=" + p;
	var res = aPost("callback/friend_search.php",$param);
	document.getElementById("search_res").innerHTML = res;
}	

function in_attesa(p)
{
	if (p == 'undefined')
	 p = 0;
//	alert(document.getElementById("search").value);
	var $param = "s=" + document.getElementById("search").value + "&o=1&p=" + p;
	var res = aPost("callback/friend_search.php",$param);
	document.getElementById("search_res").innerHTML = res;
}	



function amici(p)
{
	if (p == 'undefined')
	 p = 0;
//	alert(document.getElementById("search").value);
	var $param = "s=" + document.getElementById("search").value + "&o=2&p=" + p ;
	var res = aPost("callback/friend_search.php",$param);
	document.getElementById("search_res").innerHTML = res;
}	


function friend_prev(pag,search,option)
{
//	alert(pag + " - " + search + " - " + option);
if (option == '2')	
	amici(pag);
if (option == '1')	
	in_attesa(pag);
if (option == '0')	
	cerca(pag);
	
}

function friend_next(pag,search,option)
{
	//alert(pag + " - " + search + " - " + option);
if (option == '2')	
	amici(pag);
if (option == '1')	
	in_attesa(pag);
if (option == '0')	
	cerca(pag);
	
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
