<?php
session_start();
//ini_set('display_errors', 'Off');
//ini_set('display_startup_errors', 'Off');
//error_reporting(0);

if (isset($_SESSION['access_token']))
echo $_SESSION['access_token'];
else
echo "login";
?>
