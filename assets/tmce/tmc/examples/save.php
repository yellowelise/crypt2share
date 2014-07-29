<?php
session_start();

//print_r($_REQUEST);
$fn =  $_POST['filename'];
$data = $_POST['elm1'];
file_put_contents($_SESSION['home'] .$fn,$data);
header('Location: index.php?s=1&fn='.$fn);

?>
