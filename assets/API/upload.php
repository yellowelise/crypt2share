<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

if (isset($_POST["d"]))
 $d = urldecode($_POST["d"]);
else
 $d = "files/";

$json = array(
"code"=>"",
"files"=>array()
);  

$json_files = array();


function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = urldecode($file_post[$key][$i]);
        }
    }

    return $file_ary;
}

function url_encode($string){
        return urlencode(utf8_encode($string));
    }
    
    
function format_size($size) {

    $mod = 1024;

    $units = explode(' ','B KB MB GB TB PB');

    for ($i = 0; $size > $mod; $i++) {

        $size /= $mod;
    }

    return round($size, 2) . ' ' . $units[$i];
}
function new_name($d,$f,$i)
{
	$f_noext = str_replace(".".strtolower(substr(strrchr(basename($f), '.'), 1)),"",basename($f)); 
	$ext = strtolower(substr(strrchr(basename($f), '.'), 1)); 
	$new_name = $f_noext."(".$i.").".$ext;
	if (file_exists($d . $new_name))
	{
	 $ret = new_name($d,$f,$i+1);
	}
	else
	 $ret = $new_name;
 return $ret;	  
}

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
	// Free up memory (imagedestroy does not delete files):
	@imagedestroy($image);
	return $success;
}




if ($_FILES['upload']) {
    $file_ary = reArrayFiles($_FILES['upload']);
    $k = 0;
    $json["code"] = "200";
    foreach ($file_ary as $file) {
		//$json[$k]["files"]["debug_tmp_name"] = 
		
     if (preg_match('/\.('.$_SESSION['kc_denied_ext'].')$/i', $file['name'])) {

			$json["code"] = "404";
			$json["files"]["code"] = "408";//"Errore nell'upload del file";
			$json["files"]["filename"] = basename( $file['name']);

        }
     else
      {  
		
		$target_path = $_SESSION["home"].$d;
		$target_path = $target_path . basename( $file['name']);
		if (file_exists($target_path))
		 $target_path = $_SESSION["home"].$d . new_name($d,basename($file['name']),1);
		//$json[$k]["files"]["debug_tmp_name"] = $file['tmp_name'];
		//$json[$k]["files"]["debug_target"] = $target_path;
		
		
		
		if(move_uploaded_file($file['tmp_name'], $target_path)) {
			$json["files"]["code"] = "200";

			
			$json["files"]["filename"] = basename($target_path);
			$json["files"]["dir"] = $d;
			$json["files"]["last_modified"] = date('Y-m-d G:i:s', filemtime( basename($target_path) ) );
			$json["files"]["extension"] = strtolower(substr(strrchr(basename($target_path), '.'), 1));
            if (($json["files"]["extension"] == 'jpg')||($json["files"]["extension"] == 'jpeg'))
             orient_image($target_path);
			$json["files"]["size"] = filesize($target_path);
			$json["files"]["human_size"] = format_size($json["files"]["size"]);        


            if (($json["files"]["extension"] == "mp3")||($json["files"]["extension"] == "ogg")||($json["files"]["extension"] == "avi")||($json["files"]["extension"] == "mov")||($json["files"]["extension"] == "mp4")||($json["files"]["extension"] == "3gp")||($json["files"]["extension"] == "flv"))
             { 
			  $now = time();//date("Ymd-His");	 
			  $link_name = session_id() . "_" . $now . "_".rand(10000000,999999999).".".$json["files"]['extension'];
			  shell_exec('ln -s "'.$file.'" "'.$_SESSION['app_path'].'public/'.$link_name.'"');

              $json["files"]['preview_url'] = url_encode($_SESSION['server_path'] . "public/" . $link_name);
             }

            if (($json["files"]["extension"] == "png")||($json["files"]["extension"] == "gif")||($json["files"]["extension"] == "jpg")||($json["files"]["extension"] == "jpeg"))
              $json["files"]['preview_url'] = $_SESSION['server_path'] . "usr_img.php?fn=" . url_encode($d.$json["files"]["filename"]);
            else
              $json["files"]['preview_url'] = "";

         }   
        else
         {
			$json["code"] = "404";
			$json["files"]["code"] = "408";//"Errore nell'upload del file";
			$json["files"]["filename"] = basename( $file['name']);
		 } 
	
	
	
 }
	
	
		$k++;
		
		
		
		
    }

}
else
  $json["code"] = "404";




echo json_encode($json);
//echo "<br />";
//echo json_encode($_FILES);
?>
