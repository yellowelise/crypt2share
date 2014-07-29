<?php
session_start();
//ini_set('display_errors', 'Off');
//ini_set('display_startup_errors', 'Off');
//error_reporting(0);

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
$prev = "";
$ultimo = "";
while (false !== ($entry = readdir($h))) 
{
    if($entry != '.' && $entry != '..')
      { 
	   $ext = strtolower(substr(strrchr($entry, '.'), 1));	  
	   //echo $ext;
	   if (($ext == 'jpg')||($ext == 'jpeg')||($ext == 'gif')||($ext == 'png'))
	   {
		  $ultimo = $entry;  
       }  
    }
}
//echo $ultimo;
$h = opendir($_SESSION['home'] . $d); //Open the current directory
while (false !== ($entry = readdir($h))) 
{
    if($entry != '.' && $entry != '..')
      { 
	   $ext = strtolower(substr(strrchr($entry, '.'), 1));	  
	   //echo $ext;
	   if (($ext == 'jpg')||($ext == 'jpeg')||($ext == 'gif')||($ext == 'png'))
	   {
		  // $I++;
		  // echo "\n".$I;
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
		   if ($primo == $entry)
		   $echo = $ultimo;
		   else	 
           $echo = $prev; //Do whatever you need to do with the file
           break; //Exit the loop so no more files are read
         }
    	 $prev = $entry;
    	 //echo "\nprev:" . $prev;
	    }
       }  
    }
}

//echo "\nultimo:" . $ultimo . " echo:" . $echo;
if (($echo ==""))
 echo $ultimo;
else
 echo $echo;

?>
