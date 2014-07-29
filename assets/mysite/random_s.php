<?php

session_start();
include("../config.php");

$http = $_SESSION['app_address'] . "homes/";
$url = $_SERVER['REQUEST_URI'];


function count_images($user)
{
	$dir = $_SESSION['path'] . $user . "/files/mysite/";
    //echo $dir;
    $items = glob($dir."{*.jpeg,*.jpg,*.gif,*.png,*.JPEG,*.JPG,*.GIF,*.PNG}", GLOB_BRACE);
    //echo "<br />";
    //print_r($items);
    //echo "<br />";
    
    $dirs = glob($dir."*",GLOB_ONLYDIR|GLOB_MARK );
    for ($i = 0; $i < count($dirs); $i++) {
        if (is_dir($dirs[$i])) {
            $add = glob($dirs[$i]."{*.jpeg,*.jpg,*.gif,*.png,*.JPEG,*.JPG,*.GIF,*.PNG}", GLOB_BRACE);
            $items = array_merge($items, $add);
        }
    }
    return count($items);
}


function images_user($user)
{
	$dir = $_SESSION['path'] . $user . "/files/mysite/";
    //echo $dir;
    $items = glob($dir."{*.jpeg,*.jpg,*.gif,*.png,*.JPEG,*.JPG,*.GIF,*.PNG}", GLOB_BRACE);
    //echo "<br />";
    //print_r($items);
    //echo "<br />";
    
    $dirs = glob($dir."*",GLOB_ONLYDIR|GLOB_MARK );
    for ($i = 0; $i < count($dirs); $i++) {
        if (is_dir($dirs[$i])) {
            $add = glob($dirs[$i]."{*.jpeg,*.jpg,*.gif,*.png,*.JPEG,*.JPG,*.GIF,*.PNG}", GLOB_BRACE);
            $items = array_merge($items, $add);
        }
    }
    shuffle($items);
    return $items;
}

function get_user()
{
  $d = $_SESSION['app_path'] . "mysite/";	
  $dir = glob($d."*",GLOB_ONLYDIR|GLOB_MARK );
  $ret = array();
  $h=0;
  for ($k=0;$k<count($dir);$k++)
	  if (count_images(basename($dir[$k])) > 0)
	   {
			$ret[$h] = $dir[$k];
			$h++;
	   }
    shuffle($ret);
  return $ret;    
}







function roundUpToAny($n,$x=5) {
    return round(($n+$x/2)/$x)*$x;
}



  
$users = get_user();

$quante = count($users);
if ($quante > $_REQUEST['q'])
 $quante = $_REQUEST['q'];
 
$quantispan3 = floor($quante / 4);
$quanterow = floor($quantispan3 / 3);
for ($i = 0;$i<$quante;$i++)
 {
	$immagini = images_user(basename($users[$i])); 
	//echo "user:" .$i . "<br />";
	//print_r($immagini);
	//echo "<br />";
	 //echo "i:" . $i . " mod:".($i % 6) ."<br />";
	if ((($i % 4) === 0)||($i==0)) 
	 $res .= "<div class='row-fluid'>";

	  if ($users[$i])
	   {
		   $res .= "<div class='span3'><a href='".$_SESSION['mysite_address'].basename($users[$i])."'><h3>MySite: ".basename($users[$i])."</h3></a>";
			 for ($j=0;$j<9;$j++)	
			   {
				if ($immagini[$j])   
				 $res .= "<img src='../img_my.php?fn=".urlencode(str_replace( $_SESSION['path'] ,"",$immagini[$j]))."&c=1&s=120'>";
				if (($j==2)||($j==5))
				 $res .="<br />";
			   }	
		   $res .= "</div>";
	   }		 

	if ((($i % 4) === 3)) 
	 $res .= "</div><br />";
	  
 }
if ((($quante % 4) < 3) && (($quante % 4) != 0))
 $res .="</div><br />";





	  
echo $res;


?>
