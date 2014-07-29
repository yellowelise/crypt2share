<?php
session_start();
include("../../config.php");

if ($_SESSION['mysite_theme'] == '')
  $_SESSION['mysite_theme'] = '1';


if ($_REQUEST['p'])
$p = $_REQUEST['p'];
else
$p = 1;

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
$http_homepage = $_SESSION['mysite_address']. $user . "/";
//echo $http;

$help_nav = "<font style='color:#fff;font-size:18px;margin:6px;'>Per creare le voci del menù basta creare una o più Cartelle nella directory mysite nel tuo C2S</font>";
$help_content = "<strong>Per Aggiungere contenuti in questa sezione basta mettere uno o più files nella directory '/files/mysite/". str_replace($user."/files/mysite/","",$current_dir)."' nel tuo C2S</strong>";


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo $_SESSION['mysite_title']?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="/.mysite_template/1/js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	<link href="../content.css" rel="stylesheet">
	<link href="../.mysite_template/1/css/bootstrap.css" rel="stylesheet">
	<link href="../.mysite_template/1/css/bootstrap-responsive.min.css" rel="stylesheet">
	
	<!-- <link href="/.site_template/1/css/style.css" rel="stylesheet"> -->
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="../.mysite_template/1/js/html5shiv.js"></script>
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
	<script type="text/javascript" src="../flowplayer-3.2.12.min.js"></script>    
    
    <script>jwplayer.key="e8Ih38F/F90sFhPB2fNVIM0wdQskZLzW4oUusQ=="</script>    

    <script>
		
var notification_from = '';
var nocheck = 0;
		
var keyStr = "ABCDEFGHIJKLMNOP" +
               "QRSTUVWXYZabcdef" +
               "ghijklmnopqrstuv" +
               "wxyz0123456789+/" +
               "=";
function base64_encode (data) {
  var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
  var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
    ac = 0,
    enc = "",
    tmp_arr = [];

  if (!data) {
    return data;
  }

  do { // pack three octets into four hexets
    o1 = data.charCodeAt(i++);
    o2 = data.charCodeAt(i++);
    o3 = data.charCodeAt(i++);

    bits = o1 << 16 | o2 << 8 | o3;

    h1 = bits >> 18 & 0x3f;
    h2 = bits >> 12 & 0x3f;
    h3 = bits >> 6 & 0x3f;
    h4 = bits & 0x3f;

    // use hexets to index into b64, and append result to encoded string
    tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
  } while (i < data.length);

  enc = tmp_arr.join('');

  var r = data.length % 3;

  return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);

}
               
function decode64(input) {
     var output = "";
     var chr1, chr2, chr3 = "";
     var enc1, enc2, enc3, enc4 = "";
     var i = 0;

     // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
     var base64test = /[^A-Za-z0-9\+\/\=]/g;
     if (base64test.exec(input)) {
        alert("There were invalid base64 characters in the input text.\n" +
              "Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" +
              "Expect errors in decoding.");
     }
     input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

     do {
        enc1 = keyStr.indexOf(input.charAt(i++));
        enc2 = keyStr.indexOf(input.charAt(i++));
        enc3 = keyStr.indexOf(input.charAt(i++));
        enc4 = keyStr.indexOf(input.charAt(i++));

        chr1 = (enc1 << 2) | (enc2 >> 4);
        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
        chr3 = ((enc3 & 3) << 6) | enc4;

        output = output + String.fromCharCode(chr1);

        if (enc3 != 64) {
           output = output + String.fromCharCode(chr2);
        }
        if (enc4 != 64) {
           output = output + String.fromCharCode(chr3);
        }

        chr1 = chr2 = chr3 = "";
        enc1 = enc2 = enc3 = enc4 = "";

     } while (i < input.length);

     return unescape(output);
  }	

function show_mod(i)
{
 document.getElementById("edit_"+i).style.display = "block";
 document.getElementById("label_"+i).innerHTML = "";
 
 document.getElementById("text_descr_"+i).style.display = "block";
 
} 

function hide_mod(i)
{
 document.getElementById("edit_"+i).style.display = "none";
 document.getElementById("text_descr_"+i).style.display = "none";
 
}

function save_descr(r,i)
{
	//alert(r);
	var c = document.getElementById('text_descr_'+i).value;
	//alert(c);
	var param = "r=" + base64_encode(r) + "&c="+base64_encode(c)+"&f=newdescription";
	var resu = aPost("callback.php",param);
    //alert(resu);
    document.getElementById("span_text_"+i).innerHTML = c;
     document.getElementById("span_text_"+i).style.display = "block";
     document.getElementById("text_descr_"+i).style.display = "none";
     
     document.getElementById("edit_"+i).style.display = "block";
     document.getElementById("save_"+i).style.display = "none";
	
}
function change_descr(r,i)
{
	//alert(r);
     document.getElementById("span_text_"+i).style.display = "none";
     document.getElementById("text_descr_"+i).style.display = "block";
     
     document.getElementById("edit_"+i).style.display = "none";
     document.getElementById("save_"+i).style.display = "block";
	
	//alert(res);
	//var c = document.getElementById('text_descr_'+i).value;
	//var param = "r=" + base64_encode(r) + "&c="+base64_encode(c)+"&f=newdescription";
	//var resu = aPost("callback.php",param);
	//alert(resu);
}


function _change_descr(r,i)
{
	//alert(res);
	var c = document.getElementById('text_descr_'+i).value;
	var param = "r=" + base64_encode(r) + "&c="+base64_encode(c)+"&f=newdescription";
	var resu = aPost("callback.php",param);
	alert(resu);
}
	
function create_media(div,f,w,h)
{
	//alert(f);
	//{*.mp4,*.3gp,*.flv,*.mov,*.ogv
	if ((decode64(f).indexOf('.mp4')>-1)||(decode64(f).indexOf('.3gp')>-1)||(decode64(f).indexOf('.flv')>-1))
	 {
	  if (navigator.mimeTypes ["application/x-shockwave-flash"] != undefined)	 
		 create_media_flv(div,f,w,h);
      else
   		 create_media_html5(div,f,w,h);
 		 
	 }
	if ((decode64(f).indexOf('.ogv')>-1)||(decode64(f).indexOf('.mov')>-1))
	 {
		 create_media_html5(div,f,w,h);
	 }
}

function load_img()
{
	var dvImages = $("img[id^='img_']");
	$.each(dvImages, function(index){
      //alert();
      
      //$(liImages[index]).attr('src', $(this).attr('src'));
      
      if (window["localStorage"]) 
       {
		  //alert('locals');   
          var value = localStorage.getItem($("#" + dvImages[index].id).attr('alt'));
          //alert('key; ' + $("#img_" + index).attr('alt') + ' val:' + value);
          //alert(value);
          if (value != null)
	        {
              //alert('load localy'); 
              $("#" + dvImages[index].id).attr('src',value);
		    }
          else
           {
			  // alert("write: " + "key: img_" + index + 'value: ../img_my.php?fn='+ $("#img_" + index).attr('alt'));
			  // alert('save localy');
			   //localStorage.setItem("img_" + index,'../img_my.php?fn='+ $("#img_" + index).attr('alt'));
               $("#" + dvImages[index].id).attr('src','../img_my.php?fn='+ $("#" + dvImages[index].id).attr('alt'));
			   
			   $("#" + dvImages[index].id).load(function(){
                
                //alert('.load()');
			   	var canvas = document.createElement("canvas");
				canvas.width = this.width;
				canvas.height = this.height;
				
				var ctx = canvas.getContext("2d");
				ctx.drawImage(this, 0, 0);
				localStorage[$("#" + dvImages[index].id).attr('alt')]=canvas.toDataURL("image/jpg");

				});
			   	
			   	
		   }  
       }
      else  
         $("#" + dvImages[index].id).attr('src','../img_my.php?fn='+ $("#" + dvImages[index].id).attr('alt'));
    });



	
//	alert('load');
}





function create_media_flv(div,f,w,h)
{
	 //style='position:relative;float: none;margin: 0 auto;text-align: center;display: block;width:auto;height:auto;'
	document.getElementById(div).innerHTML = '<a  href="'+decode64(f)+'" style="position:relative;float: none;margin: 0 auto;text-align: center;display:block;width:'+w+'px;height:'+h+'px" id="pl_'+div+'"></a>'; 
	flowplayer('pl_'+div, "../flowplayer-3.2.16.swf");
}


function create_media_html5(div,f,w,h)
{
	//alert(decode64(f));
	 jwplayer(div).setup({
		autostart: "false",
		//fullscreen: "true",
        file: decode64(f),
        image: '../logobig.png',
        width: w,
        height: h,
        players: [
        {  type: "html5", config: {provider: "sound"}  },
        { type: "flash", src: "../jwplayer.flash.swf", config: {provider: "sound"}  }       
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

function download_image(fn)
{
  if ('<?php echo $_SESSION['username']?>' != '')
   {	
	var qs = "../img_my.php?dwn=1&fn=" + fn;


    if (($('#w').val() == 0) || ($('#h').val() == 0))
     {
 	    qs += "&s=0";
	 }
	else
	 { 
	   if ($('#type').val() != 0)
 	    qs += "&c=" + $('#type').val();
       qs += "&w=" + $('#w').val();
	   qs += "&h=" + $('#h').val();
	 }
	window.open(qs);
   }
  else
   {
	   alert("Registrati a Crypt2Share.com per scaricare l'immagine");
       window.open("https://www.crypt2share.com/index.php/registrati/");
   } 	
}

function change_dim(id)
{
    if ($('#' + id).val() == 0)
     {
		 $('#w').val(0);
		 $('#h').val(0);
		 
	 }
	else
	 {
		 if (id == 'w')
		  {
			if ($('#h').val() == 0)   
    		 $('#h').val($('#w').val());
			  
		  }
         else
         {
			if ($('#w').val() == 0)   
     		 $('#w').val($('#h').val());

		 }
	 } 
}
function show_gallery(d,f,div)
{
	if (div !='')
	 	$('#'+div).css({zIndex:'0'});

		download = "<select style='float:left;' id='type'><option value=0>Proporzionale</option><option value=1>Cropping</option></select>";
		download += "<select style='float:left;' id='w' onchange=change_dim('w')><option value=0>Dimensioni originali</option><option value=100>100 pixel</option><option value=200>200 pixel</option><option value=640>640 pixel</option><option value=1024>1024 pixel</option></select>";
		download += "<select style='float:left;' id='h' onchange=change_dim('h')><option value=0>Dimensioni originali</option><option value=100>100 pixel</option><option value=200>200 pixel</option><option value=640>640 pixel</option><option value=1024>1024 pixel</option></select>";
		download += "<button style='float:left;'  onclick=download_image('"+unescape(d+f)+"')>Download</button>";
        //var download = ''; 
		//non_rompere = 1;
		var window_w = ($(window).width() - 80);
		var window_h = ($(window).height() - 200);
		if (window_w > window_h)
		 {
			orient = 'h'; 
			window_w = (window_w / 2);
			window_h = (window_h);
		    var primodiv = '<div class="row-fluid" ><div class="span6" id="displayer">';	 
		    var secondodiv = '</div><div class="span6" style="overflow-y:auto;" id="res_comm"></div></div>';
		 }
        else
		 {
			//alert('vert'); 
			orient = 'v'; 
			
			window_h = (window_h / 2);
			window_w = (window_w);
		    var primodiv = '<div class="row-fluid" ><div class="span12" id="displayer">';	 
		    var secondodiv = '</div></div><div class="row-fluid" ><div class="span12" style="overflow-y:auto;" id="res_comm"></div></div>';
			 
		 }
		
		 
		var w_img = window_w;//((window_w / 4)*2);
		var h_img = window_h - 100;
		
        //alert(list[1]); 
		$.blockUI({ message: '<div id="gallery" style="z-index:10000;background: url(../metallo.png) repeat scroll 0 0 transparent; cursor:pointer;width:100%;height:100%;"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img id="image" src="../close_j.png" style="vertical-align:middle"></a>'+ primodiv+'<img style="vertical-align:middle;margin:3px;" id=show_img src="../img_my.php?fn='+unescape(d+'/'+f)+'&w='+w_img+'&h='+h_img+'" /><br />'+secondodiv + '<div class="row-fluid"><div class="span2">Download Foto</div><div class="span10" id="download">'+download+'</div></div></div></div>', css: { 
   		height: ($(window).height() - 130) +'px',
		width: ($(window).width() -50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });

//alert('<?php if ( $_SESSION['username']) echo $_SESSION['username']; else echo "nologged";?>');
 
if (orient == 'h')
 {
  //alert('h');	 
//  alert(h_img);
  document.getElementById('displayer').style.lineHeight = ($(window).height() - document.getElementById('image').style.height - 180) +'px';
  document.getElementById('res_comm').innerHTML = get_comments(d+f);
  document.getElementById('res_comm').style.height = ($(window).height() - 230) +'px';
 }
else
 {
  //alert('v');	 
  document.getElementById('displayer').style.lineHeight = h_img + 'px';//($(window).height() - document.getElementById('image').style.height - 130) +'px';
  document.getElementById('displayer').style.Height = h_img+'px';//($(window).height() - document.getElementById('image').style.height - 130) +'px';
  
  document.getElementById('res_comm').innerHTML = get_comments(d+f);
  document.getElementById('res_comm').style.height = window_h +'px';//($(window).height() - 230) +'px';
 }
 
 $("#res_comm").animate({ scrollTop: $('#res_comm')[0].scrollHeight}, 1000);
 
}

function goto(addr)
{
 window.open(addr);
}

function signin_glob()
{
var $param = "uu=" + document.getElementById("guser").value + "&pp=" + document.getElementById("gpass").value + "&f=signin";
var res = aPost("callback.php",$param);
//alert('<?php echo $_SESSION['username'] ?>');
if (res == '')
 window.location.reload();
else
 alert(res); 
}

function upload(dir,user)
{
	//alert(user);
	dir = dir.replace(user + "/","");
	//alert(dir);
	//alert(dir);
	var msg = "<div style='background: url(../metallo.png) repeat scroll 0 0 transparent; cursor:pointer;width:100%;height:100%;' id='uploading'><a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close_r()'  onclick='return true'><img id='image' src='../close_j.png' style='vertical-align:middle'></a><br /><iframe frameborder=0 style='position:absolute;left:0px;top:40px;width:100%;height:90%;' src='<?php echo $_SESSION['app_address']?>/plupload/examples/jquery/jupload.php?p="+dir+"&u="+base64_encode(user)+"&m=<?php echo base64_encode($_SESSION['max_file_size'])?>&n=<?php echo base64_encode($_SESSION['max_number_of_files'])?>'></iframe></div>";
	//alert(msg);
		non_rompere = 1;
		$.blockUI({ message: msg  
		, css: { 
   		height: ($(window).height() - 150) +'px',
		width: ($(window).width() - 150) + 'px',
		top: "75px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "75px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
}


function signin(r)
{
var $param = "uu=" + document.getElementById("user").value + "&pp=" + document.getElementById("pass").value + "&f=signin";
var res = aPost("callback.php",$param);
//alert('<?php echo $_SESSION['username'] ?>');
if (res == '')
 document.getElementById('res_comm').innerHTML =  get_comments(r);
else
 alert(res);
}

function send_comm(r)
{
	var c = document.getElementById('comment').value;
	var param = "r=" + base64_encode(r) + "&c="+base64_encode(c)+"&f=newcomment";
	var resu = aPost("callback.php",param);
	//alert(resu);
	$("#pre_comm").append("<pre style='text-align:left;padding:1px;width:90%;'><font style='font-size:10px;'>(Adesso)</font>&nbsp;&nbsp;<strong><?php echo $_SESSION['username']?>:</strong><br /> "+c+"</pre>");
	
	document.getElementById('comment').value = '';
	$("#res_comm").animate({ scrollTop: $('#res_comm')[0].scrollHeight}, 1000);
	//document.getElementById('res_comm').innerHTML =  get_comments(r);
	//alert(resu);
	//document.getElementById("display_image").innerHTML = resu;
}


function toolbar(d,f)
{
	var res = '<div style="width:100%;height:10px;"></div>';
return res;
}
function close()
{
	$.unblockUI();
	
} 
 
function close_r()
{
	$.unblockUI();
    location.reload();	
	
}    



function _get_images(d,p)
{
	var param = "dir=" + d + "&p=" + p + "&f=gip";
	var resu = aPost("callback.php",param);
	//alert(resu);
	document.getElementById("display_image").innerHTML = resu;
}


function get_images(d,p)
{
	var param = "dir=" + d + "&p=" + p + "&f=gip";
	var resu = aPost("callback.php",param);
	//alert(resu);
	
	document.getElementById("display_image").innerHTML = resu;
    load_img();
}

function get_comments(r)
{
	var param = "r=" + base64_encode(r) + "&f=comm";
	var resu = aPost("callback.php",param);
	//alert(resu);
   return resu;
}


function get_videos(d,p)
{
	var param = "dir=" + d + "&p=" + p + "&f=gvp&num=4";
	var resu = aPost("callback.php",param);
	//alert(resu);
	document.getElementById("display_video").innerHTML = resu;
}
function get_audios(d,p)
{
	var param = "dir=" + d + "&p=" + p + "&f=gap&num=4";
	var resu = aPost("callback.php",param);
	//alert(resu);
	document.getElementById("display_audio").innerHTML = resu;
}
function get_files(d,p)
{
	var param = "dir=" + d + "&p=" + p + "&f=gfp&num=6";
	var resu = aPost("callback.php",param);
	//alert(resu);
	document.getElementById("display_file").innerHTML = resu;
}

function get_wall(d)
{
	var param = "dir=" + d + "&f=wall";
	var resu = aPost("callback.php",param);
	//alert(resu);
	document.getElementById("display_wall").innerHTML = resu;
}
function get_content(r)
{
	var param = "r=" + base64_encode(r) + "&f=content";
	var resu = aPost("callback.php",param);
	//alert(resu);
	document.getElementById("display_content").innerHTML = resu;
}

function check_comment(d)
{
//alert(nocheck);	
 if (nocheck == 0)	
   if ('<?php echo $_SESSION['username']?>' != '')
    {	
	var html = '';
	var param = "dir=" + d + "&t="+notification_from+"&f=check";
	var resu = aPost("callback.php",param);
	// alert(resu);
	
	if (resu != '')
	 {
      var notif = eval('(' + resu + ')');
      
      for (i=0;i<notif.file.length;i++)
       {
         //alert(notif[i].bn);
    	html += "<div style='float:left;margin:20px;'><div style='position:relative'><a style='cursor:pointer;' onclick=\"show_gallery('"+notif.file[i].ud+"','"+notif.file[i].bn+"','')\"><img alt='"+i+"' src='../img_my.php?fn="+notif.file[i].ud+notif.file[i].bn+"&s=60&c=1' class='img-polaroid'><span class='badge_a'>"+notif.file[i].qn+"</span></a></div></div>";
    	
       }	   
    	
    	
     }

    if (html == '')
      	document.getElementById("display_notifies").innerHTML = "";
    else
      	document.getElementById("display_notifies").innerHTML = "<div class='row-fluid'><div class='span12'><h2>Commenti recenti</h2><h5>Seleziona arco temporale</h5><button onclick=noti('')>Ultima visita</button>&nbsp;<button onclick=noti('1440')>ultime 24 ore</button>&nbsp;<button onclick=noti('10080')>ultima settimana</button>&nbsp;<button onclick=noti('43200')>ultimo mese</button></div></div><div class='row-fluid'><div class='span12'>" + html + "</div></div>";
    }  	
     
}


function create_menu(d)
{
	var param = "dir=" + d + "&f=menu";
	var resu = aPost("callback.php",param);
	//alert(resu);
	document.getElementById("menu").innerHTML = resu;
}

function expand(tagid)
{
	//alert(tagid);
	$('#'+tagid).animate({height:'120px',width:'120px',top:'0px',left:'0px',margin:'-30px',zIndex:'2000'}, 200);
	$('#d'+tagid).css({zIndex:'2000'});
}

function compress(tagid)
{
	//alert(tagid);
	$('#'+tagid).animate({height:'60px',width:'60px',top:'0px',left:'0px',margin:'0px',zIndex:'0'}, 100);
	$('#d'+tagid).css({zIndex:'0'});
}

function carusel(d)
{
	var param = "dir=" + d + "&w="+($(window).width() - 20)+"&f=caru";
	
	var resu = aPost("callback.php",param);
	//alert(resu);
	document.getElementById("carusel").innerHTML = resu;
}



function publish(r)
{
	//alert(r);
		var window_w = ($(window).width() - 80);
		var window_h = ($(window).height() - 200);
		if (window_w > window_h)
		 {
			window_w = (window_w / 2);
			window_h = (window_h);
			 
		 }
		var w_img = window_w;//((window_w / 4)*2);
		var h_img = window_h;
		
        //alert(list[1]); 
		$.blockUI({ message: '<div id="gallery" style="background: url(../metallo.png) repeat scroll 0 0 transparent; cursor:pointer;width:100%;height:100%;"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close_r()"  onclick="return true"><img id="image" src="../close_j.png" style="vertical-align:middle"></a>'+toolbar(r,"")+'<br /><iframe src="../editor.php?r='+r+'" frameborder=0 style="width:100%;height:90%;"></iframe>', css: { 
   		height: ($(window).height() - 130) +'px',
		width: ($(window).width() -50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });

}

function settings_panel()
{
	var ret = '<div class="row-fluid"><div class="span12"><h3>Impostazioni MySite</h3></div></div>';
	
	ret += '<div class="row-fluid"><div class="span7">Titolo della finestra del browser</div><div class="span5"><input type="text" id="title" value="<?php echo $_SESSION['mysite_title']?>"></div></div>';
	 
	if ('<?php echo $_SESSION['mysite_hmi']?>' == '100')
	 var sel100 = "selected";
	if ('<?php echo $_SESSION['mysite_hmi']?>' == '101')
	 var sel101 = "selected";
	if ('<?php echo $_SESSION['mysite_hmi']?>' == '102')
	 var sel102 = "selected";
	if ('<?php echo $_SESSION['mysite_hmi']?>' == '1')
	 var sel1 = "selected";
	if ('<?php echo $_SESSION['mysite_hmi']?>' == '2')
	 var sel2 = "selected";
	if ('<?php echo $_SESSION['mysite_hmi']?>' == '3')
	 var sel3 = "selected";
	if ('<?php echo $_SESSION['mysite_hmi']?>' == '4')
	 var sel4 = "selected";
	if ('<?php echo $_SESSION['mysite_hmi']?>' == '6')
	 var sel6 = "selected";
	ret += '<div class="row-fluid"><div class="span7">Quante immagini per pagina?</div><div class="span5"><select onchange="live_change()" id="sel_hmi"><option '+sel100+' value="100">Slide Show (una per pagina)</option><option '+sel101+' value="101">Slide Show (Sette piccole)</option><option '+sel102+' value="102">Slide Show (Cinque per pagina)</option><option '+sel1+' value="1">Una</option><option '+sel2+' value="2">Due</option><option '+sel3+' value="3">Tre</option><option '+sel4+' value="4">Quattro</option><option '+sel6+' value="6">Sei</option></select></div></div>';

	
//	 var chk1 = "checked";
	
//	ret += '<div class="row-fluid"><div class="span7">Visualizza nome file</div><div class="span5"><input type="checkbox" '+chk1+' id="show_file_img"/></div></div>';



	if ('<?php echo $_SESSION['mysite_hmv']?>' == '1')
	 sel1 = "selected";
	if ('<?php echo $_SESSION['mysite_hmv']?>' == '2')
	 sel2 = "selected";
	if ('<?php echo $_SESSION['mysite_hmv']?>' == '3')
	 sel3 = "selected";
	if ('<?php echo $_SESSION['mysite_hmv']?>' == '4')
	 sel4 = "selected";
	ret += '<div class="row-fluid"><div class="span7">Quanti Video per pagina?</div><div class="span5"><select onchange="live_change()" id="sel_hmv"><option '+sel1+' value="1">Una</option><option '+sel2+' value="2">Due</option><option '+sel3+' value="3">Tre</option><option '+sel4+' value="4">Quattro</option></select></div></div>';

	if ('<?php echo $_SESSION['mysite_hma']?>' == '1')
	 sel1 = "selected";
	if ('<?php echo $_SESSION['mysite_hma']?>' == '2')
	 sel2 = "selected";
	if ('<?php echo $_SESSION['mysite_hma']?>' == '3')
	 sel3 = "selected";
	if ('<?php echo $_SESSION['mysite_hma']?>' == '4')
	 sel4 = "selected";
	ret += '<div class="row-fluid"><div class="span7">Quanti File Audio per pagina?</div><div class="span5"><select onchange="live_change()" id="sel_hma"><option '+sel1+' value="1">Una</option><option '+sel2+' value="2">Due</option><option '+sel3+' value="3">Tre</option><option '+sel4+' value="4">Quattro</option></select></div></div>';

	if ('<?php echo $_SESSION['mysite_hmf']?>' == '1')
	 sel1 = "selected";
	if ('<?php echo $_SESSION['mysite_hmf']?>' == '2')
	 sel2 = "selected";
	if ('<?php echo $_SESSION['mysite_hmf']?>' == '3')
	 sel3 = "selected";
	if ('<?php echo $_SESSION['mysite_hmf']?>' == '4')
	 sel4 = "selected";
	if ('<?php echo $_SESSION['mysite_hmf']?>' == '6')
	 sel6 = "selected";
	ret += '<div class="row-fluid"><div class="span7">Quanti File per pagina?</div><div class="span5"><select onchange="live_change()" id="sel_hmf"><option '+sel1+' value="1">Una</option><option '+sel2+' value="2">Due</option><option '+sel3+' value="3">Tre</option><option '+sel4+' value="4">Quattro</option><option '+sel6+' value="6">Sei</option></select></div></div>';

	ret += '<div class="row-fluid"><div class="span7">Confermi?</div><div class="span5"><button onclick="save_settings()">Salva</button></div></div>';
return ret;
}

function save_settings()
{
	var param = "set_title="+base64_encode($("#title").val())+"&set_hmi=" + $("#sel_hmi").val()+"&set_hmv=" + $("#sel_hmv").val()+"&set_hma=" + $("#sel_hma").val()+"&set_hmf=" + $("#sel_hmf").val();
	//alert(param);
	var res = aPost("callback.php",param);
	//alert(res);
	alert("aggiornato, chiudi questa finestra per vedere il risultato.");
}

function live_change()
{
	var window_w = ($(window).width() - 80);
		var window_h = ($(window).height() - 200);
		if (window_w > window_h)
		 {
			window_w = (window_w / 2);
			window_h = (window_h);
			 
		 }
		var par = "f=example&qi="+$("#sel_hmi").val()+"&qv="+$("#sel_hmv").val()+"&qa="+$("#sel_hma").val()+"&qf="+$("#sel_hmf").val()+"&dim=" + (window_w-20) + "&h=" + window_h;
//		alert(par);
		var example = aPost("callback.php",par);

 document.getElementById("live").innerHTML = example;
}

function hide_comments()
{
 nocheck = 0;
 notification_from = '';
 check_comment('<?php echo $current_dir?>');

}


function show_comments()
{
nocheck = 1;	
   if ('<?php echo $_SESSION['username']?>' != '')
    {	
	var html = '';
	var param = "dir=<?php echo $current_dir?>&t="+notification_from+"&f=check";
	var resu = aPost("callback.php",param);
	// alert(resu);
	
	if (resu != '')
	 {
      var notif = eval('(' + resu + ')');
      
      for (i=0;i<notif.file.length;i++)
       {
         //alert(notif[i].bn);
    	html += "<div style='float:left;margin:20px;'><div style='position:relative'><a style='cursor:pointer;' onclick=\"show_gallery('"+notif.file[i].ud+"','"+notif.file[i].bn+"','')\"><img alt='"+i+"' src='../img_my.php?fn="+notif.file[i].ud+notif.file[i].bn+"&s=60&c=1' class='img-polaroid'><span class='badge_a'>"+notif.file[i].qn+"</span></a></div></div>";
    	
       }	   
    	
    	
     }
    }  	
         
	var htm = "<div class='row-fluid'><div class='span12'><h2>Commenti recenti</h2><h5>Seleziona arco temporale</h5><button onclick=noti('')>Solo nuovi commenti</button>&nbsp;<button onclick=noti('1440')>ultime 24 ore</button>&nbsp;<button onclick=noti('10080')>ultima settimana</button>&nbsp;<button onclick=noti('43200')>ultimo mese</button></div></div><div class='row-fluid'><div class='span12'>" + html + "</div></div>"; 
    document.getElementById("display_notifies").innerHTML = htm;
}


function noti(t)
{
  //nocheck = 0;  	
	if (t =='')
	 hide_comments();
	else
	 { 
    	notification_from = t;
	    show_comments();
     }
}


function show_settings()
{
	//alert(r);
		var window_w = ($(window).width() - 80);
		var window_h = ($(window).height() - 200);
		if (window_w > window_h)
		 {
			window_w = (window_w / 2);
			window_h = (window_h);
			 
		 }
		var w_img = window_w;//((window_w / 4)*2);
		var h_img = window_h;
		var panel = settings_panel();
		
		var par = "f=example&qi=<?php echo $_SESSION['mysite_hmi']?>&qv=<?php echo $_SESSION['mysite_hmv']?>&qa=<?php echo $_SESSION['mysite_hma']?>&qf=<?php echo $_SESSION['mysite_hmf']?>&dim=" + (window_w-20) + "&h=" + window_h;
//		alert(par);
		var example = aPost("callback.php",par);
		
		$.blockUI({ message: '<div id="settings" style="background: url(../metallo.png) repeat scroll 0 0 transparent; cursor:pointer;width:100%;height:100%;"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close_r()"  onclick="return true"><img id="image" src="../close_j.png" style="vertical-align:middle"></a>'+toolbar("","")+'<br /><div class="row-fluid"><div class="span6">'+panel + '</div><div class="span6" id="live">'+example+'</div></div>', css: { 
   		height: ($(window).height() - 130) +'px',
		width: ($(window).width() -50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });

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

function show_delete()
{
	document.getElementById("vef").style.display = "none";
	document.getElementById("nef").style.display = "block";
	$("img[id^='delete']").attr("style", "visibility: visible");
	
}

function hide_delete()
{
	document.getElementById("vef").style.display = "block";
	document.getElementById("nef").style.display = "none";
	$("img[id^='delete']").attr("style", "visibility: hidden");
	
}

function show_edit()
{
	document.getElementById("vec").style.display = "none";
	document.getElementById("nec").style.display = "block";
	$("img[id^='edit_']").attr("style", "display: block");
	
}
function hide_edit()
{
	document.getElementById("vec").style.display = "block";
	document.getElementById("nec").style.display = "none";
	$("img[id^='edit_']").attr("style", "display: none");
	
}

function get_settings(dir)
{
	var param = "dir=<?php echo $current_dir?>&f=settings";
	var resu = aPost("callback.php",param);

}

function delete_file(r)
{
	
    var answer = confirm("Eliminare permanentemente il file?")
	if (answer){
	//alert(decode64(r) + '<?php echo $current_dir?>');
	var param = "r=" + r + "&dir=<?php echo $current_dir?>&f=delete";
	var resu = aPost("callback.php",param);
	if (resu)
	 alert(resu);
	else
     window.location.reload();

}
 return false;	  
	//document.getElementById("display_content").innerHTML = resu;
	
}

function open_w()
{
myWindow=window.open('https://www.crypt2share.com/login/index_s.php','','width=650,height=400')
//myWindow.document.write("<p>This is 'myWindow'</p>")
myWindow.focus()
} 

    $(function() {
// Handler for .ready() called.

carusel('<?php echo $current_dir?>');

create_menu('<?php echo $user . "/files/mysite/"?>');
//get_wall('<?php echo $current_dir?>');
check_comment('<?php echo $current_dir?>');
get_settings('<?php echo $user?>');
get_content('<?php echo $current_dir?>');
get_images('<?php echo $current_dir?>','<?php echo $p?>');
get_videos('<?php echo $current_dir?>','<?php echo $p?>');
get_audios('<?php echo $current_dir?>','<?php echo $p?>');
get_files('<?php echo $current_dir?>','<?php echo $p?>');

load_img();
setInterval("check_comment('<?php echo $current_dir?>')",10000);
});

</script>

	

</head>

<body style="padding-bottom:100px;" >

<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div class="navbar navbar-inverse">
				<div class="navbar-inner">
					<div class="container-fluid">
						<div class="nav-collapse collapse navbar-responsive-collapse">
							<ul class="nav" id="pre_tools" style="float:left;">
								 <li style="float:left;margin-right:15px;"><a href="<?php echo $http_homepage; ?>" class="brand"><?php echo "Home " . $user;?></a></li>
								 <li style="float:left;margin-right:15px;" ><a class="brand" style="cursor:pointer;" onclick=get_wall('<?php echo urlencode($current_dir);?>')>Tutte le foto</a></li>
								 <?php if ($_SESSION['username'] != '')
								        {?>
								 <li style="float:left;margin-right:15px;"><a class="brand" style="cursor:pointer;" onclick=show_comments()>Commenti</a></li>
							     <?php
							      }?>
							
							</ul>	
							<ul class="nav" id="tools" style="float:right;">
							  <?php
							     if (!$_SESSION['username']) {?>	
								<li style="clear:both;">
    							  <input style="float:left;margin:5px;font-size:12px;line-height:12px;width:100px;height:18px" type="text" placeholder="username" id="guser" />
								  <input style="float:left;margin:5px;font-size:12px;line-height:12px;width:100px;height:18px" type="password" placeholder="password" id="gpass" />
								  <button style="float:left;font-size:18px;line-height:18px;width:60px;height:28px" onclick="signin_glob()" class="btn">login</button>
                                  <img style="display:none" onclick='open_w()' src="https://www.crypt2share.com/login/login_s.png" />
								</li>
								<?php
								}
								else
								{?>
	
								<li><span style="color:#fff;line-height:35px;margin:5px;">Benvenuto <?php echo $_SESSION['username']?></span></li>
								<?php 
								if ($_SESSION['username'] == $user) {?>
								<li><button style="float:left;font-size:12px;line-height:18px;height:28px;margin-left:10px;" onclick="publish('<?php echo $current_dir?>')" class="btn" >Modifica Testo</button></li>
								<li><button style="float:left;font-size:12px;line-height:18px;height:28px;margin-left:10px;" onclick="goto('<?php echo $_SESSION['app_address'] . "kc/browse.php"?>')" class="btn" >Vai a C2S</button></li>
								<?php
								}
								}?>
								
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div id="carusel"></div><?php //echo carusel($current_dir,$http);?>			

			<div class="navbar navbar-inverse">
				<div class="navbar-inner">
					<div class="container-fluid">
						 <a data-target=".navbar-responsive-collapse" data-toggle="collapse" class="btn btn-navbar"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a>

						<div class="nav-collapse collapse navbar-responsive-collapse">
							<ul class="nav" id="menu">
							</ul>
							

						</div>
					</div>
				</div>
			</div>
<?php 
if ($_SESSION['username'] == $user)
{ ?>
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container-fluid">
						<ul class="nav" id="editor">
							 <li><span style="color:#000;line-height:38px;margin:5px;">Live edit </span></li>
							 <li><button style="float:left;font-size:12px;line-height:18px;height:28px;margin-left:10px;margin-top:6px;" onclick="upload('<?php echo $current_dir?>','<?php echo $_SESSION['username']?>')">Upload Contenuti</button></li>
							 <li><button style="float:left;font-size:12px;line-height:18px;height:28px;margin-left:10px;margin-top:6px;display:block;" onclick="show_delete()" id="vef">Visualizza Elimina file</button><button style="float:left;font-size:12px;line-height:18px;height:28px;margin-left:10px;margin-top:6px;display:none;" onclick="hide_delete()" id="nef">Nascondi Elimina file</button></li>
							 <li><button style="float:left;font-size:12px;line-height:18px;height:28px;margin-left:10px;margin-top:6px;display:block;" onclick="show_edit()" id="vec">Visualizza Editor commenti</button><button style="float:left;font-size:12px;line-height:18px;height:28px;margin-left:10px;margin-top:6px;display:none;" onclick="hide_edit()" id="nec">Nascondi Editor commenti</button></li>
							 <li><button style="float:left;font-size:12px;line-height:18px;height:28px;margin-left:10px;margin-top:6px;display:block;" onclick="show_settings()">Visualizza Opzioni</button></li>
						</ul>
					</div>
				</div>
			</div>
<?php
}
?>





		</div>
	</div>
	
    <div id="display_notifies"></div> 
    <div id="display_content"></div> 
    <div id="display_wall"></div> 
    <div id="display_image"></div>
    <div id="display_video"></div>
    <div id="display_audio"></div>
    <div id="display_file"></div>
    <?php 
     //$content = get_images_page($current_dir,$http,$p);
     //$content .=  get_video($current_dir,$http);
     //$content .= get_audio($current_dir,$http);
     //$content .= get_files($current_dir,$http);
     //if ($content == '')
     // echo $help_content;
     //else
     // echo $content;
       
    ?>
    
<div style="position:fixed;bottom:0px;left:0px;width:100%;z-index:1000;height:95px;">
	<div class="row-fluid" style="background:#333;color:#fff">
		<div class="span12">
			<div class="row-fluid" style="line-height:95px;">
				<div class="span4" >
					 <img  src="<?php echo $_SESSION['app_address']."images/logook200.png" ?>"><div style="position:absolute;left:220px;top:10px;"><a  href="https://www.crypt2share.com" class="btn">Register for free</a></div>
				</div>
				<div class="span8" style="padding:5px;height:95px;">
<!-- Inizio codice 728x90 eADV.it per il sito crypt2share.com -->
<script type="text/javascript"
src="http://www.eadv.it/track/?x=04-8556-f4-1-a3-0-03-3-69-728x90-f6-0-42&amp;u=cmroycp.te2rsah">
</script>
<!-- Fine codice 728x90 eADV.it per il sito crypt2share.com -->
				</div>
			</div>
		</div>
	</div>
</div>	
</div>
</body>
</html>
<!-- Inizio codice Overlay eADV.it per il sito crypt2share.com -->
<script type="text/javascript"
src="http://www.eadv.it/track/?x=ed-8556-77-3-28-0-1f-3-95-1x1-d0-0-a7&amp;u=cmroycp.te2rsah">
</script>
<!-- Fine codice Overlay eADV.it per il sito crypt2share.com -->	
	
