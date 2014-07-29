<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("class/mysql.class.php");

include("config.php");
include("img_res.php");
if (isset($_REQUEST['u']))
$user = $_REQUEST['u'];


 

function thumb_user($user)
{
    $i = 0;
    $directory = $_SESSION['path'] . $user . "/files/";

     foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
       try {
         $ext = strtolower(substr(strrchr($file, '.'), 1));
       if (($ext == 'png') || ($ext == 'jpg') || ($ext == 'gif') || ($ext == 'jpeg'))
	     {
           $items[$i] = $file;
		 //  $file_immagini[$i]["ext"] = $ext;
         //  $file_immagini[$i]["last_mod"] = date("d.m.y H:i",filemtime($file));
         //  $file_immagini[$i]["dim"] = format_bytes($file->getSize());
         //  $file_immagini[$i]["filename"] = basename($file);
         //  $file_immagini[$i]["realpath"] = $file;
         //  $file_immagini[$i]["onlypath"] = str_replace("/".$file_immagini[$i]["filename"],"",$file_immagini[$i]["realpath"]);
         //  $last_path = $file_immagini[$i]["onlypath"];
		 //  $file_immagini[$i]["resolution"] = resolution($file);
         //    $file_immagini[$i]["title"] = $dati_db['title']; 
         //    $file_immagini[$i]["description"] = $dati_db['description']; 

          $i += 1;  
         }
       
       }
catch (Exception $e) {}
    }
    
    for ($i = 0; $i < count($items); $i++) {
	   resize($items[$i], 0,0,1,100,0,75);
	   echo "eseguo (100px): " . $items[$i] . "<br />";
	   
	   if (strpos($items[$i],"/mysite/") !==false)
	    {
		 echo "eseguo (120px): " . $items[$i] . "<br />";
	 
	     resize($items[$i], 0,0,1,120,0,75);
	    } 
	}
unset($items);

}
thumb_user($user);
?>
