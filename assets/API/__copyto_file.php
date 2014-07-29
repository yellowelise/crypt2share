<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

$json_header = array(
"code"=>""
);

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

function movefile($f,$d)
{
	$ret = array();

if (file_exists($d.basename($f)))
	$fn = new_name($d,$f,1); 
else
	$fn = $f; 
  
  //echo "<br />" . $d.$fn . "<br />";
    if (copy($f,$d.basename($fn)))
       { 
        	$ret["code"] = "200";    
       } 
    else
       $ret["code"] = "404";//"copyerror";    


	$ret["filename"]    = $fn;//substr( $file, ( strrpos( $file, "\\" ) +1 ) );   
	if (file_exists($d.$fn))
	 $dimensione = filesize( $d.$fn );
	else
	 $dimensione = 0;
	
	$ret['size']    = $dimensione;


	$ret['human_size']    = format_size($ret['size']);
	$ret['last_modified']    = date('Y-m-d G:i:s', filemtime( $d.$fn ) );
	$ret['extension']    = strtolower(substr(strrchr($fn, '.'), 1));
       
  return $ret;     
}



$f = $_REQUEST['f'];
$d = $_REQUEST['d'];
if (file_exists($_SESSION['home'] . $f))
 {

	 if (is_dir($_SESSION['home'] . $d))
		{
			$ret = movefile($_SESSION['home'] . $f,$_SESSION['home'] . $d,$json_header);
			$json_header["code"] = $ret["code"];
			$json_header["file"]["filename"] = $ret["filename"];
			$json_header["file"]["dir"] = $d;
			$json_header["file"]["size"] = $ret["size"];
			$json_header["file"]["human_size"] = $ret["human_size"];
			$json_header["file"]["last_modified"] = $ret["last_modified"];
			$json_header["file"]["extension"] = $ret["extension"];
			
		}
	 else
	    {
			$json_header["code"] = "404";
		}	
 }
else
 {
	$json_header["code"] = "404";
 } 





echo json_encode($json_header);
 ?>
