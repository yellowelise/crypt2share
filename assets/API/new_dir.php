<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");
//include("../func/functions.php");

$d = urldecode($_REQUEST['d']);
$json = array(
"code"=>"",
"directory"=>""
);


function format_size($size) {

    $mod = 1024;

    $units = explode(' ','B KB MB GB TB PB');

    for ($i = 0; $size > $mod; $i++) {

        $size /= $mod;
    }

    return round($size, 2) . ' ' . $units[$i];
}


if (isset($_SESSION['home']))
{
	$folder = $_SESSION['home'] . $d;
	if (!file_exists($folder))
	 {

        if (mkdir($folder,0777,true))
         { 
			 $size = 0;
			 $json["directory"]["name"] = $d;	 
			 $json["directory"]["size"] = $size;	 
			 $json["directory"]["human_size"] = format_size($size);			 
             $json["code"] = "200";
		 }
		else
		 {
			 $size = 0;
			 $json["directory"]["name"] = $d;	 
			 $json["directory"]["size"] = $size;	 
			 $json["directory"]["human_size"] = format_size($size);			 
             $json["code"] = "200";
		 } 	
	 }
	else
	 {
			 $size = 0;
			 $json["directory"]["name"] = $d;	 
			 $json["directory"]["size"] = $size;	 
			 $json["directory"]["human_size"] = format_size($size);			 
			$json["code"] = "410";
	 } 
}
else
{
			 $json["directory"]["name"] = "";	 
			$json["code"] = "100";
}


echo json_encode($json);
?>
