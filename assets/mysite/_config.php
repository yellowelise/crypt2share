<?php
//session_start();


//$_SESSION['path'] =  dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . "homes" . DIRECTORY_SEPARATOR;
$_SESSION['path'] =  "/var/www/crypt/homes/";
$_SESSION['app_path'] =  "/var/www/crypt/";

$_SESSION['kc_path'] = "/crypt/homes/";
$_SESSION['kc_denied_ext'] = "exe|com|msi|bat|php|phps|phtml|php3|php4|cgi|pl|py";
$_SESSION['not_logged'] = "location: ../login.php";
$_SESSION['logged'] = "location: kc/browse.php?lang=it";
$_SESSION['server_path'] = "http://localhost/crypt/";
$_SESSION['temp_path'] = "/var/www/crypt/tmp/";
$_SESSION['site_address'] = "http://localhost/crypt/";
$_SESSION['app_address'] = "http://localhost/crypt/";


?>
