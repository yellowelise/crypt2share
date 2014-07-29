<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

//if ((!$_SESSION['iduser']) || ($_SESSION['iduser']<1))
//  header("location: ../../index.php/signin");
$file = $_REQUEST['fn'];

function view_file($file)
{
$ext = strtolower(substr(strrchr($file, '.'), 1));
if (($ext == 'jpeg')||($ext == 'jpg')||($ext == 'gif')||($ext == 'png'))

 echo "<img src='".$_SESSION['server_path']."fb_share/".$file."' />";
 echo "<br /><br /><a href='".$_SESSION['server_path']."fb_share/".$file."'>Download: ".$file."</a><br />";
  
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
 <head>
  <title>Crypt2Share.com :: view shared file</title>
    <!-- Bootstrap -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">

  <!-- Generic page styles -->
<link rel="stylesheet" href="css/style.css">

 </head>

<body>
<div class="container">
	<div class="row-fluid">
	  <div class="span8">	
	  <a href="https://www.crypt2share.com"><img src="images/logook200.png" /><font style="font-size:34.5px;"><b>Crypt2Share.com</b></font></a>
	  </div>	
	  <div class="span4">
		  <h6>Unlimited disk space for your files</h6>	
		  <a class=btn href="https://www.crypt2share.com/index.php/registrati">Register for free</a><br />
	  </div>	
	</div>	 
<hr /><br /><br />
<?php
echo view_file($file);
?>

<script type="text/javascript">
var uri = 'http://impit.tradedoubler.com/imp?type(img)g(21125856)a(2199651)' + new String (Math.random()).substring (2, 11);
document.write('<a href="http://clk.tradedoubler.com/click?p=219515&a=2199651&g=21125856" target="_BLANK"><img src="'+uri+'" border=0></a>');
</script>

</div>			
<div style="position:absolute;top:0px;left:0px;">
<script type="text/javascript">
var uri = 'http://impit.tradedoubler.com/imp?type(img)g(20402794)a(2199651)' + new String (Math.random()).substring (2, 11);
document.write('<a href="http://clk.tradedoubler.com/click?p=219515&a=2199651&g=20402794" target="_BLANK"><img src="'+uri+'" border=0></a>');
</script>
</div>
<div style="position:absolute;top:0px;right:0px;">
<script type="text/javascript">
var uri = 'http://impit.tradedoubler.com/imp?type(img)g(21125846)a(2199651)' + new String (Math.random()).substring (2, 11);
document.write('<a href="http://clk.tradedoubler.com/click?p=219515&a=2199651&g=21125846" target="_BLANK"><img src="'+uri+'" border=0></a>');
</script>
</div>

</html>	
