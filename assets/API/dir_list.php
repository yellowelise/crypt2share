<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");
function foldersize($path) {

    $total_size = 0;
    $files = scandir($path);


    foreach($files as $t) {

        if (is_dir(rtrim($path, '/') . '/' . $t)) {

            if ($t<>"." && $t<>"..") {

                $size = foldersize(rtrim($path, '/') . '/' . $t);

                $total_size += $size;
            }
        } else {

            $size = filesize(rtrim($path, '/') . '/' . $t);

            $total_size += $size;
        }   
    }

    return $total_size;
}


function format_size($size) {

    $mod = 1024;

    $units = explode(' ','B KB MB GB TB PB');

    for ($i = 0; $size > $mod; $i++) {

        $size /= $mod;
    }

    return round($size, 2) . ' ' . $units[$i];
}

$json_header = array(
"code"=>"",
"dir"=>"",
"page"=>"",
"how_many_per_page"=>"",
"total_items"=>"",
"total_pages"=>"",
"last_modified"=>"",
//"order"=>"",
"directories"=>array()
);

//$json_data = array();

if (isset($_REQUEST['p']))
 $p = $_REQUEST['p'];
else
 $p = 1;

$json_header['page'] = $p;


//if (isset($_REQUEST['o']))
// $o = $_REQUEST['o'];
//else
// $o = "name";

//$json_header['order'] = $o;


if (isset($_REQUEST['q']))
 $q = $_REQUEST['q'];
else
 $q = 5;

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
 
 
if (isset($_SESSION['iduser']))
{ 
 
$dir = glob($d."*",GLOB_ONLYDIR|GLOB_MARK );



$json_header['total_items'] = count($dir);

if ((count($dir) % $q) == 0)
$json_header['total_pages'] = floor(count($dir) / $q);
else
$json_header['total_pages'] = floor(count($dir) / $q)+1;

if (is_dir($d))
$json_header['last_modified'] = date ("Y-m-d G:i:s",filemtime($d));

$start = ($p - 1) * $q;
$stop = ($p) * $q;
$j = 0;
for ($i=$start;$i<$stop;$i++)
 {
   if ($dir[$i] != '')
    {
     $time = date ("Y-m-d H:i:s.",filemtime($dir[$i]));
     $size = foldersize($dir[$i]);
    
     $dir[$i] = str_replace($_SESSION['home'],"",$dir[$i]);
   
     $json_header["directories"][$j]["name"] = $dir[$i];	 
     $json_header["directories"][$j]["size"] = $size;	 
     $json_header["directories"][$j]["human_size"] = format_size($size);	 
   }
   $j++;	 
 //  $json_header["directories"][$i]["last_modified"] = $time;	 
   
 }

//array_multisort($json_header["size"], SORT_ASC, SORT_STRING);
//asort( );
if (count($json_header["directories"])<=0)
 {
   $json_header["code"] = "404";//"Nessuna directories";
 }
else
   $json_header["code"] = "200";//ok

}
else
$json_header['code'] = "100";//non loggato

echo json_encode($json_header);

?>
