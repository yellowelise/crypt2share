<?php
session_start();
//ini_set('display_errors', 'Off');
//ini_set('display_startup_errors', 'Off');
//error_reporting(0);
function orient_image($file_path) {
	if (!function_exists('exif_read_data')) {
		return false;
	}
	$exif = @exif_read_data($file_path);
	if ($exif === false) {
		return false;
	}
	$orientation = intval(@$exif['Orientation']);
	if (!in_array($orientation, array(3, 6, 8))) {
		return false;
	}
	$image = @imagecreatefromjpeg($file_path);
	switch ($orientation) {
		case 3:
			$image = @imagerotate($image, 180, 0);
			break;
		case 6:
			$image = @imagerotate($image, 270, 0);
			break;
		case 8:
			$image = @imagerotate($image, 90, 0);
			break;
		default:
			return false;
	}
	$success = imagejpeg($image, $file_path);
	@imagedestroy($image);
	return $success;
}


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

        case 'pdf':
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
	    
//echo "e che cazzo<br />";
 $thumbnailsize = 80;
if (isset($_REQUEST['s']))
 if ($_REQUEST['s'] == '-1')
  $thumbnailsize = 0;
 else 
  $thumbnailsize = $_REQUEST['s'];

if (isset($_REQUEST['c']))
 $c = 1;
else
 $c = 0; 

if (isset($_REQUEST['w']))
 $w = $_REQUEST['w'];
else
 $w = 0; 
 
 
if (isset($_REQUEST['h']))
 $h = $_REQUEST['h'];
else
 $h = 0; 



if (($w!=0)&&($h!=0))
 {
	 $thumbnailsize = $w;
 }
 
$filename = $_SESSION["path"] . urldecode($_REQUEST['fn']);

if (!file_exists($_SESSION['app_path']."cache/"))
  mkdir($_SESSION['app_path']."cache/");

  $cachedfile = $_SESSION['app_path']."cache/" .sha1($filename) . "_" . $thumbnailsize ."px_".$c ."_". $w."x".$h."_". sha1($_SESSION['username']);
 // echo $cachedfile . "<br />";



  if (file_exists($cachedfile))
   {
	   header('Content-Type: ' . extension_to_image_type($ext));
	   readfile($cachedfile);
	  // echo "esisto in cache" . $cachedfile; 
   }
else
 
 {   
//echo "nomefile:".$filename;
$ext = substr(strrchr($filename, '.'), 1);
//echo "--------" . $ext;


if (strtolower($ext) == 'gif')
 {
  $im = imagecreatefromgif($filename);
 }

if ((strtolower($ext) == 'png'))
 {
  $im = imagecreatefrompng($filename);
  imagealphablending($im, false);
  imagesavealpha($im, true);

 }

//if ((strtolower($ext) == 'pdf'))
// {
//  exec('sudo -u root -S  convert "'.$filename.'[0]" -colorspace RGB -geometry 800 "'.$_SESSION['temp_path'].'pdf_'.$_SESSION['username'].'.png" < ~/sec.sec');	 
//  $im = imagecreatefrompng('"'.$_SESSION['temp_path'].'pdf_'.$_SESSION['username'].'.png"');
// }
 
 
if (((strtolower($ext) == 'jpg')||(strtolower($ext) == 'jpeg')))
 {
  orient_image($filename);
  $im = imagecreatefromjpeg($filename);
 }

if (!$im)
{
  // echo $_SESSION['app_path'] ."images/". strtolower($ext) . ".png";
	
 if (file_exists($_SESSION['app_path'] ."images/". strtolower($ext) . ".png"))	
  {
   $im = imagecreatefrompng($_SESSION['app_path'] ."images/". strtolower($ext) . ".png");
  }
 else
  {
   $im = imagecreatefrompng($_SESSION['app_path'] ."images/txt.png");
  }
     imagealphablending($im, false);
  imagesavealpha($im, true);
  imagepng($im);
   exit;

}
 
if (!isset($_REQUEST['du']))
 {
  header('Content-Type: ' . extension_to_image_type($ext));
  
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
 }


if ($_REQUEST['nf']) // new file
 $savefile = $_SESSION["path"] . urldecode($_REQUEST['nf']); //no save
else 
 $savefile = $cachedfile; //no save


if (isset($_REQUEST['dg']))
 {
  $im = imagerotate($im, $_REQUEST['dg'], 0);
  $savefile = $filename;//$filename;

 }


$width = imagesx($im);
$height = imagesy($im);


if (($w!=0)&&($h!=0))
{
//	echo "ci sono";
if ($width > $height)
 {
	 if (($width < $w) && ($height < $h))
	  {
		 // echo "sono qui:0<br>"; 
		  $new_width = $width;
		  $new_height = $height;
	  }
	 else
	  {
		 // echo "sono qui:1<br>"; 
		  $ratio = min($w/$width,$h/$height);
	      $new_width = round($width * $ratio);
	      $new_height = round($height * $ratio);
	    //  echo $new_width . "x" . $new_height . "<br />";
	  } 
 }
else
 {
	 if (($width < $w) && ($height < $h))
	  {
		  //echo "sono qui:2<br>"; 
		  $new_width = $width;
		  $new_height = $height;
	  }
	 else
	  {
		  //echo "sono qui:3<br>"; 
		  $ratio = min($w/$width,$h/$height);
	      $new_width = round($width * $ratio);
	      $new_height = round($height * $ratio);
	    //  echo $new_width . "x" . $new_height . "<br />";
	      
	  } 
 } 

}
else
{

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

	if ($c==0)
	{
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
	}
	else
	{
		if($width > $height)
			{
			$new_width =  (int)($thumbnailsize * $width / $height);
			$new_height =$thumbnailsize;
			}
		else
			{
			$new_width =  $thumbnailsize;
			$new_height =(int)($thumbnailsize * $height / $width);
			}
	}
 }
 else
 {
	 $new_width = $width;
	 $new_height = $height;
	 $image_p = $im;
 }
}
$left_c = 0;
$top_c = 0;
  
if ($c == 1)
{




  if (($w != 0)&&($h!=0))
   {
     $top_c = round(($height - $h)/2);
     $left_c = round(($width - $w)/2);
     
     //echo $top_c . "x".$left_c . "-------------<br>";
 
     $image_pc = imagecreatetruecolor($w, $h);
     //imagealphablending($image_pc, true);
     //imagesavealpha($image_pc, true);  
    // $image_p = imagecreatetruecolor($new_width, $new_height);

	// imagecopyresampled($image_p, $im, 0, 0, 0, 0, $new_width, $new_height, $width , $height);

	 imagecopy($image_pc, $im, 0, 0, $left_c,$top_c,  $w , $h);
	 $image_p = $image_pc;
   }
  else
   {
	 $delta = $new_width - $new_height;
	 if ($delta < 0) //portrait
	  {
		  $top_c = abs(round($delta/2));
	  }
	 else //landscape
	  {
		  $left_c = abs(round($delta/2));
	  } 	
 
 
     $image_pc = imagecreatetruecolor($thumbnailsize, $thumbnailsize);
     $image_p = imagecreatetruecolor($new_width, $new_height);

	 imagecopyresampled($image_p, $im, 0, 0, 0, 0, $new_width, $new_height, $width , $height);

	 imagecopy($image_pc, $image_p, 0, 0, $left_c, $top_c, $new_width , $new_height);
	 $image_p = $image_pc;
   }

}
else
 {
  $image_p = imagecreatetruecolor($new_width, $new_height);
  imagecopyresampled($image_p, $im, 0, 0, $left_c, $top_c, $new_width, $new_height, $width , $height);
}

	// echo "<br />--------------------------------->" . $ext; 

// Output
if (!isset($_REQUEST['du']))
 {
	 
	 
if ((strtolower($ext) == 'jpg') || (strtolower($ext) == 'jpeg'))
 {
  imagejpeg($image_p,$savefile,85);
  imagejpeg($image_p,null,85);
 }
if ((strtolower($ext) == 'gif'))
 {
  imagegif($image_p,$savefile);
  imagegif($image_p,null);
 }
if ((strtolower($ext) == 'png'))
 {	 
  imagepng($image_p,$savefile);
  imagepng($image_p,null);
 }
if ((strtolower($ext) == 'pdf'))
 {
  imagepng($image_p,$savefile);
 }

}
else
 {
  echo json_encode($json = array("W"=>$width,"H"=>$height));
 }
 
 
@imagedestroy($im);
@imagedestroy($image_p);
@imagedestroy($image_pc);
}
?>
