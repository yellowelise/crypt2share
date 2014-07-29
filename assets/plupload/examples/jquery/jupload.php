<?php
session_start();
include("../../../config.php");

$path = urldecode($_REQUEST['p']);
$_SESSION['up_path'] = $path;

//echo "PATH: ".$path;
if ($_REQUEST['u'])
 {
 // $_SESSION['username'] = base64_decode($_REQUEST['u']);
  $_SESSION['ext_user'] = base64_decode($_REQUEST['u']);
 }
else
 {
	 $_SESSION['ext_user'] = '';
 } 
 
 //echo "username: ".$_SESSION['username'] . " - ext_user: " .$_SESSION['ext_user'] . "<br ><br >";
 
if ($_REQUEST['m'])
 $_SESSION['max_file_size'] = base64_decode($_REQUEST['m']);
if ($_REQUEST['n'])
 $_SESSION['max_number_of_files'] = base64_decode($_REQUEST['n']);
 
//echo  $_SESSION['username'];
function format_size($size) {

    $mod = 1024;

    $units = explode(' ','B KB MB GB TB PB');

    for ($i = 0; $size > $mod; $i++) {

        $size /= $mod;
    }

    return round($size, 2) . ' ' . $units[$i];
}

$_SESSION['this_time'] = 0 ; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<title>Plupload - jQuery UI Widget</title>
<style type="text/css">
	body {
		font-family:Verdana, Geneva, sans-serif;
		font-size:13px;
		color:#333;
		background:url(../bg.jpg);
	}
</style>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" />
<link rel="stylesheet" href="https://www.crypt2share.com/app/bootstrap/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="../../js/jquery.ui.plupload/css/jquery.ui.plupload.css" type="text/css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../js/bp.js"></script>

<script type="text/javascript" src="../../js/plupload.js"></script>
<script type="text/javascript" src="../../js/plupload.gears.js"></script>
<script type="text/javascript" src="../../js/plupload.silverlight.js"></script>
<script type="text/javascript" src="../../js/plupload.flash.js"></script>
<script type="text/javascript" src="../../js/plupload.browserplus.js"></script>
<script type="text/javascript" src="../../js/plupload.html4.js"></script>
<script type="text/javascript" src="../../js/plupload.html5.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.plupload/jquery.ui.plupload.js"></script>

</head>
<body>
<div class="row-fluid">
 <div class="span2">		
  <div class="row-fluid" style="text-align:center"><a href="../../../donate.php" target="_BLANK">Crypt2Share è gratuito, ma non è a costo zero per noi, aiutaci donando.</a></div>
 </div>
 <div class="span8">		
  <div class="row-fluid" style="text-align:center"><h4>Cartella selezionata: <?echo $_SESSION['up_path']?></h4></div>
  <div class="row-fluid" style="text-align:center"><h5>Dimensione massima singolo file: <?echo format_size($_SESSION['max_file_size'])?></h5></div>
  <div class="row-fluid" style="text-align:center"><h5>Numero massimo file simultanei: <?echo $_SESSION['max_number_of_files']?></h5></div>
 </div>
 <div class="span2">		
  <div class="row-fluid" style="text-align:center"><a href="../../../donate.php" target="_BLANK">Abbiamo deciso di rimuovere la pubblicità ma non perché non abbiamo bisogno di aiuto, DONA ora.</a></div>
 </div>
 </div>

<form  method="post" action="../dump.php">
	<div id="uploader" style="float:left;width: 99%;">
		<p>Your browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
	</div>
</form>

<script type="text/javascript">
	//alert('<?php echo round(($_SESSION['max_file_size']/1024)/1024) ?>mb');
// Convert divs to queue widgets when the DOM is ready
$(function() {
	$("#uploader").plupload({
		// General settings
		runtimes : 'html5,flash,browserplus,silverlight,gears,html4',
		url : '../upload.php',
		max_file_size : '<?php echo round(($_SESSION['max_file_size']/1024)/1024)?>mb',
		max_file_count: <?php echo $_SESSION['max_number_of_files']?>, // user can add no more then 20 files at a time
		chunk_size : '1mb',
		rename: false,
		multiple_queues : true,

		// Resize images on clientside if we can
		//resize : {width : 320, height : 240, quality : 90},
		
		// Rename files by clicking on their titles
		rename: false,
		
		// Sort files
		sortable: true,

		// Specify what files to browse for
		filters : [
			{title : "All file", extensions : "mp3,ogg,au,wma,zip,rar,mp4,3gp,ogv,avi,flv,m4v,mkv,mov,mpg,ogg,wmv,jpg,gif,png,xls,doc,docx,epub,pdf,odm,odt,rtf,odf,csv,ots,txt,xlsx"},
			{title : "Documents", extensions : "xls,doc,docx,epub,pdf,odm,odt,rtf,odf,csv,ots,txt,xlsx"},
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Audio files", extensions : "mp3,ogg,au,wma"},
			{title : "Video files", extensions : "mp4,3gp,ogv,avi,flv,m4v,mkv,mov,mpg,ogg,wmv"},
			{title : "Zip files", extensions : "zip,rar"}
		],

		// Flash settings
		flash_swf_url : '../../js/plupload.flash.swf',

		// Silverlight settings
		silverlight_xap_url : '../../js/plupload.silverlight.xap'
	});

	// Client side form validation
	$('form').submit(function(e) {
        var uploader = $('#uploader').plupload('getUploader');
         
        // Files in queue upload them first
        if (uploader.files.length > 0) {
            // When all files are uploaded submit form
            uploader.bind('StateChanged', function() {
                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
                    $('form')[0].submit();
                }
            });
                
            uploader.start();
        } else
            alert('You must at least upload one file.');

        return false;
    });
	 

});
</script>
</body>
</html>
