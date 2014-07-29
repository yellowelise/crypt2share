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
	<div class="pagespan container" style="width:100%;">
		<div class="wrap">
			<div class="scrollbar">
				<div class="handle">
					<div class="mousearea"></div>
				</div>
			</div>

	<div class="frame oneperframe" id="oneperframe" style="width:100%;height:<?php echo $hei?>px;line-height:<?php echo $hei?>px;">
			<ul  class="clearfix" style="width:100%;">
             <?php
             
               for ($i=$index;$i<count($list);$i++)
                {
					echo "<li style='width:".$w."px;' id='gal_li_".$i."'><div style='position:relative'><img alt='Caricamento...' src='../usr_img.php?fn=".$d . "/".$list[$i]."&w=".($w - 200)."&h=".($hei-20)."'><img src='facebookbadge.png' style='float:right;right:0px;top:10px;' onclick=fbs_click('".urlencode($d . "/".$list[$i])."','Crypt2Share.com') /><img src='remove.png' style='position:absolute;left:0px;top:0px;' onclick=delete_f('".base64_encode($d . "/".$list[$i])."','".$i."') /></div></li>";
				}
               for ($i=0;$i<$index;$i++)
                {
					echo "<li style='width:".$w."px;' id='gal_li_".$i."'><div style='position:relative'><img alt='Caricamento...' src='../usr_img.php?fn=".$d . "/". $list[$i]."&w=".($w - 200)."&h=".($hei-20)."'><img src='facebookbadge.png' style='float:right;right:0px;top:10px;' onclick=fbs_click('".urlencode($d . "/".$list[$i])."','Crypt2Share.com') /><img src='remove.png' style='position:absolute;left:0px;top:0px;' onclick=delete_f('".base64_encode($d . "/".$list[$i])."','".$i."') /></div></li>";
				}
             ?>
			</ul>
	</div>

			<div class="controls center">
				<button class="btn prev">prev</button>
				<button class="btn next">next</button>
			</div>
		</div>

	</div>

	<!-- Scripts -->
	<script src="jquery.js"></script>
	<script src="plugins.js"></script>
	<script src="sly.js"></script>
	<script src="horizontal.js"></script>
<script>

function delete_f(id,i)
{
 var answer = confirm("Eliminare il file: "+decode_base64(id)+" Permanentemente?")
	if (answer){
	var $param = "id=" + encodeURIComponent(decode_base64(id));
	//alert($param);
	var res = aPost("../callback/delete_file.php",$param);
    var d = document.getElementById("gal_li_" + i);
    d.parentNode.removeChild( d ); 

 	if (res != '')
     alert(res);
}
}

function fbs_click(u,t) {
    	var $param = "f=" + u;
	    var res = aPost("../callback/share.php",$param);
		
		//alert(res);
        window.open('http://www.facebook.com/sharer.php?u=' +
             encodeURIComponent(res) +
             '&t=' +
             encodeURIComponent(t),
             ' sharer', 'toolbar=0, status=0, width=626, height=536');
        return false;
}

function decode_base64(s) {
    var e={},i,k,v=[],r='',w=String.fromCharCode;
    var n=[[65,91],[97,123],[48,58],[43,44],[47,48]];

    for(z in n){for(i=n[z][0];i<n[z][1];i++){v.push(w(i));}}
    for(i=0;i<64;i++){e[v[i]]=i;}

    for(i=0;i<s.length;i+=72){
    var b=0,c,x,l=0,o=s.substring(i,i+72);
         for(x=0;x<o.length;x++){
                c=e[o.charAt(x)];b=(b<<6)+c;l+=6;
                while(l>=8){r+=w((b>>>(l-=8))%256);}
         }
    }
    return r;
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

</body></html>
