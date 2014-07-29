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
    
    

function wm($cachedfile)
{
$image = new Imagick($cachedfile);
$watermark = new Imagick();
$mask = new Imagick();
$draw = new ImagickDraw();

// Define dimensions
$width = $image->getImageWidth();
$height = $image->getImageHeight();

// Create some palettes
$watermark->newImage($width, $height, new ImagickPixel('grey30'));
$mask->newImage($width, $height, new ImagickPixel('black'));

// Watermark text
$text = 'c2sha.re';

// Set font properties
$draw->setFont('Arial');
$draw->setFontSize(20);
$draw->setFillColor('grey70');

// Position text at the bottom right of the image
$draw->setGravity(Imagick::GRAVITY_SOUTHEAST);

// Draw text on the watermark palette
$watermark->annotateImage($draw, 10, 12, 0, $text);

// Draw text on the mask palette
$draw->setFillColor('white');
$mask->annotateImage($draw, 11, 13, 0, $text);
$mask->annotateImage($draw, 10, 12, 0, $text);
$draw->setFillColor('black');
$mask->annotateImage($draw, 9, 11, 0, $text);

// This is needed for the mask to work
$mask->setImageMatte(false);

// Apply mask to watermark
$watermark->compositeImage($mask, Imagick::COMPOSITE_COPYOPACITY, 0, 0);

// Overlay watermark on image
$image->compositeImage($watermark, Imagick::COMPOSITE_DISSOLVE, 0, 0);

// Set output image format
$ext = strtolower(substr(strrchr($cachedfile, '.'), 1));
if ($ext == 'png')
 $image->setImageFormat('png');
if ($ext == 'jpg')
 $image->setImageFormat('jpeg');
if ($ext == 'gif')
 $image->setImageFormat('gif');

// Output the new image
$image->writeImage($cachedfile);
}


function resize($fn, $w,$h,$c,$s,$output=1)
{
  $filename = $fn;
  //echo $filename."<br />";
  $ext = substr(strrchr($filename, '.'), 1);
  if (!file_exists($_SESSION['app_path']."new_cache/"))
   mkdir($_SESSION['app_path']."new_cache/");
  $cachedfile = $_SESSION['app_path']."new_cache/s".$s."px_c".$c ."_". $w."x".$h."px_". sha1($_SESSION['username'].$fn) . "." . $ext;

  create_cached($filename,$cachedfile,$w,$h,$c,$s,$output);
	

//return ($cachedfile);
}


function create_cached($filename,$cachedfile,$w,$h,$c,$s,$output=1)
{
  
  
	$ext = substr(strrchr($filename, '.'), 1);
	
	//echo "esiste ? ". $cachedfile . "<br>"; 
	
if (file_exists($cachedfile))
 {
	//echo "esiste". $cachedfile . "<br>"; 
	if (strtolower($ext) == 'gif')
	  $imc = imagecreatefromgif($cachedfile);

	if ((strtolower($ext) == 'png'))
	 {
	  $imc = imagecreatefrompng($cachedfile);
	 }
	 
	if (((strtolower($ext) == 'jpg')||(strtolower($ext) == 'jpeg')))
	 {
	  $imc = imagecreatefromjpeg($cachedfile);
	 }
   
 }
else
 { 	
	if (strtolower($ext) == 'gif')
	  $im = imagecreatefromgif($filename);

	if ((strtolower($ext) == 'png'))
	 {
	  $im = imagecreatefrompng($filename);
	 }
	 
	if (((strtolower($ext) == 'jpg')||(strtolower($ext) == 'jpeg')))
	 {
	  orient_image($filename);
	  $im = imagecreatefromjpeg($filename);
	 }
  	 
	 
	// in $im c'è l'immagine originale
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


if (($w != 0) && ($h != 0))
 {
   if ($c == 0)
	 $imc = redim_wh($im,$w,$h);
   else
     $imc = redim_whc($im,$w,$h);	 
 }
else
 {
   if ($s > 0)
    {
	  if ($c == 0)	
		$imc = redim_s($im,$s);
	  else
	    $imc = redim_sc($im,$s);	
	}
   else
    {
		$imc = $im;
	}		 
 }

if (($s == 0) && ($w==0) && ($h == 0))
 {
  $font = $_SESSION['app_path'] . '/font/Verdana.ttf';
  $size = 10;

  # calculate maximum height of a character 
  $bbox = imagettfbbox($size, 0, $font, 'ky');
  $x = imagesx($imc)-70; $y = (imagesy($imc) - 18 - $bbox[5]);

  $text = 'c2sha.re';
  shadow_text($imc, $size, $x, $y, $font, $text);
 }




if ((strtolower($ext) == 'jpg') || (strtolower($ext) == 'jpeg'))
 {
  imagejpeg($imc,$cachedfile,85);
 
 }
if ((strtolower($ext) == 'gif'))
 {
  imagegif($imc,$cachedfile);
 }
if ((strtolower($ext) == 'png'))
 {	 
  //echo $imc;	 
	  imagealphablending($imc, false);
	  imagesavealpha($imc, true);
  imagepng($imc,$cachedfile);
 }

}


if ($output == 1)
{
//echo $imc;
if ((strtolower($ext) == 'jpg') || (strtolower($ext) == 'jpeg'))
 {
  imagejpeg($imc,null,85);
 
 }
if ((strtolower($ext) == 'gif'))
 {
  imagegif($imc);
 }
if ((strtolower($ext) == 'png'))
 {	 
  //echo $imc;	 
	  imagealphablending($imc, false);
	  imagesavealpha($imc, true);
  imagepng($imc);

   
 }
} 
// wm($cachedfile);
 @imagedestroy($imc);
 @imagedestroy($im);
}



function shadow_text($ima, $size, $x, $y, $font, $text)
  {
    $black = imagecolorallocate($ima, 0, 0, 0);
    $white = imagecolorallocate($ima, 255, 255, 255);
    imagettftext($ima, $size, 0, $x + 1, $y + 1, $black, $font, $text);
    imagettftext($ima, $size, 0, $x + 0, $y + 1, $black, $font, $text);
    imagettftext($ima, $size, 0, $x + 0, $y + 0, $white, $font, $text);
  }







function redim_wh($im,$w,$h)
{
$width = imagesx($im);
$height = imagesy($im);

if ($width > $height)
 {
	 if (($width < $w) && ($height < $h))
	  {
		  $new_width = $width;
		  $new_height = $height;
	  }
	 else
	  {
		  $ratio = min($w/$width,$h/$height);
	      $new_width = round($width * $ratio);
	      $new_height = round($height * $ratio);
	  } 
 }
else
 {
	 if (($width < $w) && ($height < $h))
	  {
		  $new_width = $width;
		  $new_height = $height;
	  }
	 else
	  {
		  $ratio = min($w/$width,$h/$height);
	      $new_width = round($width * $ratio);
	      $new_height = round($height * $ratio);
	  } 

 } 
 
  $image_p = imagecreatetruecolor($new_width, $new_height);
  imagecopyresampled($image_p, $im, 0, 0, 0, 0, $new_width, $new_height, $width , $height);
 
return $image_p;
@imagedestroy($image_p);
@imagedestroy($im);

}

function redim_whc($im,$w,$h)
{

$width = imagesx($im);
$height = imagesy($im);

/*	if($width > $height)
	{
		$new_width =  $w;
		$new_height = (int)($w * $width / $height);
	}
	else
	{
		$new_width =  (int)($h * $height / $width);
		$new_height = $h;
	}
*/

if ($width > $height)
 {
	 if (($width < $w) && ($height < $h))
	  {
		  //echo "sono qui:0<br>"; 
		  $new_width = $width;
		  $new_height = $height;
	  }
	 else
	  {
		  //echo "sono qui:1<br>"; 
		  $ratio = max($w/$width,$h/$height);
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
		  $ratio = max($w/$width,$h/$height);
	      $new_width = round($width * $ratio);
	      $new_height = round($height * $ratio);
	    //  echo $new_width . "x" . $new_height . "<br />";
	      
	  } 
 } 

$im = redim_wh($im,$new_width,$new_height);
$width = imagesx($im);
$height = imagesy($im);


 $top_c = round(($height - $h)/2);
 $left_c = round(($width - $w)/2);
 $image_pc = imagecreatetruecolor($w, $h);
 imagecopy($image_pc, $im, 0, 0, $left_c,$top_c,  $w , $h);
// $image_p = $image_pc;
 
return $image_pc;
@imagedestroy($image_pc);
@imagedestroy($im);

}



function redim_s($im,$s)
{
$width = imagesx($im);
$height = imagesy($im);

if($width > $height)
	{
		$new_width = $s;
		$new_height = (int)($s * $height / $width);
	}
else
	{
		$new_width = (int)($s * $width / $height);
		$new_height = $s;
	}

 
  $image_p = imagecreatetruecolor($new_width, $new_height);
  imagecopyresampled($image_p, $im, 0, 0, 0, 0, $new_width, $new_height, $width , $height);
 
return $image_p;
@imagedestroy($image_p);
@imagedestroy($im);
	
}

function redim_sc($im,$s)
{

$width = imagesx($im);
$height = imagesy($im);

	if($width > $height)
	{
		$new_width =  (int)($s * $width / $height);
		$new_height =$s;
	}
	else
	{
		$new_width =  $s;
		$new_height =(int)($s * $height / $width);
	}

$im = redim_wh($im,$new_width,$new_height);
$width = imagesx($im);
$height = imagesy($im);


 

 
 $top_c = round(($height - $s)/2);
 $left_c = round(($width - $s)/2);
 $image_pc = imagecreatetruecolor($s, $s);
 imagecopy($image_pc, $im, 0, 0, $left_c,$top_c,  $s , $s);
 //$image_p = $image_pc;
 
return $image_pc;
@imagedestroy($image_pc);
@imagedestroy($im);
	
}


?>
