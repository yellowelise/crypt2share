<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
include("../config.php");
function url_encode($string){
        return urlencode(utf8_encode($string));
    }
 
$file = $_SESSION['home'] . $_REQUEST['f'];

$ext = strtolower(substr(strrchr($file, '.'), 1));

 // $now = time()+ (52 * 24 * 60 * 60);;//date("Ymd-His");	 
  $link_name = $_SESSION['username']."_".sha1($file) . "_".rand(10000000,999999999).".".$ext;
  $return = $_SESSION['server_path'] . "view.php?fn=" . url_encode($link_name);
  if (!file_exists($_SESSION['app_path'].'fb_share/'))
   mkdir($_SESSION['app_path'].'fb_share/');
   
//  if (count(glob($_SESSION['app_path'].'fb_share/'.sha1($file)."*.*")) == 0)
//   shell_exec('ln -s "'.$file.'" "'.$_SESSION['app_path'].'fb_share/'.$link_name.'"');
  copy($file,$_SESSION['app_path'].'fb_share/'.$link_name);
  
  if (file_exists($_SESSION['app_path'].'fb_share/'.$link_name))
   echo url_encode($return);
  else
   echo "";
?>
