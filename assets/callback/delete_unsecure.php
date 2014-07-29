<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

$f = utf8_decode($_REQUEST['f']);
$file = $_SESSION['home'] . $f;
unlink($file);

?>
