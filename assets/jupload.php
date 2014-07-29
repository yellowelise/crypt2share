<?php
session_start();
$path = $_REQUEST['p'];
$_SESSION['up_path'] = $path;

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
<!DOCTYPE HTML>
<!--
/*
 * jQuery File Upload Plugin Demo 6.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
-->
<html lang="en">
<head>
<!-- Force latest IE rendering engine or ChromeFrame if installed -->
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
<meta charset="utf-8">
<title>Crypt2Share.com upload</title>
<meta name="description" content="File Upload widget with multiple file selection, drag&amp;drop support, progress bar and preview images for jQuery. Supports cross-domain, chunked and resumable file uploads. Works with any server-side platform (Google App Engine, PHP, Python, Ruby on Rails, Java, etc.) that supports standard HTML form file uploads.">
<meta name="viewport" content="width=device-width">
<!-- Bootstrap CSS Toolkit styles -->
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<!-- Generic page styles -->
<!-- Bootstrap styles for responsive website layout, supporting different screen sizes -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.min.css">
<!-- Bootstrap CSS fixes for IE6 -->
<!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css"><![endif]-->
<!-- Bootstrap Image Gallery styles -->
<!--<link rel="stylesheet" href="bootstrap/css/bootstrap-image-gallery.min.css">
 CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="css/jquery.fileupload-ui-noscript.css"></noscript>
<!-- Shim to make HTML5 elements usable in older Internet Explorer versions -->
<!--[if lt IE 9]><script src="js/html5.js"></script><![endif]-->
</head>
<body style="background: transparent;">

<div class="container">
	
  <div class="row-fluid"><div class="span12"><h4>Cartella selezionata: <?echo $_SESSION['up_path']?></h4></div></div>
  <div class="row-fluid"><div class="span12"><h5>Dimensione massima singolo file: <?echo format_size($_SESSION['max_file_size'])?></h5></div></div>
  <div class="row-fluid"><div class="span12"><h5>Numero massimo file simultanei: <?echo $_SESSION['max_number_of_files']?></h5></div></div>
    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="" method="POST" enctype="multipart/form-data">
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value="#"></noscript>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="span7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>Add files...</span>
                    <input id="uplo" type="file" name="files[]"  multiple>
                </span>
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>Add directory... (Chrome only)</span>
                    <input id="uplod" type="file" name="files[]" webkitdirectory="" directory="" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel" onclick="window.location.reload()">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel upload</span>
                </button>
            </div>
            <!-- The global progress information -->
            <div class="span5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="bar" style="width:0%;"></div>
                </div>
                <!-- The extended global progress information -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The loading indicator is shown during file processing -->
        <div class="fileupload-loading"></div>
        <br>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped" style="background:transparent;"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
    </form>
    <br>
 
</div>
<!-- modal-gallery is the modal dialog used for the image gallery -->
<div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd" tabindex="-1">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body"><div class="modal-image"></div></div>
    <div class="modal-footer">
        <a class="btn modal-download" target="_blank">
            <i class="icon-download"></i>
            <span>Download</span>
        </a>
        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
            <i class="icon-play icon-white"></i>
            <span>Slideshow</span>
        </a>
        <a class="btn btn-info modal-prev">
            <i class="icon-arrow-left icon-white"></i>
            <span>Previous</span>
        </a>
        <a class="btn btn-primary modal-next">
            <span>Next</span>
            <i class="icon-arrow-right icon-white"></i>
        </a>
    </div>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
	
{% 
//    alert(file.length);
    for (var i=0, file; file=o.files[i]; i++) { 
%}
    
    <tr class="template-upload fade" style="background:transparent;">
        <td class="preview" style="background:transparent;"><span class="fade"></span></td>
        <td class="name" style="background:transparent;"><span>{%=file.name%}</span></td>
        <td class="size" style="background:transparent;"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2" style="background:transparent;"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td style="background:transparent;">
                <div  style="background:transparent;" class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start"  style="background:transparent;">{% 
				if (file.size <= <? echo $_SESSION['max_file_size']?>)
				  {
					if (!o.options.autoUpload) 
					{ 
					
						%}
						<button class="btn btn-primary">
							<i class="icon-upload icon-white"></i>
							<span>Start</span>
						</button>
					{% 
					} 
				   }
				  else
				   { %}
				   <span class="label label-important">Error</span> File is too big
				   {% } 
					
            %}</td>
        {% } else { %}
            <td colspan="2" style="background:transparent;"></td>
        {% } %}
        <td class="cancel" style="background:transparent;">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>Cancel</span>
            </button>
        {% } %}</td>
    </tr>
{% }

 %}
</script>

<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade" style="background:transparent;">
        {% if (file.error) { %}
            <td style="background:transparent;"></td>
            <td class="name" style="background:transparent;"><span>{%=file.name%}</span></td>
            <td class="size" style="background:transparent;"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2" style="background:transparent;"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else { %}
            <td class="preview" style="background:transparent;">
               <img src="usr_img.php?fn=<?echo $_SESSION['up_path']?>/{%=encodeURIComponent(file.name)%}">
            </td>
            <td class="name" style="background:transparent;">
                {%=file.name%}
            </td>
            <td class="size" style="background:transparent;"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2" style="background:transparent;"></td>
        {% } %}
  
    </tr>
{% } %}
</script>


<script src="js/jquery.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="js/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!--<script src="bootstrap/js/bootstrap-image-gallery.min.js"></script>
 The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="js/jquery.fileupload.js"></script>
<!-- The File Upload file processing plugin -->
<script src="js/jquery.fileupload-fp.js"></script>
<!-- The File Upload user interface plugin -->
<script src="js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
<!--[if gte IE 8]><script src="js/cors/jquery.xdr-transport.js"></script><![endif]-->
</body> 
</html>
<script>
function clearInput($source) {
    var $form = $('<form>')
    var $targ = $source.clone().appendTo($form)
    $form[0].reset()
    $source.replaceWith($targ)
    alert("cancel");
    window.location.reload();
}

	$('input#uplo').change(function(e){
    var files = $(this)[0].files;
    if(files.length > <? echo $_SESSION['max_number_of_files']?>){
        alert("you can select max <? echo $_SESSION['max_number_of_files']?> files.");
       // $(this)[0].files = '';
        //files.replaceWith( files = files.val('').clone( true ) );
      
        //files.reset();
      var control = $("#uplo");
      control.replaceWith( control = control.val('').clone( true ) );
      
       e.preventDefault();
    }
});
	$('input#uplod').change(function(e){
    var files = $(this)[0].files;
    if(files.length > <? echo $_SESSION['max_number_of_files']?>){
        alert("you can select max <? echo $_SESSION['max_number_of_files']?> files.");
       // $(this)[0].files = '';
        //files.replaceWith( files = files.val('').clone( true ) );
      
        //files.reset();
      var control = $("#uplod");
      control.replaceWith( control = control.val('').clone( true ) );
      
       e.preventDefault();
    }
});
	</script>
