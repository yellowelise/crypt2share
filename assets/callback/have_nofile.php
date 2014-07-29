<?php
session_start();
//ini_set('display_errors', 'Off');
//ini_set('display_startup_errors', 'Off');
//error_reporting(0);
include("../config.php");

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
//echo "home: ".$_SESSION['home'];

$fol_size = foldersize($_SESSION['home']);
//if ($fol_size > 0)
 echo $fol_size;
?>
