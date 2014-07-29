<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");

$file_info = array(
"filename"=>"",
"path"=>"",
"size"=>"",
"last_modified"=>""
);


if (isset($_REQUEST['f']))
{
 $f = urldecode($_REQUEST['f']);
}
else
 {
   $f = "";
 }

if (isset($_REQUEST['d']))
{
 $d = $_SESSION['home'] . $_REQUEST['d'];
 //$_SESSION['curr_dir'] = $_REQUEST['d'];
}
else
 {
  $d = $_SESSION['home'] . "files/";
  //$_SESSION['curr_dir'] = "files/";
 }



 
function cameraUsed($imagePath) {

    // Check if the variable is set and if the file itself exists before continuing
    if ((isset($imagePath)) and (file_exists($imagePath))) {
   
      // There are 2 arrays which contains the information we are after, so it's easier to state them both
      $exif_ifd0 = read_exif_data($imagePath ,'IFD0' ,0);      
      $exif_exif = read_exif_data($imagePath ,'EXIF' ,0);
     
      //error control
      $notFound = "ND";
     
      // Make
      if (@array_key_exists('Make', $exif_ifd0)) {
        $camMake = $exif_ifd0['Make'];
      } else { $camMake = $notFound; }
     
      // Model
      if (@array_key_exists('Model', $exif_ifd0)) {
        $camModel = $exif_ifd0['Model'];
      } else { $camModel = $notFound; }
     
      // Exposure
      if (@array_key_exists('ExposureTime', $exif_ifd0)) {
        $camExposure = $exif_ifd0['ExposureTime'];
      } else { $camExposure = $notFound; }

      // Aperture
      if (@array_key_exists('ApertureFNumber', $exif_ifd0['COMPUTED'])) {
        $camAperture = $exif_ifd0['COMPUTED']['ApertureFNumber'];
      } else { $camAperture = $notFound; }
     
      // Date
      if (@array_key_exists('DateTime', $exif_ifd0)) {
        $camDate = $exif_ifd0['DateTime'];
      } else { $camDate = $notFound; }
     
      // ISO
      if (@array_key_exists('ISOSpeedRatings',$exif_exif)) {
        $camIso = $exif_exif['ISOSpeedRatings'];
      } else { $camIso = $notFound; }
     
      $return = array();
      $return['make'] = $camMake;
      $return['model'] = $camModel;
      $return['exposure'] = $camExposure;
      $return['aperture'] = $camAperture;
      $return['date'] = $camDate;
      $return['iso'] = $camIso;
      return $return;
   
    } else {
      return false;
    }
}



function format_size($size) {

    $mod = 1024;

    $units = explode(' ','B KB MB GB TB PB');

    for ($i = 0; $size > $mod; $i++) {

        $size /= $mod;
    }

    return round($size, 2) . ' ' . $units[$i];
}

function url_encode($string){
        return urlencode(utf8_encode($string));
    }
 

$file = $d . $f;
if (($f != '') && (file_exists($file)))
 {
   $file_info['filename']    = basename($file);//substr( $file, ( strrpos( $file, "\\" ) +1 ) );   
   $file_info['path']    = $_REQUEST['d'];//substr( $file, ( strrpos( $file, "\\" ) +1 ) );   
   $file_info['last_modified']    = date('Y-m-d G:i:s', filemtime( $file ) );
   $file_info['size']    = format_size(filesize( $file ));
   $file_info['extension']    = strtolower(substr(strrchr($file, '.'), 1));
   if (($file_info['extension'] == "png")||($file_info['extension'] == "gif")||($file_info['extension'] == "jpg")||($file_info['extension'] == "jpeg"))
             { 
              if (($file_info['extension'] == "jpg"))
               $file_info['image_tag'] = cameraUsed($file);
             }

 }

echo json_encode($file_info);
//echo json_encode(glob($d."*",GLOB_ONLYDIR));

?>
