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
"directory"=>array()
);


if (isset($_SESSION['home']))
{
	$folder = $_SESSION['home'] . $d;
	if (file_exists($folder))
	 {

        if (rmdir($folder))
         { 
			$json["code"] = "200";
            $json["directory"]["name"] = $d; 
            $json["directory"]["size"] = 0; 
            $json["directory"]["human_size"] = "0 B"; 
		 }
		else
		 {
			$json["code"] = "411";
            $json["directory"]["name"] = $d; 
            $json["directory"]["size"] = 0; 
            $json["directory"]["human_size"] = "0 B"; 
		 } 	
	 }
	else
	 {
			$json["code"] = "412";
            $json["directory"]["name"] = $d; 
            $json["directory"]["size"] = 0; 
            $json["directory"]["human_size"] = "0 B"; 
	 } 
}
else
{
			$json["code"] = "100";
            $json["directory"]["name"] = ""; 
            $json["directory"]["size"] = 0; 
            $json["directory"]["human_size"] = "0 B"; 
}


echo json_encode($json);
?>
