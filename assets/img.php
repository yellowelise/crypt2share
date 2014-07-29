<?php
session_start();

function extension_to_image_type($ext)
{
    switch($ext)
    {        
        case 'jpg':
        case 'jpeg':
            return 'image/jpeg';
            break;

        case 'png':
            return 'image/png';
            break;

        case 'gif':
        default:
            return 'image/gif';
            break;
    }
}
function setTransparency($new_image,$image_source)
    {
       
            $transparencyIndex = imagecolortransparent($image_source);
            $transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255);
            
            if ($transparencyIndex >= 0) {
                $transparencyColor    = imagecolorsforindex($image_source, $transparencyIndex);   
            }
           
            $transparencyIndex    = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
            imagefill($new_image, 0, 0, $transparencyIndex);
             imagecolortransparent($new_image, $transparencyIndex);
       
    } 
	
/*
if ($_REQUEST["t"] == 1)
 $sql = "SELECT icon as foto FROM qube1.market_modules WHERE id_modules = '".$_REQUEST["mid"]."';";
if ($_REQUEST["t"] == 2)
 $sql = "SELECT screen1 as foto FROM qube1.market_modules WHERE id_modules = '".$_REQUEST["mid"]."';";
if ($_REQUEST["t"] == 3)
 $sql = "SELECT screen2 as foto FROM qube1.market_modules WHERE id_modules = '".$_REQUEST["mid"]."';";
if ($_REQUEST["t"] == 4)
 $sql = "SELECT foto,foto_ext  FROM qube1.utenti WHERE id = '".$_REQUEST["mid"]."';";
		
if($result = mysql_query($sql)){ $row = mysql_fetch_assoc($result); }
*/
$filename = urldecode($_REQUEST['fn']);
//echo "nomefile:".$filename;
$ext = substr(strrchr($filename, '.'), 1);
//echo $ext;


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
if (!isset($_REQUEST['du']))
 {
  
  
  
  
  
  
  
  
  
  
  header('Content-Type: ' . extension_to_image_type($ext));

  
  
  
  
  
  
  
  
  
  
  
  //header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
 }
//file_put_contents('/var/www/temp/t.tmp',$im);
//stream_context_get_options()
//$meta = stream_context_get_options($im);
//echo $meta;
//$temp_file = tempnam(sys_get_temp_dir(), 'Tux');
//file_put_contents($temp_file,'aaaa');

//if (isset($_GET['s']))
//$thumbnailsize = $_GET['s'];
//if ($thumbnailsize =='')
$savefile = null; //no save

if (isset($_POST['dg']))
 {
  $image_p = imagerotate($im, $_POST['dg'], 0);
 // if (strpos($filename,$_SESSION['homedir'])) //is a user file
   { 
	$savefile = $_SESSION['homedir'] . basename($filename);//$filename;
	$_SESSION['savefile'] = $savefile;
   }
 }
else
 { 


 $thumbnailsize = 100;
if (isset($_REQUEST['s']))
 if ($_REQUEST['s'] == '-1')
  $thumbnailsize = 0;
 else 
  $thumbnailsize = $_REQUEST['s'];
 
$width = imagesx($im);
$height = imagesy($im);

if ($thumbnailsize != 0)
 {
if (($thumbnailsize > $width) || ($thumbnailsize > $height))
 {
  if ($width > $height)
   {
    $thumbnailsize = $height;
   }
  else
   {
    $thumbnailsize = $width;
   }   
 }
// $size = getimagesize($temp_file);
// $width = $size[0];
// $height = $size[1];

//header('Content-type: image/png');


if($width > $height)
{
$new_width = $thumbnailsize;
$new_height = (int)($thumbnailsize * $height / $width);
}
else
{
$new_width = (int)($thumbnailsize * $width / $height);
$new_height = $thumbnailsize;
}


$image_p = imagecreatetruecolor($new_width, $new_height);
//setTransparency($image_p,$im);
imagecopyresampled($image_p, $im, 0, 0, 0, 0, $new_width, $new_height, $width , $height);

}
else
{

 $new_width = $width;
 $new_height = $height;
 $image_p = $im;
}
}
// $im = imagecreatetruecolor(100,20);

// Output
if (!isset($_REQUEST['du']))
 {
if ((strtolower($ext) == 'jpg') || (strtolower($ext) == 'jpeg'))
 {
  imagejpeg($image_p,$savefile,100);
 }
if ((strtolower($ext) == 'gif'))
 {
  imagegif($image_p,$savefile);
 }
if ((strtolower($ext) == 'png'))
 {
  imagepng($image_p,$savefile);
 }
}
else
 {
  echo $new_width . "x" .$new_height;
 }

//imagejpeg($image_p, null, 100);
?>
