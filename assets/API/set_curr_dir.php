<?php
session_start();
//ini_set('display_errors', 'Off');
//ini_set('display_startup_errors', 'Off');
//error_reporting(0);

if (isset($_REQUEST['d']))
 $_SESSION['curr_dir'] = $_REQUEST['d'];
else
 $_SESSION['curr_dir'] = "files/";
  
 
echo $_SESSION['curr_dir'];  

?>
