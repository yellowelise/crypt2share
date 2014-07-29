<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
$json_res = array(
"index"=>0,
"files"=>array()
);

include("../class/mysql.class.php");


if (isset($_REQUEST['d']))
 $d = $_REQUEST['d'];
else
 $d = "files/";

if (isset($_REQUEST['q']))
 $q = $_REQUEST['q'];
else
 $q = 3;

if (isset($_REQUEST['f']))
 $f = $_REQUEST['f'];
else
 $f = "";


function url_encode($string){
        return urlencode(utf8_encode($string));
    }
 

$h = $_SESSION['home'] . $d; //Open the current directory

$list = glob($h."{*.jpg,*.gif,*.png,*.JPG,*.GIF,*.PNG,*.JPEG,*.jpeg}", GLOB_BRACE);
array_multisort($list, SORT_ASC, SORT_STRING);
for ($i=0;$i<count($list);$i++)
 {
	 $list[$i] = str_replace($h,"",$list[$i]); 
	 if ($list[$i] == $f)
	  $index = $i;
 }
/*
$k=0;
$list = array();
$index = 0;
while (false !== ($entry = readdir($h))) 
{
    if($entry != '.' && $entry != '..')
      { 
	   $ext = strtolower(substr(strrchr($entry, '.'), 1));	  
	   //echo $ext;
	   if (($ext == 'jpg')||($ext == 'jpeg')||($ext == 'gif')||($ext == 'png'))
	   {
		   $list[$k] = $entry;
           if ($entry == $f)
            $index = $k;   
		   $k++;
       }  
    }
}
asort(
*/

//primo:
if ($index == 0)
 echo $list[count($list) - 1] . "," .$list[$index] . "," .$list[$index +1]; 
else
//ultimo:
if ($index == (count($list) - 1))
 echo $list[$index-1] . "," .$list[$index] . "," .$list[0]; 
else
if ((($index + 1)<count($list)))
 echo $list[$index -1] . "," .$list[$index] . "," .$list[$index +1]; 
 
/*$json_res["index"] = $index;
$json_res["quanti"] = $k;
$json_res["files"] = $list;
echo json_encode($json_res);
*/
unset($list);
?>
