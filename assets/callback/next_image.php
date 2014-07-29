<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");


if (isset($_REQUEST['d']))
 $d = $_REQUEST['d'];
else
 $d = "files/";

if (isset($_REQUEST['f']))
 $f = $_REQUEST['f'];
else
 $f = "";


function url_encode($string){
        return urlencode(utf8_encode($string));
    }
 

$h = opendir($_SESSION['home'] . $d); //Open the current directory
$esci = 0;
$primo = "";
$echo = "";
while (false !== ($entry = readdir($h))) 
{
    if($entry != '.' && $entry != '..')
      { 
	   $ext = strtolower(substr(strrchr($entry, '.'), 1));	  
	   //echo $ext;
	   if (($ext == 'jpg')||($ext == 'jpeg')||($ext == 'gif')||($ext == 'png'))
	   {
		 if ($primo == "")
		  $primo = $entry;  
		// echo $entry . " - " - $f . "\n";  
	   if ($entry == $f)
	    {
		 //echo "\nesco: " . $f . "\n";	
	     $esci = 1;
	    }
	   else
	    {
	    if ($esci==1)
	     { 	  
		   	 
           $echo = $entry; //Do whatever you need to do with the file
           break; //Exit the loop so no more files are read
         }
	    }
       }  
    }
}
if (($echo ==""))
 echo $primo;
else
 echo $echo;

?>
