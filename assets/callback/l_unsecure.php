<?php

session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
$host = $_SERVER['SERVER_NAME'];
$host = str_replace('http://', '', $host);




function resolution($filename)
{
$ext = substr(strrchr($filename, '.'), 1);
if (strtolower($ext) == 'gif')
 {
  $im = imagecreatefromgif($filename);
 }
if (strtolower($ext) == 'png')
 {
  $im = imagecreatefrompng($filename);
 }
if ((strtolower($ext) == 'jpg')||(strtolower($ext) == 'jpeg'))
 {
  $im = imagecreatefromjpeg($filename);
 }
 $width = imagesx($im);
 $height = imagesy($im);
 return $width."x".$height." px";
}


 function findexts($filename) 
 { 
 $filename = strtolower($filename) ; 
 //echo $filename."<br />";
 $exts = substr(strrchr($filename, '.'), 1);
/* $exts = preg_split("[/\\.]", $filename) ; 
 $n = count($exts)-1; 
 $exts = $exts[$n];*/ 
 //echo "estensione: " . $filename . " - " . $exts ."<br>";
 return $exts; 
 } 

 

function files($directory,$ricorsiva) {
$size = 0;
$file_immagini = array();
$i = 0;    
$last_path = $directory;
if (file_exists($directory))
{
//echo $directory . "<br>";
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
       try {
         $ext = findexts($file);
        // echo $file."<br />";
       if ((($ext == 'png') || ($ext == 'jpg')  || ($ext == 'jpeg') || ($ext == 'gif') || ($ext == 'zip')) && (strpos($file,'.temp') === false))
	     {
           $file_immagini[$i]["path"] = str_replace("\\","/",$file);

           $file_immagini[$i]["ext"] = $ext;
           $file_immagini[$i]["last_mod"] = date("d.m.y H:i",filemtime($file));
         //  $file_immagini[$i]["dim"] = format_bytes($file->getSize());
           $file_immagini[$i]["filename"] = basename($file);
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

if (count($file_immagini) == 0)
{
 return false;
}
else { 
   return $file_immagini; 
} 
}
} 



$path = $_SESSION['home'];
//echo $path;
$imm = files($path,false); 

if ($imm)
for ($i=0;$i<count($imm);$i++)
 {
  if (($imm[$i]['ext'] == "jpg") || ($imm[$i]['ext'] == "jpeg") || ($imm[$i]['ext'] == "gif") || ($imm[$i]['ext'] == "png"))
   {	 
?>
					<div class="row-fluid"><div class="span2"><img src="img.php?fn=file:///<? echo $imm[$i]['path']."&s=80"; ?>"  /></div><div class="span4"><label><? echo $imm[$i]['filename']; ?></label></div><div class="span2"><a href="download.php?f=<? echo utf8_encode($imm[$i]['filename'])?>">Download UnCrypted</a></div><div class="span2"><button onclick="moveto_secure('<? echo utf8_encode($imm[$i]['filename']); ?>')">Move to Secure</button></div><div class="span2"><button onclick=delete_unsecure('<? echo utf8_encode($imm[$i]['filename']); ?>')>Delete</button></div></div>
<?php
   }
  else
   {  ?>
					<div class="row-fluid"><div class="span2"><img src="images/zip_thumb.png"/></div><div class="span4"><label><? echo $imm[$i]['filename']; ?></label></div><div class="span2"><a href="download.php?f=<? echo utf8_encode($imm[$i]['filename'])?>">Download UnCrypted</a></div><div class="span2"><button onclick="moveto_secure('<? echo utf8_encode($imm[$i]['filename']); ?>')">Move to Secure</button></div><div class="span2"><button onclick=delete_unsecure('<? echo utf8_encode($imm[$i]['filename']); ?>')>Delete</button></div></div>
	   
 <?  }
  }
?>				
