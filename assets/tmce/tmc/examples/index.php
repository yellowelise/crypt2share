<?php 
session_start();
//echo "filename:". $_REQUEST['fn'];
$data_file = file_get_contents($_SESSION['home'] . $_REQUEST['fn']);
//echo $data_file;
if ($_REQUEST['s'] == 1)
 echo "<strong>File salvato.</strong>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Full featured example using jQuery plugin</title>

<!-- Load jQuery -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load("jquery", "1");
</script>

<!-- Load TinyMCE -->
<script type="text/javascript" src="../jscripts/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
	$().ready(function() {
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '../jscripts/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
		
		 document.getElementById("elm1").style.width = $(window).width() - 40 + "px";
         document.getElementById("elm1").style.height = $(window).height() - 80 + "px";
	});
</script>
<!-- /TinyMCE -->

</head>
<body>

<form method="post" action="save.php">
	<div>
	    <div>
			<textarea id="elm1" name="elm1" class="tinymce">
              <?php echo $data_file;?>
			</textarea>
		</div>

		<!-- 		<a href="javascript:;" onclick="$('#elm1').tinymce().show();return false;">[Show]</a>
		<a href="javascript:;" onclick="$('#elm1').tinymce().hide();return false;">[Hide]</a>
		<a href="javascript:;" onclick="$('#elm1').tinymce().execCommand('Bold');return false;">[Bold]</a>
		<a href="javascript:;" onclick="alert($('#elm1').html());return false;">[Get contents]</a>
		<a href="javascript:;" onclick="alert($('#elm1').tinymce().selection.getContent());return false;">[Get selected HTML]</a>
		<a href="javascript:;" onclick="alert($('#elm1').tinymce().selection.getContent({format : 'text'}));return false;">[Get selected text]</a>
		<a href="javascript:;" onclick="alert($('#elm1').tinymce().selection.getNode().nodeName);return false;">[Get selected element]</a>
		<a href="javascript:;" onclick="$('#elm1').tinymce().execCommand('mceInsertContent',false,'<b>Hello world!!</b>');return false;">[Insert HTML]</a>
		<a href="javascript:;" onclick="$('#elm1').tinymce().execCommand('mceReplaceContent',false,'<b>{$selection}</b>');return false;">[Replace selection]</a>

		<br />
		<input type="submit" name="save" value="Submit" />
		<input type="reset" name="reset" value="Reset" />
Some integration calls -->
	</div>
	<input type="hidden" value="<?php echo $_REQUEST['fn']?>" name="filename">
</form>
<script type="text/javascript">
/*if (document.location.protocol == 'file:') {
	alert("The examples might not work properly on the local file system due to security settings in your browser. Please use a real webserver.");
}*/
</script>
</body>
</html>
