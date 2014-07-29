<?php
session_start();
include("../../config.php");

if ($_REQUEST['dir'])
 $current_dir =  base64_decode($_REQUEST['dir']);
//echo $current_dir;
$url = $_SERVER['REQUEST_URI'];
$args = strpos($url,"?");
//echo 'pos:'.$args;
$url = substr($url,1,$args-1);
//echo $url;
$user = basename($url);
$homedir = $_SESSION["path"] . $user . "/files/mysite/";
//echo $homedir;
if ($current_dir == '')
 $current_dir = $user . "/files/mysite/"; 

//echo $user; 
$http = $_SESSION['app_address'] . "homes/";
$http_homepage = "http://my.crypt2share.com/". $user . "/";
//echo $http;

$help_nav = "<font style='color:#fff;font-size:18px;margin:6px;'>Per creare le voci del menù basta creare una o più Cartelle nella directory mysite nel tuo C2S</font>";
$help_content = "<strong>Per Aggiungere contenuti in questa sezione basta mettere uno o più files nella directory '/files/mysite/". str_replace($user."/files/mysite/","",$current_dir)."' nel tuo C2S</strong>";


function create_menu($d)
{
  $dir = glob($d."*",GLOB_ONLYDIR|GLOB_MARK );
  for ($i=0;$i<count($dir);$i++)
   {

		$subdir = glob($dir[$i]."*",GLOB_ONLYDIR|GLOB_MARK );
		if (count($subdir)==0)
		 {
		    $res .= '<li ><a href="?dir='.base64_encode(str_replace($_SESSION["path"],"",$dir[$i])).'">'.basename($dir[$i]).'</a></li>';
		 }
		else
		 {
			 $res .= '<li ><a href="?dir='.base64_encode(str_replace($_SESSION["path"],"",$dir[$i])).'">'.basename($dir[$i]).'</a></li><li class="dropdown left"><a data-toggle="dropdown" class="dropdown-toggle" href="#"><strong class="caret"></strong></a><ul class="dropdown-menu">';
			 
			$res .='<li style="background:#333;color:#fff;padding:6px;"> -> '.basename($dir[$i]).'</li>';
			 for ($k=0;$k<count($subdir);$k++)
			  {
				$res .='<li><a href="?dir='.base64_encode(str_replace($_SESSION["path"],"",$subdir[$k])).'">'.basename($subdir[$k]).'</a></li>';
			 }
			$res .= '</ul><li class="divider">
										</li></li>';
		 }    
   //'<button class="btn">'.basename($dir[$i]).'</button>';
				
   }
return $res;
}

function get_images($d,$http)
{
	$ud = $d;
	$d = $_SESSION["path"] . $d;
	$images = glob($d."{*.jpeg,*.jpg,*.gif,*.png,*.JPEG,*.JPG,*.GIF,*.PNG}", GLOB_BRACE);
	//print_r($images);
    $quante = count($images);
    $quantispan2 = floor($quante / 6);
    $quanterow = floor($quantispan2 / 2);
    if ($quante > 0)
    $res = "<div class='row-fluid'><div class='span12'><h3>Foto</h3></div></div>";
    for ($i = 0;$i<$quante;$i++)
     {
		 //echo "i:" . $i . " mod:".($i % 6) ."<br />";
		if ((($i % 6) === 0)||($i==0)) 
		 $res .= "<div class='row-fluid'>";

          if ($images[$i])
           {
			   $res .= "<div class='span2'><a style='cursor:pointer;' onclick=\"show_gallery('".$ud."','".basename($images[$i])."')\"><img alt='".$i."' src='../../img_my.php?fn=".$ud . basename($images[$i])."&s=160&c=1' class='img-polaroid'></a><br />".basename($images[$i])."</div>";
		   }		 

		if ((($i % 6) === 5)) 
		 $res .= "</div><br />";
		  
	 }
    if ((($quante % 6) < 5) && (($quante % 6) != 0))
     $res .="</div><br />";
    
    return $res;
}

function get_files($d,$http)
{
	$ud = $d;
	$d = $_SESSION["path"] . $d;
	
	$files = glob($d."{*.zip,*.doc,*.docx,*.ods,*.pdf,*.xls}", GLOB_BRACE);
    $quante = count($files);
    $quantispan2 = floor($quante / 6);
    $quanterow = floor($quantispan2 / 2);
    if ($quante > 0)
    $res = "<div class='row-fluid'><div class='span12'><h3>Contenuti</h3></div></div>";
    for ($i = 0;$i<$quante;$i++)
     {
		 //echo "i:" . $i . " mod:".($i % 12) ."<br />";
		if ((($i % 6) === 0)||($i==0)) 
		 $res .= "<div class='row-fluid'>";

          if ($files[$i])
           {
			   $res .= "<div class='span2'><a  href='/download.php?fn=".$ud.basename($files[$i])."'><img alt='".$i."' src='../../img_my.php?fn=".$ud . basename($files[$i])."' ><br /></a>".basename($files[$i])."</div>";
		   }		 

		if ((($i % 6) === 5)) 
		 $res .= "</div><br />";
		  
	 }
    if ((($quante % 6) < 5) && (($quante % 6) != 0))
     $res .="</div><br />";
    
   return $res;
}



function get_video($d,$http)
{
	
	$ud = $d;
	$d = $_SESSION["path"] . $d;
	$videos = glob($d."{*.mp4,*.3gp,*.flv,*.mov,*.ogv}", GLOB_BRACE);
    $quante = count($videos);
    $quantispan3 = floor($quante / 4);
    $quanterow = floor($quantispan3 / 3);
    if ($quante > 0)
    $res = "<div class='row-fluid'><div class='span12'><h3>Video</h3></div></div>";
    for ($i = 0;$i<$quante;$i++)
     {
		 //echo "i:" . $i . " mod:".($i % 6) ."<br />";
		if ((($i % 4) === 0)||($i==0)) 
		 $res .= "<div class='row-fluid'>";

          if ($videos[$i])
           {
//			   $res .= "<div class='span3'><iframe frameborder=0  style='width:330px;height:250px;overflow:hidden;' src='../play_my.php?f=".$ud . basename($videos[$i])."&w=320&h=240'></iframe><br />".basename($videos[$i])."&nbsp;&nbsp;<a style='height:25px;' href='../download.php?fn=".$ud.basename($videos[$i])."'>Download</a></div>";
			   $res .= "<div class='span3'><div id='video_".$i."' name='video_".$i."'><a style='cursor:pointer;' onclick=create_media('video_".$i."','".$http . $ud . basename($videos[$i])."',320,240,'".$ud.basename($videos[$i])."')><img src='../video.png'></a></div><br />".basename($videos[$i])."&nbsp;&nbsp;<a style='height:25px;' href='../download.php?fn=".$ud.basename($videos[$i])."'>Download</a></div>";
		   }		 

		if ((($i % 4) === 3)) 
		 $res .= "</div><br />";
		  
	 }
    if ((($quante % 4) < 3) && (($quante % 4) != 0))
     $res .="</div><br />";
    
    return $res;
}


function get_audio($d,$http)
{
	
	$ud = $d;
	$d = $_SESSION["path"] . $d;
	$audios = glob($d."{*.aac,*.m4a,*.f4a,*.mp3,*.ogg,*.oga}", GLOB_BRACE);
    $quante = count($audios);
    $quantispan3 = floor($quante / 4);
    $quanterow = floor($quantispan3 / 3);
    if ($quante > 0)
    $res = "<div class='row-fluid'><div class='span12'><h3>Audio Files</h3></div></div>";
    for ($i = 0;$i<$quante;$i++)
     {
		 //echo "i:" . $i . " mod:".($i % 6) ."<br />";
		if ((($i % 4) === 0)||($i==0)) 
		 $res .= "<div class='row-fluid'>";

          if ($audios[$i])
           {
//			   $res .= "<div class='span3'><iframe frameborder=0  style='width:330px;height:250px;overflow:hidden;' src='../play_my.php?f=".$ud . basename($videos[$i])."&w=320&h=240'></iframe><br />".basename($videos[$i])."&nbsp;&nbsp;<a style='height:25px;' href='../download.php?fn=".$ud.basename($videos[$i])."'>Download</a></div>";
               $res .= "<div class='span3'><div id='audio_".$i."' name='audio_".$i."'><a style='cursor:pointer;' onclick=create_media('audio_".$i."','".$http . $ud . basename($audios[$i])."',320,240)><img src='../video.png'></a></div><br />".basename($audios[$i])."&nbsp;&nbsp;<a style='height:25px;' href='../download.php?fn=".$ud.basename($audios[$i])."'>Download</a></div>";
		   }		 

		if ((($i % 4) === 3)) 
		 $res .= "</div><br />";
		  
	 }
    if ((($quante % 4) < 3) && (($quante % 4) != 0))
     $res .="</div><br />";
    
    return $res;
}

function carusel($d,$http)
{
	
	$ud = $d;
	$d = $_SESSION["path"] . $d;
	
	$images = glob($d."{*.jpeg,*.jpg,*.gif,*.png,*.JPEG,*.JPG,*.GIF,*.PNG}", GLOB_BRACE);
	shuffle($images);
	
if (count($images) >2)
 {		
	$res = '<div class="carousel slide" id="carousel-611069">
				<div class="carousel-inner">
					<div class="item next left">
						<img alt="" style="align:center;" src="../../img_my.php?fn='.$ud . basename($images[0]).'&w=1600&h=300&c=1">
						
					</div>
					<div class="item">
						<img alt="" src="../../img_my.php?fn='.$ud . basename($images[1]).'&w=1600&h=300&c=1">
						
					</div>
					<div class="item active left">
						<img alt="" src="../../img_my.php?fn='.$ud . basename($images[2]).'&w=1600&h=300&c=1">
						
					</div>
				</div> <a data-slide="prev" href="#carousel-611069" class="left carousel-control">‹</a> <a data-slide="next" href="#carousel-611069" class="right carousel-control">›</a>
            </div>';
}
else
 {
	$res = '<div class="carousel slide" id="carousel-611069">
				<div class="carousel-inner">
					<div class="item next left">
						<img alt="" style="align:center;" src="../../img_my.php?fn=../images/1400logo.png&w=1600&h=300&c=1">
						
					</div>
					<div class="item">
						<img alt="" style="align:center;" src="../../img_my.php?fn=../images/1400logo.png&w=1600&h=300&c=1">
						
					</div>
					<div class="item active left">
						<img alt="" style="align:center;" src="../../img_my.php?fn=../images/1400logo.png&w=1600&h=300&c=1">
						
					</div>
				</div> <a data-slide="prev" href="#carousel-611069" class="left carousel-control">‹</a> <a data-slide="next" href="#carousel-611069" class="right carousel-control">›</a>
            </div>';
 	 
 }
return $res;
}
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
	
	<link href="../.mysite_template/1/css/bootstrap.min.css" rel="stylesheet">
	<link href="../.mysite_template/1/css/bootstrap-responsive.min.css" rel="stylesheet">
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
	<script type="text/javascript" src="../.mysite_template/1/js/jquery.min.js"></script>
	<script type="text/javascript" src="../.mysite_template/1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../.mysite_template/1/js/scripts.js"></script>
    <script src="https://www.crypt2share.com/app/js/jquery.blockUI.js"></script>
    <script src="../jwplayer.js"></script>
    <script>jwplayer.key="e8Ih38F/F90sFhPB2fNVIM0wdQskZLzW4oUusQ=="</script>    
</head>

<body style="padding-bottom:100px;">
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<?php echo carusel($current_dir,$http);?>			
			<div class="navbar navbar-inverse">
				<div class="navbar-inner">
					<div class="container-fluid">
						 <a data-target=".navbar-responsive-collapse" data-toggle="collapse" class="btn btn-navbar"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a> <a href="<?php echo $http_homepage; ?>" class="brand"><?php echo "MySite " . $user;?></a>
						<div class="nav-collapse collapse navbar-responsive-collapse">
							<ul class="nav">
								<?php 
									$menu = create_menu($homedir);
									if ($menu == '')
									 echo $help_nav;
									else
									 echo $menu; 
								?>
								
							</ul>
							

						</div>
					</div>
				</div>
				</div>







		</div>
	</div>

    <?php 
     $content = get_images($current_dir,$http);
     $content .=  get_video($current_dir,$http);
     $content .= get_audio($current_dir,$http);
     $content .= get_files($current_dir,$http);
     if ($content == '')
      echo $help_content;
     else
      echo $content;
       
    ?>
    
<div style="position:fixed;bottom:0px;left:0px;width:100%;" style="height:80px;">
	<div class="row-fluid" style="background:#333;color:#fff">
		<div class="span12">
			<div class="row-fluid">
				<div class="span6">
					 <img src="<?php echo $_SESSION['app_address']."images/logook200.png" ?>"><div style="position:absolute;left:220px;top:10px;"><strong>Crypt2Share.com</strong> Unlimited disk space for your files</div><a style="position:absolute;left:220px;top:40px;" href="https://www.crypt2share.com" class="btn">Register for Free</a>
				</div>
				<div class="span6">
					
				</div>
			</div>
		</div>
	</div>
</div>	
</div>
</body>
</html>
<script>
	
	
function create_media(div,f,w,h,bnf)
{
	//alert('../ffmpeg_image.php?file=/var/www/crypt/homes/'+bnf+'&time=00:01:09&browser=false ');
	 jwplayer(div).setup({
		autostart: "false",
		//fullscreen: "true",
        file: f,
        image: '../logobig.png',
        width: w,
        height: h,
        players: [
        { type: "flash", src: "../jwplayer.flash.swf", config: {provider: "sound"}  },
        {  type: "html5", config: {provider: "sound"}  }
  ],
     events:
     {
        onPlay: function () {jwplayer(div).setFullscreen(false)},
        onPause: function() {jwplayer(div).setFullscreen(false)},
        onComplete:function()
           {
               jwplayer(div).setFullscreen(false),
               jwplayer(div).setup(options)
            }                      
     }
 
    });
	
}	

function show_gallery(d,f)
{
		non_rompere = 1;
		var window_w = ($(window).width() - 80);
		var window_h = ($(window).height() - 200);
		var w_img = window_w;//((window_w / 4)*2);
		var h_img = window_h;
		
        //alert(list[1]); 
		$.blockUI({ message: '<div id="gallery" style="background: url(../metallo.png) repeat scroll 0 0 transparent; cursor:pointer;width:100%;height:100%;"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="../close_j.png" style="vertical-align:middle"></a>'+toolbar(d,f)+'<br /><img id=show_img src="../../img_my.php?fn='+d+'/'+f+'&w='+w_img+'&h='+h_img+'" /></div>', css: { 
   		height: ($(window).height() - 130) +'px',
		width: ($(window).width() -50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });

	
}

function toolbar(d,f)
{
	var res = '<div style="width:100%;"></div>';
return res;
}
function close()
{
	$.unblockUI();
	
}    







function aPost(url, parameters)
{
	//	non_rompere = 1;
		if (window.XMLHttpRequest) { AJAX=new XMLHttpRequest(); } 
		else {  AJAX=new ActiveXObject("Microsoft.XMLHTTP");  }
		
		if (AJAX) {
					AJAX.open("POST", url, false);
					AJAX.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					AJAX.send(parameters);
					
					return AJAX.responseText;                                         
		} else { return false; }   
	//		non_rompere = 0;  
}  

	</script>
