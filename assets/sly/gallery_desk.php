<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
$json_res = array(
"index"=>0,
"files"=>array()
);

include("../class/mysql.class.php");



if (isset($_REQUEST['w']))
 $w = ($_REQUEST['w']);
else
 $w = 900;


//echo $w;
if (isset($_REQUEST['h']))
 $hei = ($_REQUEST['h'] - 180);
else
 $hei = 500;


if (isset($_REQUEST['d']))
 $d = $_REQUEST['d'];
else
 $d = "files/";

if (isset($_REQUEST['q']))
 $q = $_REQUEST['q'];
else
 $q = 3;

if (isset($_REQUEST['f']))
 $f = $_REQUEST['f'];
else
 $f = "";

//echo $f ."<br />";
//echo $d ."<br />";

function url_encode($string){
        return urlencode(utf8_encode($string));
    }
 


$h = $_SESSION['home'] . $d . "/"; //Open the current directory
//echo "<br />----".$h;
$index = 0;
$list = glob($h."{*.jpg,*.gif,*.png,*.JPG,*.GIF,*.PNG,*.JPEG,*.jpeg}", GLOB_BRACE);
//print_r($list);
array_multisort($list, SORT_ASC, SORT_STRING);
for ($i=0;$i<count($list);$i++)
 {
	 $list[$i] = str_replace($h,"",$list[$i]); 
	 if ($list[$i] == $f)
	  $index = $i;
 }

// print_r($list);
?>

<!DOCTYPE html>
<html class=" js csstransforms csstransforms3d" lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>C2S gallery</title>
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="normalize.css">
	<link rel="stylesheet" href="font-awesome.css">
	<link rel="stylesheet" href="ospb.css">
	<link rel="stylesheet" href="horizontal.css">
	<script src="ga.js"></script>
	<script src="modernizr.js"></script>
</head>
<body>
	<div class="pagespan container" style="width:100%;text-align:center">
		<?php
		echo "<img id='image_v' alt='Caricamento...' src='../usr_img.php?fn=".$d.$f."&w=".($w - 200)."&h=".($hei-20)."'>";
		//echo "".$f."&w=".($w - 200)."&h=".($hei-20)."";
?>
	</div>

	<!-- Scripts -->
	<script src="jquery.js"></script>
	<script src="plugins.js"></script>
	<script src="sly.js"></script>
	<script src="horizontal.js"></script>

</body></html>
<script>
	$(window).resize(function(){
		//alert("res");
		var src = '../usr_img.php?fn=<?php echo urlencode($d.$f);?>&w=' + $(this).width() + '&h='+ $(this).height();
		//alert(src);
		$("#image_v").prop("src",src);
		});
</script>	
