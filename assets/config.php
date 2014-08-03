<?php

/*
 * Assume http://localhost/c2s/  is the root of project
 * 
 */
$_SESSION['path'] =  (__DIR__) .DIRECTORY_SEPARATOR. "homes" .DIRECTORY_SEPARATOR;
$_SESSION['app_path'] =  (__DIR__).DIRECTORY_SEPARATOR;
$_SESSION['kc_path'] = "/crypt2share/assets/homes/";
$_SESSION['kc_denied_ext'] = "exe|com|msi|bat|php|phps|phtml|php3|php4|cgi|pl|py|js|css|prop";
$_SESSION['not_logged'] = "location: ../index.php";
$_SESSION['logged'] = "location: assets/kc/browse.php?lang=it";
$_SESSION['server_path'] = "http://localhost/crypt2share/assets/";
$_SESSION['temp_path'] = (__DIR__).DIRECTORY_SEPARATOR."tmp".DIRECTORY_SEPARATOR;
$_SESSION['site_address'] = "http://localhost/crypt2share/";
$_SESSION['app_address'] = "http://localhost/crypt2share/assets/";
$_SESSION['mysite_address'] = "http://localhost/crypt2share/assets/mysite/";
$_SESSION['public_address'] = "http://localhost/crypt2share/upload/";

?>
