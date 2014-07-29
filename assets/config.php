<?php
//session_start();


//$_SESSION['path'] =  dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . "homes" . DIRECTORY_SEPARATOR;
$_SESSION['path'] =  (__DIR__) .DIRECTORY_SEPARATOR. "homes" .DIRECTORY_SEPARATOR;
$_SESSION['app_path'] =  (__DIR__).DIRECTORY_SEPARATOR;
$_SESSION['kc_path'] = "/2.0/app/homes/";
$_SESSION['kc_denied_ext'] = "exe|com|msi|bat|php|phps|phtml|php3|php4|cgi|pl|py|js|css|prop";
$_SESSION['not_logged'] = "location: ../index.php";
$_SESSION['logged'] = "location: 2.0/app/kc/browse.php?lang=it";
$_SESSION['server_path'] = "http://localhost/2.0/app/";
$_SESSION['temp_path'] = (__DIR__).DIRECTORY_SEPARATOR."tmp".DIRECTORY_SEPARATOR;
$_SESSION['site_address'] = "http://localhost/2.0/";
$_SESSION['app_address'] = "http://localhost/2.0/app/";
$_SESSION['mysite_address'] = "http://localhost/2.0/app/mysite/";
$_SESSION['public_address'] = "http://localhost/2.0/upload/";

?>
