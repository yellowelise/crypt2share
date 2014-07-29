<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);


include("../config.php");
include("../class/mysql.class.php");

//print_r($_REQUEST);
$resource =  $_POST['resource'];
$data = $_POST['elm1'];

	 $db = new MySQL(true);
	 if ($db->Error()) $db->Kill();
	 $db->Open();
	 $sql = "delete from  mysite_contents  where resource = '".$resource."' and content_user = '".$_SESSION['username']."'";
	 //echo $sql."<br />";
	 $results = $db->Query($sql);
	 $sql = "insert into  mysite_contents  (resource,content,content_user,ip) values ('".$resource."','".utf8_encode($data)."','".$_SESSION['username']."','".$_SERVER['REMOTE_ADDR']."')";
	 //echo $sql."<br />";
	 $results = $db->Query($sql);
	 $db->Close();



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>MySite - Crypt2Share.com</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="/.mysite_template/1/js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="content.css" rel="stylesheet">
	<link href=".mysite_template/1/css/bootstrap.min.css" rel="stylesheet">
	<link href=".mysite_template/1/css/bootstrap-responsive.min.css" rel="stylesheet">
	
	<!-- <link href="/.site_template/1/css/style.css" rel="stylesheet"> -->
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="/.mysite_template/1/js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="img/favicon.png">
  -->
</head>
<body>
	<h1>Preview</h1>
	<?php echo "<button style='width:200px;height:40px;left:100px;' onclick=javascript:window.location.href='editor.php?r=".$resource."'>Torna alla modifica</button>"; ?>
	<?php echo "<div style='border:1px solid black;'>".$data."</div>"; ?>
</body> 
</html>
