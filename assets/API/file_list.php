<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");
include("mp3.php");

$json_header = array(
"code"=>"",
"dir"=>"",
"page"=>0,
"how_many_per_page"=>0,
"total_items"=>0,
"total_pages"=>0,
"last_modified"=>"",
//"order"=>"",
"files"=>array()
);

if (isset($_REQUEST['p']))
 $p = $_REQUEST['p'];
else
 $p = 1;


if (isset($_REQUEST['ext']))
 $ext = $_REQUEST['ext'];
else
 $ext = "*";

if (isset($_REQUEST['dtl']))
 $dtl = $_REQUEST['dtl'];
else
 $dtl = "";




$json_header['page'] = $p;


//if (isset($_REQUEST['o']))
// $o = $_REQUEST['o'];
//else
// $o = "name";

//$json_header['order'] = $o;


if (isset($_REQUEST['q']))
 $q = $_REQUEST['q'];
else
 $q = 15;

$json_header['how_many_per_page'] = $q;

  

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
 $json_header["dir"] = str_replace($_SESSION['home'],"",$d);
 
 
 
 
function zip_info_generator($zip_file_name) {
    $zip = zip_open($zip_file_name);
    $folder_count   = 0;
    $file_count     = 0;
    $unzipped_size  = 0;
    $ext_array      = array ();
    $ext_count      = array ();
    if ($zip) {
        while ($zip_entry = zip_read($zip)) {
            if (is_dir(zip_entry_name($zip_entry))) {
                $folder_count++;
            }else {
                $file_count++;
            }
            $path_parts = pathinfo(zip_entry_name($zip_entry));
            $ext = strtolower(trim(isset ($path_parts['extension']) ? $path_parts['extension'] : ''));
            if($ext != '') {
                $ext_count[$ext]['count'] = isset ( $ext_count[$ext]['count']) ?  $ext_count[$ext]['count'] : 0;
                $ext_count[$ext]['count']++;
            }
            $unzipped_size = $unzipped_size + zip_entry_filesize($zip_entry);
        }
    }
    $zipped_size = format_size(filesize($zip_file_name));
    $unzipped_size = format_size($unzipped_size);
    $zip_info = array ("folders"=>$folder_count,
                       "files"=>$file_count,
                       "zipped_size"=>$zipped_size,
                       "unzipped_size"=>$unzipped_size,
                       "file_types"=>$ext_count
                    );
    zip_close($zip);
    return $zip_info ;
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
 

function glob_files($source_folder, $ext, $start, $stop,$dtl){
	
	$oReader = new ID3TagsReader();
	
    if( !is_dir( $source_folder ) ) {
        $json_header["code"] = "404";//"Directory non valida.";
        echo json_encode($json_header);
        exit;
    }

$j = 0;

  
    $FILES = glob($source_folder."/*.".$ext);
    //$FILES = glob_recursive($source_folder."/*.".$ext);
    $set_limit    = 0;
   $k = 0;
    foreach($FILES as $key => $file) {
   
        
       if (($j>=$start)&&($j<$stop))
         {
            //$FILE_LIST[$key]['path']    = str_replace($_SESSION['path'].$_SESSION['username']."/files/","",$file);//substr( $file, 0, ( strrpos( $file, "\\" ) +1 ) );
            $FILE_LIST[$k]['filename']    = basename($file);//substr( $file, ( strrpos( $file, "\\" ) +1 ) );   
            //$FILE_LIST[$k]['dir']    = str_replace(basename($file),"",$file);
            
            $FILE_LIST[$k]['size']    = filesize( $file );
            $FILE_LIST[$k]['human_size']    = format_size(filesize( $file ));
            $FILE_LIST[$k]['last_modified']    = date('Y-m-d G:i:s', filemtime( $file ) );
            $FILE_LIST[$k]['extension']    = strtolower(substr(strrchr($file, '.'), 1));
            $FILE_LIST[$k]['preview_url'] = "";
            if (($FILE_LIST[$k]['extension'] == "mp3")||($FILE_LIST[$k]['extension'] == "ogg")||($FILE_LIST[$k]['extension'] == "avi")||($FILE_LIST[$k]['extension'] == "mov")||($FILE_LIST[$k]['extension'] == "mp4")||($FILE_LIST[$k]['extension'] == "3gp")||($FILE_LIST[$k]['extension'] == "flv"))
             { 
			  $now = time();//date("Ymd-His");	 
			  $link_name = sha1($file) . "_" . $now . "_".rand(10000000,999999999).".".$FILE_LIST[$k]['extension'];
			  if (count(glob($_SESSION['app_path'].'public/'.sha1($file)."*.*")) == 0)
			   shell_exec('ln -s "'.$file.'" "'.$_SESSION['app_path'].'public/'.$link_name.'"');
              $FILE_LIST[$k]['preview_url'] = url_encode($_SESSION['server_path'] . "public/" . $link_name);
             }



            if (($FILE_LIST[$k]['extension'] == "png")||($FILE_LIST[$k]['extension'] == "gif")||($FILE_LIST[$k]['extension'] == "jpg")||($FILE_LIST[$k]['extension'] == "jpeg"))
             { 
              $FILE_LIST[$k]['preview_url'] = $_SESSION['server_path'] . "usr_img.php?fn=" . url_encode(str_replace($_SESSION['home'],"",$file));
              if (($FILE_LIST[$k]['extension'] == "jpg")&&($dtl=='1'))
               $FILE_LIST[$k]['image_tag'] = cameraUsed($file);
             }
              
            if (($FILE_LIST[$k]['extension'] == "mp3")&&($dtl=='1'))
            {
				$aTags = $oReader->getTagsInfo($file);
				$FILE_LIST[$k]['mp3_tag'] = $aTags;
			} 
            if (($FILE_LIST[$k]['extension'] == "zip")&&($dtl=='1'))
            {
				$FILE_LIST[$k]['zip_tag'] = zip_info_generator($file);
			} 
			
			
            $k++;
         } 
          
            $j++;
       
       
    }
    if(!empty($FILE_LIST)){

        return $FILE_LIST;
    } 
}

if (isset($_SESSION['iduser']))
{

$json_header["total_items"] = count(glob($d."/*.".$ext));
$json_header["last_modified"] = date ("Y-m-d G:i:s",filemtime($d));
if (($json_header["total_items"] % $q) == 0)
$json_header['total_pages'] = floor($json_header["total_items"] / $q);
else
$json_header['total_pages'] = floor($json_header["total_items"] / $q)+1;


$start = ($p - 1) * $q;
$stop = ($p) * $q;




$file_list = glob_files($d ,$ext,$start,$stop,$dtl);

if (!empty($file_list))
     {
        $json_header["files"] = $file_list;
     	$json_header["code"] = "200";
     }
else {
        $json_header["code"] = "404"; //"Nessun file presente";
    }
}
else
$json_header['code'] = "100";

echo json_encode($json_header);
//echo json_encode(glob($d."*",GLOB_ONLYDIR));

?>
