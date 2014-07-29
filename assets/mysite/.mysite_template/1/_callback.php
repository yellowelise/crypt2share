<?php

session_start();

include("../../config.php");
include("../../class/mysql.class.php");
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);


function format_size($size) {

    $mod = 1024;

    $units = explode(' ','B KB MB GB TB PB');

    for ($i = 0; $size > $mod; $i++) {

        $size /= $mod;
    }

    return round($size, 2) . ' ' . $units[$i];
}





//global $num;
if ($_SESSION['mysite_theme'] == '')
  $_SESSION['mysite_theme'] = '1';

$agg = 0;
if ($_REQUEST['set_ti'])
 {
	$agg = 1;
    $_SESSION['mysite_it'] = $_REQUEST['set_ti'];
 }

if ($_REQUEST['set_tv'])
 {
	$agg = 1;
 $_SESSION['mysite_vt'] = $_REQUEST['set_tv'];
 }

if ($_REQUEST['set_ta'])
 {
	$agg = 1;
 $_SESSION['mysite_at'] = $_REQUEST['set_ta'];
 }

if ($_REQUEST['set_tf'])
 {
	$agg = 1;
 $_SESSION['mysite_ft'] = $_REQUEST['set_tf'];
 }
 
if ($_REQUEST['set_title'])
 {
	$agg = 1;
    
    $_SESSION['mysite_title'] = mres(base64_decode($_REQUEST['set_title']));
 }

if ($_REQUEST['set_hmi'])
 {
	$agg = 1;
 $_SESSION['mysite_hmi'] = $_REQUEST['set_hmi'];
 }
if ($_REQUEST['set_hmv'])
 {
	$agg = 1;
 $_SESSION['mysite_hmv'] = $_REQUEST['set_hmv'];
 }
if ($_REQUEST['set_hmf'])
 {
	$agg = 1;
 $_SESSION['mysite_hmf'] = $_REQUEST['set_hmf'];
 }
if ($_REQUEST['set_hma'])
 {
	// echo "audio";
	$agg = 1;
 $_SESSION['mysite_hma'] = $_REQUEST['set_hma'];
 }

if ($_REQUEST['set_theme'])
 {
	// echo "audio";
	$agg = 1;
 $_SESSION['mysite_theme'] = $_REQUEST['set_theme'];
 }

 

if ($_REQUEST['num'])
 {
	$num =  $_REQUEST['num'];
 }



// echo "num:". $_REQUEST['num'];

$http = $_SESSION['app_address'] . "homes/";

//echo $_REQUEST['dir'];

if ($_REQUEST['dir'])
 $_SESSION['mysite_user'] = substr($_REQUEST['dir'],0,strpos($_REQUEST['dir'],"/"));//"and";//basename($url);

$user = $_SESSION['mysite_user'];
 
if ($user == $_SESSION['username'])
 $_SESSION['owner'] = 1;
else
 $_SESSION['owner'] = 0;
   
if ($_REQUEST['t'])
 $data =  $_REQUEST['t'];
if ($data == '')
 $data = ""; 


//echo $user;
if ($_REQUEST['dir'])
 $d =  $_REQUEST['dir'];
if ($d == '')
 $d = $user . "/files/mysite/"; 

if ($_REQUEST['p'])
 $p = $_REQUEST['p'];
else
 $p = 1;

if ($_REQUEST['r'])
 $resource = mres(base64_decode($_REQUEST['r']));

if ($_REQUEST['c'])
$comment = mres(base64_decode($_REQUEST['c']));

if ($_REQUEST['uu'])
 $uu = $_REQUEST['uu'];
else
 $uu = "";

if ($_REQUEST['w'])
 $w = $_REQUEST['w'];
else
 $w = 1000;

if ($_REQUEST['pp'])
 $pp = $_REQUEST['pp'];
else
 $pp = "";
 

if ($agg == 1)
 {
   // echo "aggiorno: " .$user; 
	 set_settings($user);  	 
 }

if ((!$_SESSION['mysite_title'])||($_SESSION['mysite_title'] ==''))
 get_settings($user);

function get_settings($user)
{
	 $db = new MySQL(true);
	 if ($db->Error()) $db->Kill();
	 $db->Open();
	 $sql = "select * from  mysite_settings  where username='".$user."'";
	 //echo $sql."<br />";
	 $results = $db->QueryArray($sql);
	 $db->Close();
      if ($results)
       {
		   $_SESSION['mysite_title'] = $results[0]['Title'];
		   $_SESSION['mysite_it'] = $results[0]['images_title'];
		   $_SESSION['mysite_vt'] = $results[0]['videos_title'];
		   $_SESSION['mysite_ft'] = $results[0]['files_title'];
		   $_SESSION['mysite_at'] = $results[0]['audios_title'];
		   $_SESSION['mysite_hmi'] = $results[0]['how_many_images'];
		   $_SESSION['mysite_hmv'] = $results[0]['how_many_videos'];
		   $_SESSION['mysite_hmf'] = $results[0]['how_many_files'];
		   $_SESSION['mysite_hma'] = $results[0]['how_many_audios'];
		   $_SESSION['mysite_theme'] = $results[0]['theme'];
		    
	   }
	 else
       {
		   $_SESSION['mysite_title'] = 'MySite - Crypt2Share.com';
		   $_SESSION['mysite_it'] = 'Foto';
		   $_SESSION['mysite_vt'] = 'Video';
		   $_SESSION['mysite_ft'] = 'File';
		   $_SESSION['mysite_at'] = 'Audio';
		   $_SESSION['mysite_hmi'] = '6';
		   $_SESSION['mysite_hmv'] = '4';
		   $_SESSION['mysite_hmf'] = '6';
		   $_SESSION['mysite_hma'] = '4';
		   $_SESSION['mysite_theme'] = '1';
		    
	   }
	     
  
}


function example($qi,$qv,$qa,$qf,$dim,$h)
{
	$res = "<h3>Layout MySite</h3>";
	$res .= "<div style='width:".($dim+20)."px;height:".$h."px;overflow-y:auto'><div style='-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;border:1px solid black;height:".($dim /12)."px;width:".($dim-10)."px;'>Header</div><div style='margin-top:5px;'>";
    
    if (($qi>=100))
      $res .= "<div  style='float:left;margin-left:2px;margin-bottom:2px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;border:1px solid black;width:".(($dim)-5)."px'><img src='../.mysite_template/".$_SESSION['mysite_theme']."/img/png.png'></div>";
    else 
    for ($i=0;$i<$qi;$i++)
      $res .= "<div  style='float:left;margin-left:2px;margin-bottom:2px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;border:1px solid black;width:".(($dim/$qi)-5)."px'><img src='../.mysite_template/".$_SESSION['mysite_theme']."/img/png.png'></div>";
    $res .= "</div><div style='margin-top:5px;'>";  
    for ($i=0;$i<$qv;$i++)
      $res .= "<div  style='float:left;margin-left:2px;margin-bottom:2px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;border:1px solid black;width:".(($dim/$qv)-5)."px'><img src='../.mysite_template/".$_SESSION['mysite_theme']."/img/avi.png'></div>";
    $res .= "</div><div style='margin-top:5px;'>";  
    for ($i=0;$i<$qa;$i++)
      $res .= "<div  style='float:left;margin-left:2px;margin-bottom:2px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;border:1px solid black;width:".(($dim/$qa)-5)."px'><img src='../.mysite_template/".$_SESSION['mysite_theme']."/img/mid.png'></div>";
    $res .= "</div><div style='margin-top:5px;'>";  
    for ($i=0;$i<$qf;$i++)
      $res .= "<div  style='float:left;margin-left:2px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;border:1px solid black;width:".(($dim/$qf)-5)."px'><img src='../.mysite_template/".$_SESSION['mysite_theme']."/img/doc.png'></div>";
    $res .= "</div></div>";  
	return $res;
}

function set_settings($user)
{
	 $db = new MySQL(true);
	 if ($db->Error()) $db->Kill();
	 $db->Open();

	 $sql = "delete from mysite_settings where username='".$user."'";
	 //echo $sql."<br />";
	 $results = $db->Query($sql);
	 $db->Close();
	 
	 $db->Open();
	 $sql = "insert into  mysite_settings (Title,images_title,videos_title,files_title,audios_title,how_many_images,how_many_videos,how_many_audios,how_many_files,username,theme) 
			values ('".$_SESSION['mysite_title']."','".$_SESSION['mysite_it']."','".$_SESSION['mysite_vt']."','".$_SESSION['mysite_ft']."','".$_SESSION['mysite_at']."',
			'".$_SESSION['mysite_hmi']."','".$_SESSION['mysite_hmv']."','".$_SESSION['mysite_hma']."','".$_SESSION['mysite_hmf']."','".$user."','".$_SESSION['mysite_theme']."')";
	 //echo $sql."<br />";
	 $results = $db->Query($sql);
	 $db->Close();
      if ($results)
       {
		   $_SESSION['mysite_title'] = $results[0]['title'];
		   $_SESSION['mysite_it'] = $results[0]['images_title'];
		   $_SESSION['mysite_vt'] = $results[0]['videos_title'];
		   $_SESSION['mysite_ft'] = $results[0]['files_title'];
		   $_SESSION['mysite_at'] = $results[0]['audios_title'];
		   $_SESSION['mysite_hmi'] = $results[0]['how_many_images'];
		   $_SESSION['mysite_hmv'] = $results[0]['how_many_videos'];
		   $_SESSION['mysite_hmf'] = $results[0]['how_many_files'];
		   $_SESSION['mysite_hma'] = $results[0]['how_many_audios'];
		   $_SESSION['mysite_theme'] = $results[0]['theme'];
		    
	   }
	 else
       {
		   $_SESSION['mysite_title'] = 'MySite - Crypt2Share.com';
		   $_SESSION['mysite_it'] = 'Foto';
		   $_SESSION['mysite_vt'] = 'Video';
		   $_SESSION['mysite_ft'] = 'File';
		   $_SESSION['mysite_at'] = 'Audio';
		   $_SESSION['mysite_hmi'] = '6';
		   $_SESSION['mysite_hmv'] = '4';
		   $_SESSION['mysite_hmf'] = '6';
		   $_SESSION['mysite_hma'] = '4';
		   $_SESSION['mysite_theme'] = '1';
		    
	   }
	     
  
}




function roundUpToAny($n,$x=5) {
    return round(($n+$x/2)/$x)*$x;
}

function mres($value)
{
    $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
    $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

    return str_replace($search, $replace, $value);
}


function content($resource)
{
	 $db = new MySQL(true);
	 if ($db->Error()) $db->Kill();
	 $db->Open();
	 $sql = "select content from  mysite_contents  where resource='".$resource."'";
	 //echo $sql."<br />";
	 $results = $db->QueryArray($sql);
	 $db->Close();
     return $results[0]['content'];
}

function newdescription($resource,$desc)
{
 if ($_SESSION['username']) //todo check if owner
  {	
	 $db = new MySQL(true);
	 if ($db->Error()) $db->Kill();
	 $db->Open();
	 $sql = "delete from  mysite_comments where resource = '".$resource."' and comment_user = '".$_SESSION['username']."' and type = 1";
	 echo $sql."<br />";
	 $results = $db->Query($sql);
	 $db->Close();
	 $db->Open();
	 $sql = "insert into  mysite_comments (resource,comment,comment_user,ip,type) values ('".$resource."','".utf8_encode($desc)."','".$_SESSION['username']."','".$_SERVER['REMOTE_ADDR']."',1)";
	 echo $sql."<br />";
	 $results = $db->Query($sql);
	 $db->Close();
	 //update_notifier($resource,$_SESSION['username']);
  }
  
}

function email_from_username($user)
{
	 $db1 = new MySQL(true);
	 if ($db1->Error()) $db1->Kill();
	 $db1->Open();
	 $sql = "select email from users where username ='".$user."'";
	 echo $sql."<br />";
	 $results = $db1->QueryArray($sql);
     if ($results)
      return $results[0]['email'];
     else
      return ''; 
      
}


function sendmail($owner)
{
		$to      = email_from_username($owner);
		$subject = "Nuovi commenti su MySite";
		$message = "Hai dei nuovi commenti sul tuo MySite!\nAccedi al tuo MySite per leggerli.";
		$l = $_SESSION["mysite_address"] . $owner;
		$headers = 'From: share@crypt2share.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

		$headers .= "MIME-Version: 1.0\n";
		$headers .= 'Content-Type: text/html; charset=\"iso-8859-1\"\n';
		$headers .= "Content-Transfer-Encoding: 7bit\n\n";
		//mail($to, $subject, $message, $headers);	
		$tmpl = file_get_contents("../mail.tpl");
		$message_tpl = str_replace("#messagebody#",str_replace("\n","<br />",$message. "\nlink: " . $l),$tmpl);

    	mail($to,$subject,$message_tpl ,$headers);
		//echo $to . "<br />".$subject . "<br />";
}


function newcomment($resource,$comment)
{
 if ($_SESSION['username'])
  {	
	 $db = new MySQL(true);
	 if ($db->Error()) $db->Kill();
	 $db->Open();
	 $sql = "insert into  mysite_comments  (resource,comment,comment_user,ip) values ('".$resource."','".utf8_encode($comment)."','".$_SESSION['username']."','".$_SERVER['REMOTE_ADDR']."')";
	 //echo $sql."<br />";
	 $results = $db->Query($sql);
	 $db->Close();
	 update_notifier($resource,$_SESSION['username']);
	 
	 $owner = substr($resource,0, strpos($resource,"%2F"));
	 sendmail($owner);
  }
  
}

function update_notifier($resource,$user)
{
 if ($_SESSION['username'])
  {	
	 $db = new MySQL(true);
	 if ($db->Error()) $db->Kill();
	 $db->Open();
	 $sql = "delete from mysite_notifies where username ='".$user."' and resource ='".$resource."'";
	 
	 //echo $sql."<br />";
	 $results = $db->Query($sql);

	 $sql = "insert into mysite_notifies (username,resource) values ('".$user."','".$resource."')";
	 
	 //echo $sql."<br />";
	 $results = $db->Query($sql);
	 $db->Close();
  }
}




function check_for_notification($resource,$user,$data)
{
   $db = new MySQL(true);
   if ($db->Error()) $db->Kill();
	$db->Open();
 if ($data =='')
 {
 $sql = "select date_last_view from mysite_notifies where username ='".$user."' and resource ='".$resource."'";
//echo $sql."<br />";
 $results = $db->QueryArray($sql);
 if ($results)
  $data = $results[0]['date_last_view'];
 else
  $data = '';
 }
else
 {
	 $sec = $data * 60;
	 $data = date("Y-m-d G:i:s", time() - $sec);
 } 
 //echo "ultima visita: " . $data . "<br />";
// $sql = "select count(idmysite_notifies) as num_comments from mysite_notifies where (username !='".$user."' and resource ='".$resource."') and (TIME_TO_SEC(TIMEDIFF(now(),'".$data."')) > 0)";
 $sql = "select count(comment) as num_comments from mysite_comments where (comment_user !='".$user."' and resource ='".$resource."' and type=0) and (TIME_TO_SEC(TIMEDIFF(date,'".$data."')) >= 0)";
 //if ($data != '')
 // echo $sql."\n";
 $results = $db->QueryArray($sql);
 if ($results)
  return $results[0]['num_comments'];
 else
  return "0"; 

	  
	  
}

function get_description($resource)
{
	//echo $resource;
// $noti = check_for_notification($resource,$_SESSION['username']);

// update_notifier($resource,$_SESSION['username']);
 $db = new MySQL(true);
 if ($db->Error()) $db->Kill();
 $db->Open();
 $sql = "select * from mysite_comments where resource = '".$resource."' and type=1 order by date";
 //echo $sql."<br />";
 $results = $db->QueryArray($sql);
 $db->Close();
 //$res = '<div id="descr">';
 $res = '';
 if (($results))
  {
	 for ($i=0;$i<count($results);$i++) 
	  {
	    $res .= $results[$i]['comment'];
      }
  }
 //$res .= "</div>";	

 return $res;	
}

function comments($resource)
{
	//echo $resource;
if ($_SESSION['username']) 
 { 
 $noti = check_for_notification($resource,$_SESSION['username'],'');
 
 update_notifier($resource,$_SESSION['username']);
 $i = 1;
		   if ($_SESSION['owner'] == 1) 
		      $descr = "<pre style='text-align:left;padding:1px;width:90%;'><strong><img id='save_".$i."' src='../.mysite_template/".$_SESSION['mysite_theme']."/img/salva.png' style='cursor:pointer;display:none' onclick=save_descr('".$resource."','".$i."')><img id='edit_".$i."' src='../.mysite_template/".$_SESSION['mysite_theme']."/img/edit.png' style='cursor:pointer;display:block' onclick=change_descr('".$resource."','".$i."')><span id='span_text_".$i."'>" .get_description($resource) . "</span><textarea style='padding:1px;display:none;width:100%;' id='text_descr_".$i."'>".get_description($resource)."</textarea></strong></pre>";
		   else
              $descr = "<pre style='text-align:left;padding:1px;width:90%;'><strong>".get_description($resource)."</strong></pre>";

// $descr = "<pre style='text-align:left;padding:1px;width:90%;'><strong>".get_description($resource)."</strong></pre>";
// $descr = "<pre style='text-align:left;padding:1px;width:90%;'><strong>".get_description($resource)."</strong></pre>";
 $db = new MySQL(true);
 if ($db->Error()) $db->Kill();
 $db->Open();
 $sql = "select * from mysite_comments where resource = '".$resource."' and type= 0 order by date";
// echo $sql."<br />";
 $results = $db->QueryArray($sql);
 $db->Close();
 $res = '<div id="pre_comm">' .$descr;
 if (($results))
  {
	  
             
             	  
	 for ($i=0;$i<count($results);$i++) 
	  {
	    $res .= "<pre style='text-align:left;padding:1px;width:90%;' ><font style='font-size:10px;'>(".$results[$i]['date'].")</font>&nbsp;&nbsp;<strong>". $results[$i]['comment_user'] . ":</strong><br /> " . $results[$i]['comment']."</pre>";
	  }
  }
 $res .= "</div>". $noti . " Nuovi commenti.<br /><textarea id='comment' style='float:left;width:70%;height:50px;'></textarea><button style='float:left;width:120px;height:60px;' onclick=send_comm('".$resource."')>Invia</button>";	
}
else
 {
	$res =  "<div style='text-align:left;'><label >Accedi con il tuo account Crypt2Share per commentare</label><br /><input  style='float:left;width:120px;line-height:25px;' placeholder='Username' type='text' id='user' />&nbsp;<input style='float:left;width:120px;line-height:25px;' placeholder='Password' type='password' id='pass' /><button style='float:left;line-height:25px;margin:0px;' onclick=signin('".$resource."')>SignIn</button></div>"; 
 }
 return $res;	
}



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
			 $res .= '<li ><a style="padding-right:0px;" href="?dir='.base64_encode(str_replace($_SESSION["path"],"",$dir[$i])).'">'.basename($dir[$i]).'</a></li><li class="dropdown left" style="margin-left:5px;"><a style="padding-left:0px;" data-toggle="dropdown" class="dropdown-toggle" href="#"><strong class="caret"></strong></a><ul class="dropdown-menu">';
			 
			$res .='<li style="background:#333;color:#fff;padding:6px;"> '.basename($dir[$i]).'</li>';
			 for ($k=0;$k<count($subdir);$k++)
			  {
				$res .='<li><a href="?dir='.base64_encode(str_replace($_SESSION["path"],"",$subdir[$k])).'">'.basename($subdir[$k]).'</a></li>';
			 }

			$res .= '</ul><li class="divider">
										</li>';
	           $res .=   '</li>';

		 }    
   //'<button class="btn">'.basename($dir[$i]).'</button>';
				
   }

return $res;
}


function delete_file($r)
{
	$u = substr($r,0,strpos($r,"/"));
	//echo  $r . "\n pos:" .strpos($r,"/") . "\n" . $u . "\n" ;
	if ($_SESSION['username'] == $u)
	 {
	  	 
       $file = $_SESSION['path'] . $r;
       unlink($file); 
       
	 }
	else 
	 return "Errore nella cancellazione!"; 
}


function how_many_images($d)
{
   // echo $d;
   $d = $_SESSION['path'] . $d;
    //echo $d;
 	$images = glob($d."{*.jpeg,*.jpg,*.gif,*.png,*.JPEG,*.JPG,*.GIF,*.PNG}", GLOB_BRACE);
    $quante = count($images);
    unset($images);
   return $quante; 
}

function get_images_page($d,$http,$p)
{
	$num = $_SESSION['mysite_hmi'];
	$ud = $d;
	$d = $_SESSION["path"] . $d;
	$images = glob($d."{*.jpeg,*.jpg,*.gif,*.png,*.JPEG,*.JPG,*.GIF,*.PNG}", GLOB_BRACE);
	sort($images);
    $quante = count($images);
   if ($quante != 0)
    {
    $quante_pagine = roundUpToAny($quante/$num,1);
    if ($quante_pagine == (($quante/$num) +1))
     $quante_pagine = $quante_pagine -1;
     
    if ($quante_pagine > 1)
    {

    $pagi = "<div class='pagination'><ul>";
    if ($p>1)
     $pagi .= "<li><a style='cursor:pointer;' onclick=get_images('".urlencode($ud)."',".($p-1).")>Prev</a></li>";
    else
     $pagi .= "<li><a>Prev</a></li>";

    for ($k=1;$k<=$quante_pagine;$k++)
      {
		 if ($p == ($k))
		  $pagi .= "<li class='active'><a style='cursor:pointer;' onclick=get_images('".urlencode($ud)."',".$k.")>".($k)."</a></li>";
         else 
		  $pagi .= "<li><a style='cursor:pointer;' onclick=get_images('".urlencode($ud)."',".$k.")>".($k)."</a></li>";
	  }
	  
	if ($p <$quante_pagine)  
     $pagi .= "<li><a style='cursor:pointer;' onclick=get_images('".urlencode($ud)."',".($p+1).")>Next</a></li>";
    else
     $pagi .= "<li><a>Next</a></li>";
    $pagi .="</ul></div>";
}    
    if ($quante <= $num)
     {
       $num = $quante;
     }
    $size = round((1000/$num)-((1/$num)*100));

	$res = "<div class='row-fluid'><div class='span3'><h3>".$_SESSION['mysite_it']."</h3></div><div class='span9'>".$pagi."</div></div>";
    $res .= "<div class='row-fluid'>";
    for ($i=(($p-1)*$num);$i<((($p-1)*$num) + $num);$i++)
      {
        if ($images[$i])
		   {
		   if ($_SESSION['owner'] == 1) 
		      $descr = "<img id='save_".$i."' src='../.mysite_template/".$_SESSION['mysite_theme']."/img/salva.png' style='cursor:pointer;display:none' onclick=save_descr('".urlencode($ud . basename($images[$i]))."','".$i."')><img id='edit_".$i."' src='../.mysite_template/".$_SESSION['mysite_theme']."/img/edit.png' style='cursor:pointer;display:none' onclick=change_descr('".urlencode($ud . basename($images[$i]))."','".$i."')><span id='span_text_".$i."'>" .get_description(urlencode($ud . basename($images[$i]))) . "</span><textarea style='padding:1px;display:none;width:100%;' id='text_descr_".$i."'>".get_description(urlencode($ud . basename($images[$i])))."</textarea>";
		   else
              $descr = get_description(urlencode($ud . basename($images[$i])));
		    
		    if ($_SESSION['owner'] ==1)
             $dbl = " ondblclick=change_descr('".urlencode($ud . basename($images[$i]))."','".($i)."')";
            else
             $dbl = ""; 
 
		    if (($descr == '')&&($_SESSION['owner'] != 1))
		      $vis = "none";
		    else
		      $vis = "block"; 

		     $res .= "<div class='span".round(12/$num)."'><a style='cursor:pointer;' onclick=\"show_gallery('".urlencode($ud)."','".urlencode(basename($images[$i]))."','')\"><div style='position:relative;float: none;margin: 0 auto;text-align: center;display: block;width:auto;height:auto;'><img src='../.mysite_template/".$_SESSION['mysite_theme']."/img/delete.png' style='visibility:hidden;cursor:pointer;margin-right:5px;' id='delete' onclick=delete_file('".base64_encode($ud . basename($images[$i]))."') ><br /><pre class='filename'>".basename($images[$i])."</pre><img id='img_".$p."_".$i."' alt='".urlencode($ud . basename($images[$i]))."&s=".$size."&c=1' class='img-polaroid'></a></div><pre style='display:".$vis."' id='descr_".$i."' ".$dbl.">".$descr."</pre></div>";
		   }		 
	  }
    $res .= "</div><br />";
   } 
  unset($images); 
  return $res;
}



function get_videos_page($d,$http,$p)
{
	$num = $_SESSION['mysite_hmv'];
	$ud = $d;
	$d = $_SESSION["path"] . $d;
	$images = glob($d."{*.mp4,*.3gp,*.flv,*.mov,*.ogv}", GLOB_BRACE);
	sort($images);
	//print_r($images);
    $quante = count($images);
   if ($quante != 0)
    {
    $quante_pagine = roundUpToAny($quante/$num,1);
    if ($quante_pagine == (($quante/$num) +1))
     $quante_pagine = $quante_pagine -1;

    if ($quante_pagine > 1)
    {

    $pagi = "<div class='pagination'><ul>";
    if ($p>1)
     $pagi .= "<li><a style='cursor:pointer;' onclick=get_videos('".urlencode($ud)."',".($p-1).")>Prev</a></li>";
    else
     $pagi .= "<li><a>Prev</a></li>";

    for ($k=1;$k<=$quante_pagine;$k++)
      {
		 if ($p == ($k))
		  $pagi .= "<li class='active'><a style='cursor:pointer;' onclick=get_videos('".urlencode($ud)."',".$k.")>".($k)."</a></li>";
         else 
		  $pagi .= "<li><a style='cursor:pointer;' onclick=get_videos('".urlencode($ud)."',".$k.")>".($k)."</a></li>";
	  }
	  
	if ($p <$quante_pagine)  
     $pagi .= "<li><a style='cursor:pointer;' onclick=get_videos('".urlencode($ud)."',".($p+1).")>Next</a></li>";
    else
     $pagi .= "<li><a>Next</a></li>";
    $pagi .="</ul></div>";
}    
    if ($quante <= $num)
     {
       $num = $quante;
     }
    $size = round((1000/$num)-((1/$num)*100));
    
	$res = "<div class='row-fluid'><div class='span3'><h3>".$_SESSION['mysite_vt']."</h3></div><div class='span9'>".$pagi."</div></div>";
    $res .= "<div class='row-fluid'>";
    for ($i=(($p-1)*$num);$i<((($p-1)*$num) + $num);$i++)
      {
        if ($images[$i])
		   {
		   if ($_SESSION['owner'] == 1) 
		      $descr = "<img id='save_".($i+100)."' src='../.mysite_template/".$_SESSION['mysite_theme']."/img/salva.png' style='cursor:pointer;display:none' onclick=save_descr('".urlencode($ud . basename($images[$i]))."','".($i+100)."')><img id='edit_".($i+100)."' src='../.mysite_template/".$_SESSION['mysite_theme']."/img/edit.png' style='cursor:pointer;display:none' onclick=change_descr('".urlencode($ud . basename($images[$i]))."','".($i+100)."')><span id='span_text_".($i+100)."' >" .get_description(urlencode($ud . basename($images[$i]))) . "</span><textarea style='padding:1px;display:none;width:100%;' id='text_descr_".($i+100)."'>".get_description(urlencode($ud . basename($images[$i])))."</textarea>";//" <img src='../.mysite_template/".$_SESSION['mysite_theme']."/img/edit25.png' onclick=change_descr('".urlencode($ud . basename($images[$i]))."','".$i."')>";
		   else
              $descr = get_description(urlencode($ud . basename($images[$i])));
		    
		    if ($_SESSION['owner'] ==1)
             $dbl = " ondblclick=change_descr('".urlencode($ud . basename($images[$i]))."','".($i+100)."')";
            else
             $dbl = ""; 

		    if (($descr == '')&&($_SESSION['owner'] != 1))
		      $vis = "none";
		    else
		      $vis = "block"; 
		     //echo $dbl."<br />";
		     $res .= "<div class='span".round(12/$num)."' style='height:auto;'>
						<div style='position:relative;float: none;margin: 0 auto;text-align: center;'>
						  <img src='../.mysite_template/".$_SESSION['mysite_theme']."/img/delete.png' style='visibility:hidden;cursor:pointer;margin-right:5px;' id='delete' onclick=delete_file('".base64_encode($ud . basename($images[$i]))."') ><br />
						  <div style='position:relative;float: none;margin: 0 auto;text-align: center;display: block;width:auto;height:auto;'>
							 <a style='height:25px;' href='../download.php?fn=".urlencode($ud.basename($images[$i]))."'><pre class='filename'><img src='../.mysite_template/".$_SESSION['mysite_theme']."/img/download.png' />&nbsp;".basename($images[$i])."</pre></a>
							</div>
						   <div id='video_".$i."' name='video_".$i."' style='position:relative;float: none;margin: 0 auto;text-align: center;display: block;'>
						   <a style='cursor:pointer;' onclick=create_media('video_".$i."','".base64_encode($http . $ud . basename($images[$i]))."',".$size.",".($size / 1.3333).")><img style='width:".$size."px;height:".($size / 1.3333)."px' src='../video.png'></a>
						  </div>
							
					     </div>
		     <pre style='display:".$vis."' id='descr_".($i+100)."' ".$dbl.">".$descr."</pre>
		     
							</div>";
//		     <a style='cursor:pointer;' onclick=\"show_gallery('".urlencode($ud)."','".urlencode(basename($images[$i]))."','')\"><div style='position:relative;float: none;margin: 0 auto;text-align: center;display: block;width:auto;height:auto;'><img alt='".$i."' src='../img_my.php?fn=".urlencode($ud . basename($images[$i]))."&s=".$size."&c=1' class='img-polaroid'></a><br />".basename($images[$i])."</div>

		   }		 
	  }
    $res .= "</div><br />";
			  
    
    
   } 
    
  unset($images);    
    return $res;
}


function get_audios_page($d,$http,$p)
{
	$num = $_SESSION['mysite_hma'];

	$ud = $d;
	$d = $_SESSION["path"] . $d;
	$images = glob($d."{*.aac,*.m4a,*.f4a,*.mp3,*.ogg,*.oga,*.AAC,*.M4A,*.F4A,*.MP3,*.OGG,*.OGA}", GLOB_BRACE);
	sort($images);
	//print_r($images);
    $quante = count($images);
    if ($quante != 0)
    {
    $quante_pagine = roundUpToAny($quante/4,1);
    if ($quante_pagine == (($quante/$num) +1))
      $quante_pagine = $quante_pagine -1;
    if ($quante_pagine > 1)
    {

    $pagi = "<div class='pagination'><ul>";
    if ($p>1)
     $pagi .= "<li><a style='cursor:pointer;' onclick=get_audios('".urlencode($ud)."',".($p-1).")>Prev</a></li>";
    else
     $pagi .= "<li><a>Prev</a></li>";
    for ($k=1;$k<=$quante_pagine;$k++)
      {
		 if ($p == ($k))
		  $pagi .= "<li class='active'><a style='cursor:pointer;' onclick=get_audios('".urlencode($ud)."',".$k.")>".($k)."</a></li>";
         else 
		  $pagi .= "<li><a style='cursor:pointer;' onclick=get_audios('".urlencode($ud)."',".$k.")>".($k)."</a></li>";
	  }
	  
	if ($p <$quante_pagine)  
     $pagi .= "<li><a style='cursor:pointer;' onclick=get_audios('".urlencode($ud)."',".($p+1).")>Next</a></li>";
    else
     $pagi .= "<li><a>Next</a></li>";
    $pagi .="</ul></div>";
    
}
   if ($quante <= $num)
     {
       $num = $quante;
     }
    $size = round((1000/$num)-((1/$num)*100));

	$res = "<div class='row-fluid'><div class='span3'><h3>".$_SESSION['mysite_at']."</h3></div><div class='span9'>".$pagi."</div></div>";
    $res .= "<div class='row-fluid'  style='height:auto;'>";
    for ($i=(($p-1)*$num);$i<((($p-1)*$num) + $num);$i++)
      {
        if ($images[$i])
		   {
//		     $res .= "<div class='span2'><a style='cursor:pointer;' onclick=\"show_gallery('".$ud."','".basename($images[$i])."')\"><img alt='".$i."' src='../../img_my.php?fn=".$ud . basename($images[$i])."&s=160&c=1' class='img-polaroid'></a><br />".basename($images[$i])."</div>";
		   if ($_SESSION['owner'] == 1) 
		    {
			  //echo "owner";	
		      $descr = "<img id='save_".($i+200)."' src='../.mysite_template/".$_SESSION['mysite_theme']."/img/salva.png' style='cursor:pointer;display:none' onclick=save_descr('".urlencode($ud . basename($images[$i]))."','".($i+200)."')><img id='edit_".($i+200)."' src='../.mysite_template/".$_SESSION['mysite_theme']."/img/edit.png' style='cursor:pointer;display:none' onclick=change_descr('".urlencode($ud . basename($images[$i]))."','".($i+200)."')><span id='span_text_".($i+200)."'>" .get_description(urlencode($ud . basename($images[$i]))) . "</span><textarea style='padding:1px;display:none;width:100%;' id='text_descr_".($i+200)."'>".get_description(urlencode($ud . basename($images[$i])))."</textarea>";//" <img src='../.mysite_template/".$_SESSION['mysite_theme']."/img/edit25.png' onclick=change_descr('".urlencode($ud . basename($images[$i]))."','".$i."')>";
		    }
		   else
		    {
							 // echo "not owner";	
              $descr = get_description(urlencode($ud . basename($images[$i])));
		    } 


		    if ($_SESSION['owner'] ==1)
             $dbl = " ondblclick=change_descr('".urlencode($ud . basename($images[$i]))."','".($i+200)."')";
            else
             $dbl = ""; 

		    
		    if (($descr == '')&&($_SESSION['owner'] != 1))
		     $vis = "none";
		    else
		     $vis = "block"; 
		  

			   $res .= "<div class='span".round(12/$num)."'>
			              <div style='position:relative;float: none;margin: 0 auto;text-align: center;'>
							<img src='../.mysite_template/".$_SESSION['mysite_theme']."/img/delete.png' style='visibility:hidden;cursor:pointer;margin-right:5px;' id='delete' onclick=delete_file('".base64_encode($ud . basename($images[$i]))."') ><br />
							<a style='height:25px;' href='../download.php?fn=".urlencode($ud.basename($images[$i]))."'>
								<pre class='filename'><img src='../.mysite_template/".$_SESSION['mysite_theme']."/img/download.png' />&nbsp;".basename($images[$i])."</pre>
							 </a>
							 
							<div id='audio_".($i+200)."' name='audio_".($i+200)."'>
								<a style='cursor:pointer;' onclick=create_media_html5('audio_".($i+200)."','".base64_encode($http . $ud . basename($images[$i]))."',".$size.",".($size / 1.3333).")>
									<img style='width:".$size."px;height:".($size / 1.3333)."px' src='../audio.png'>
								</a>
							<pre style='display:".$vis."' id='descr_".($i+200)."' ".$dbl.">".$descr."</pre>
							</div>
							
						</div></div>";
		   }		 
	  }
    $res .= "</div><br />";
}		  
    
    
    
    
      unset($images);
    return $res;
}

function get_files_page($d,$http,$p)
{
	$num = $_SESSION['mysite_hmf'];

	$ud = $d;
	$d = $_SESSION["path"] . $d;
	$images = glob($d."{*.zip,*.doc,*.docx,*.ods,*.odt,*.pdf,*.xls,*.txt,*.rar,*.tgz,*.ZIP,*.DOC,*.DOCX,*.ODS,*.ODT,*.PDF,*.XLS,*.TXT,*.RAR,*.TGZ}", GLOB_BRACE);
	sort($images);
	//print_r($images);
    $quante = count($images);
    if ($quante != 0)
    {
    $quante_pagine = roundUpToAny($quante/$num,1);
    if ($quante_pagine == (($quante/$num) +1))
      $quante_pagine = $quante_pagine -1;

   if ($quante_pagine > 1)
    {
    $pagi = "<div class='pagination'><ul>";
    if ($p>1)
     $pagi .= "<li><a style='cursor:pointer;' onclick=get_files('".urlencode($ud)."',".($p-1).")>Prev</a></li>";
    else
     $pagi .= "<li><a>Prev</a></li>";
    for ($k=1;$k<=$quante_pagine;$k++)
      {
		 if ($p == ($k))
		  $pagi .= "<li class='active'><a style='cursor:pointer;' onclick=get_files('".urlencode($ud)."',".$k.")>".($k)."</a></li>";
         else 
		  $pagi .= "<li><a style='cursor:pointer;' onclick=get_files('".urlencode($ud)."',".$k.")>".($k)."</a></li>";
	  }
	  
	if ($p <$quante_pagine)  
     $pagi .= "<li><a style='cursor:pointer;' onclick=get_files('".urlencode($ud)."',".($p+1).")>Next</a></li>";
    else
     $pagi .= "<li><a>Next</a></li>";
    $pagi .="</ul></div>";
	}

    if ($quante <= $num)
     {
       $num = $quante;
     }
     
    $size = round((1000/$num)-((1/$num)*100));    
	
	$res = "<div class='row-fluid'><div class='span3'><h3>".$_SESSION['mysite_ft']."</h3></div><div class='span9'>".$pagi."</div></div>";
    $res .= "<div class='row-fluid'>";
    for ($i=(($p-1)*$num);$i<((($p-1)*$num) + $num);$i++)
      {
        if ($images[$i])
		   {
			   if ($_SESSION['owner'] == 1) 
				  $descr = "<img id='save_".($i+300)."' src='../.mysite_template/".$_SESSION['mysite_theme']."/img/salva.png' style='cursor:pointer;display:none' onclick=save_descr('".urlencode($ud . basename($images[$i]))."','".($i+300)."')><img id='edit_".($i+300)."' src='../.mysite_template/".$_SESSION['mysite_theme']."/img/edit.png' style='cursor:pointer;display:none' onclick=change_descr('".urlencode($ud . basename($images[$i]))."','".($i+300)."')><span id='span_text_".($i+300)."'>" .get_description(urlencode($ud . basename($images[$i]))) . "</span><textarea style='padding:1px;display:none;width:100%;' id='text_descr_".($i+300)."'>".get_description(urlencode($ud . basename($images[$i])))."</textarea>";//" <img src='../.mysite_template/".$_SESSION['mysite_theme']."/img/edit25.png' onclick=change_descr('".urlencode($ud . basename($images[$i]))."','".$i."')>";
			   else
				  $descr = get_description(urlencode($ud . basename($images[$i])));
				
				if ($_SESSION['owner'] == 1)
				 $dbl = " ondblclick=change_descr('".urlencode($ud . basename($images[$i]))."','".($i+300)."')";
				else
				 $dbl = ""; 

				if (($descr == '')&&($_SESSION['owner'] != 1))
				 $vis = "none";
				else
				 $vis = "block"; 
		  

			   $res .= "<div class='span".round(12/$num)."'>
			              <div style='position:relative;float: none;margin: 0 auto;text-align: center;width:auto;height:auto;'>
			                 <img src='../.mysite_template/".$_SESSION['mysite_theme']."/img/delete.png' style='visibility:hidden;cursor:pointer;margin-right:5px;' id='delete' onclick=delete_file('".base64_encode($ud . basename($images[$i]))."') >
			                 <br />
			                 <a  href='../download.php?fn=".urlencode($ud.basename($images[$i]))."'><pre class='filename'>".basename($images[$i])."<br />".format_size(filesize($images[$i]))."</pre><img alt='".$i."' src='../img_my.php?fn=".urlencode($ud . basename($images[$i]))."' ><br /></a><pre style='display:".$vis."' id='descr_".($i+300)."' ".$dbl.">".$descr."</pre></div></div>";
		   }		 
	  }
    $res .= "</div><br />";
			  
    
    
}
      unset($images);
    
    return $res;
}



function validate($u,$p)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
// $sql = "select iduser from users where username = '".$u."' and password = '".sha1($p)."' and active = '1'";
 $sql = "select iduser,email,last_access,max_number_of_files,max_file_size from users where username = '".$u."' and password = '".sha1($p)."' and active = '1'";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $db1->Close();
 
if (($results)&&($results[0]['iduser'] > '1')&&($results[0]['iduser'] !=''))
 {
	 $_SESSION['iduser'] = $results[0]['iduser'];
	 $_SESSION['email'] = $results[0]['email'];
	// $_SESSION['home'] = $_SESSION['path'] . $u_epu . DIRECTORY_SEPARATOR ;


	 $_SESSION['last_access'] = $results[0]['last_access'];
	 $_SESSION['max_file_size'] = $results[0]["max_file_size"];
	 $_SESSION['max_number_of_files'] = $results[0]["max_number_of_files"];
    
     $_SESSION['username'] = $u; 

  return $u;
 }
else
 return "-1"; 

}


function user_wall($user)
{
    $immagini = images_user($user); 
    //print_r($immagini);
    $res .= "<div class='row-fluid'>";
   // if ($users[$i])
	   {
		   $res .= "<div class='span12' style='line-height:70px;'>";
			 for ($j=0;$j<count($immagini);$j++)	
			   {
				if ($immagini[$j])   
				 $res .= "<a id='diw_".$j."' style='position:relative;cursor:pointer;margin:5px;' onclick=show_gallery('".urlencode( str_replace(basename($immagini[$j]),"", str_replace( $_SESSION['path'] ,"",$immagini[$j])))."','".urlencode(basename($immagini[$j]))."','diw_".$j."') style='cursor:pointer;'><img id='iw_".$j."' style='width:60px;height:60px;' onmouseover=expand('iw_".$j."') onmouseout=compress('iw_".$j."') src='../img_my.php?fn=".urlencode(str_replace( $_SESSION['path'] ,"",$immagini[$j]))."&c=1&s=120' /></a>";
			   }	
		   $res .= "</div>";
	   }		 
	 $res .= "</div>";
	  

return $res;
}


function check_comment($user,$data)
{
   $json = array("response"=>"ok","file"=>array(),"time"=>$data);
    $immagini = images_user($user);
    sort($immagini); 
    //print_r($immagini);
    $k = 0;
    for ($i=0;$i<count($immagini);$i++)
     {
      $ud = str_replace($_SESSION["path"],"",$immagini[$i]);
      $ud = str_replace(basename($immagini[$i]),"",$ud);
      
      $qnot = check_for_notification(urlencode($ud).urlencode(basename($immagini[$i])),$_SESSION['username'],$data);	  
      //echo $ud ." ->". $qnot."\n";
/*      if ($qnot != 0)
       $res .= "<div class='row-fluid' style='height:80px;'>
                       <div class='span12'>
                              <a style='cursor:pointer;' onclick=\"show_gallery('".urlencode($ud)."','".urlencode(basename($immagini[$i]))."','')\">
                                <img alt='".$i."' src='../img_my.php?fn=".urlencode($ud . basename($immagini[$i]))."&s=60&c=1' class='img-polaroid'><label>".$qnot." Nuovi commenti</label>
                              </a>
                        </div>
                </div>"; */
      if ($qnot != 0)
       {
		$json["file"][$k]["ud"] = urlencode($ud);
		$json["file"][$k]["bn"] = urlencode(basename($immagini[$i]));
		$json["file"][$k]["qn"] = $qnot;
		//$json["file"][$k]["data"] = $data;
		$k++;   
       }
      }
return json_encode($json);
}





function count_images($user)
{
	$dir = $_SESSION['path'] . $user . "/files/mysite/";
    //echo $dir;
    $items = glob($dir."{*.jpeg,*.jpg,*.gif,*.png,*.JPEG,*.JPG,*.GIF,*.PNG}", GLOB_BRACE);
    //echo "<br />";
    //print_r($items);
    //echo "<br />";
    
    $dirs = glob($dir."*",GLOB_ONLYDIR|GLOB_MARK );
    for ($i = 0; $i < count($dirs); $i++) {
        if (is_dir($dirs[$i])) {
            $add = glob($dirs[$i]."{*.jpeg,*.jpg,*.gif,*.png,*.JPEG,*.JPG,*.GIF,*.PNG}", GLOB_BRACE);
            $items = array_merge($items, $add);
        }
    }
    return count($items);
}


function images_user($user)
{
	$dir = $_SESSION['path'] . $user . "/files/mysite/";
    //echo "<br />".$dir."<br />"; 
    $items = glob($dir."{*.jpeg,*.jpg,*.gif,*.png,*.JPEG,*.JPG,*.GIF,*.PNG}", GLOB_BRACE);
    //echo "<br />";
    //print_r($items);
    //echo "<br />";
    
    $dirs = glob($dir."*",GLOB_ONLYDIR|GLOB_MARK );
    for ($i = 0; $i < count($dirs); $i++) {
        if (is_dir($dirs[$i])) {
            $add = glob($dirs[$i]."{*.jpeg,*.jpg,*.gif,*.png,*.JPEG,*.JPG,*.GIF,*.PNG}", GLOB_BRACE);
            $items = array_merge($items, $add);
        }
    }
    shuffle($items);
    return $items;
}

function get_user()
{
  $d = $_SESSION['app_path'] . "mysite/";	
  $dir = glob($d."*",GLOB_ONLYDIR|GLOB_MARK );
  $ret = array();
  $h=0;
  for ($k=0;$k<count($dir);$k++)
	  if (count_images(basename($dir[$k])) > 0)
	   {
			$ret[$h] = $dir[$k];
			$h++;
	   }
    shuffle($ret);
  return $ret;    
}






function carusel($d,$w)
{


	
	$ud = $d;
	$d = $_SESSION["path"] . $d;
	$id = rand(100,99999);
	$images = glob($d."{*.jpeg,*.jpg,*.gif,*.png,*.JPEG,*.JPG,*.GIF,*.PNG}", GLOB_BRACE);
	shuffle($images);
	
if (count($images) >1)
 {		
  $res = "<iframe src='../.mysite_template/".$_SESSION['mysite_theme']."/sly/gallery_mysite.php?d=".$ud."&t=0&w=".($w-30)."&h=290' style='width:".($w-30)."px;height:300px;' frameborder=0></iframe>";
	 
}
else
 {

 if (count($images) == 1)
  {
	$res = '<div class="view">
					<div class="item next left">
						<img alt="" style="align:center;" src="../img_my.php?fn='.$ud.basename($images[0]).'&w=1600&h=300&c=1">
						
					</div>
            </div>';
   }
  else
   {
	$res = '<div class="view">
					<div class="item next left">
						<img alt="" style="align:center;" src="../img_my.php?fn=../images/1400logo.png&w=1600&h=300&c=1">
						
					</div>
            </div>';
   }           
 	 
 }
return $res;
}

function get_images_sly($d,$t)
{
 if ($t == "")
  $t = 1;
 
 if ($t ==1)
  {
	  $h = 550;
  } 
 if ($t ==2)
  {
	  $h = 295;
  } 
 if ($t == 3)
  {
	  $h = 295;
  }
  
 $q = how_many_images($d);
 //echo "quante: " .$q;


 if ($q >= 1)
 $res = "<iframe src='../.mysite_template/".$_SESSION['mysite_theme']."/sly/gallery_mysite.php?d=".$d."&t=".$t."&w=1000&h=".$h."' style='width:100%;height:".$h."px;' frameborder=0></iframe>";
 return $res;
}


switch ($_REQUEST['f']) {
	case "gi":
	  echo get_images($d,$http);
	  break;
	case "gip":
	 // echo $_SESSION['mysite_hmi'];
      if ($_SESSION['mysite_hmi'] == 100)
    	  echo get_images_sly($d,1);
      if ($_SESSION['mysite_hmi'] == 101)
    	  echo get_images_sly($d,2);
      if ($_SESSION['mysite_hmi'] == 102)
    	  echo get_images_sly($d,3);

      if ($_SESSION['mysite_hmi'] < 100)
	      echo get_images_page($d,$http,$p);
	  break;
	case "gap":
	  echo get_audios_page($d,$http,$p);
	  break;
	case "gvp":
	  echo get_videos_page($d,$http,$p);
	  break;
	case "gfp":
	  echo get_files_page($d,$http,$p);
	  break;
	case "menu":
	  echo create_menu( $_SESSION["path"] . $d);
	  break;
	case "caru":
	  echo carusel($d,$w);
	  break;
	case "wall":
	  echo user_wall($user); 
	  break; 
	case "comm":
	  echo comments($resource); 
	  break; 
	case "check":
	  echo check_comment($user,$data); 
	  break; 
	case "delete":
	  echo delete_file($resource); 
	  break; 
	case "content":
	  echo content($resource); 
	  break; 
	case "newdescription":
	  echo newdescription($resource,$comment); 
	  break; 
	case "newcomment":
	  echo newcomment($resource,$comment); 
	  break; 
	case "settings":
	  echo get_settings($user); 
	  break; 
	case "example":
	  echo example($_REQUEST['qi'],$_REQUEST['qv'],$_REQUEST['qa'],$_REQUEST['qf'],$_REQUEST['dim'],$_REQUEST['h']); 
	  break; 
	  
    case "signin":
      $vali = validate($uu,$pp);
      //echo $vali;
      if ( $vali != '-1')
       $_SESSION['username'] = $vali;
      else
       echo "username o password errati."; 
      break;	    
}



?>
