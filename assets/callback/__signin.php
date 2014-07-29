<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
include("../class/mysql.class.php");
include("../config.php");

$u =  strtolower($_POST['u']);
$u_epu = preg_replace('/[^a-zA-Z0-9.]/s', '', $u);

$p = sha1($_POST['p']);

//$_SESSION['path'] =  "/home/crypt2/public_html/app/homes/";
if ($u == $u_epu)
{
 
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select iduser,email,last_access,max_number_of_files,max_file_size from users where username = '".$u."' and password = '".$p."' and active = '1'";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $db1->Close();
if (($results)&&($results[0]['iduser'] > '1')&&($results[0]['iduser'] !=''))
{
 $_SESSION['iduser'] = $results[0]['iduser'];
 $_SESSION['email'] = $results[0]['email'];
 $_SESSION['home'] = $_SESSION['path'] . $u_epu . DIRECTORY_SEPARATOR ;


 $_SESSION['last_access'] = $results[0]['last_access'];
 $_SESSION['max_file_size'] = $results[0]["max_file_size"];
 $_SESSION['max_number_of_files'] = $results[0]["max_number_of_files"];
 
 
 
 if (!file_exists($_SESSION['path']))
  mkdir($_SESSION['path']);
  
 //echo $_SESSION['home'];
 $first = 0;
 if (!file_exists($_SESSION['home']))
  {
   $first = 1;
   mkdir($_SESSION['home']);
  }
 if (!file_exists($_SESSION['home']."files"))
  mkdir($_SESSION['home']."files");

 if($first ==1)
 {
  if (file_exists($_SESSION['home']."files"))
  mkdir($_SESSION['home']."files/Documents");
 if (file_exists($_SESSION['home']."files"))
  mkdir($_SESSION['home']."files/Videos");
 if (file_exists($_SESSION['home']."files"))
  mkdir($_SESSION['home']."files/Musics");
 if (file_exists($_SESSION['home']."files"))
  mkdir($_SESSION['home']."files/Images");
 }
 //if (!file_exists($_SESSION['home']."files". DIRECTORY_SEPARATOR ."crypt"))
 // mkdir($_SESSION['home']."files". DIRECTORY_SEPARATOR ."crypt");
 
 
 $_SESSION['username'] = $u; 
 //echo $_SESSION['home'];
}
else
echo "Username o password errati!";
}
else
echo "Caratteri non permessi nel nome utente... (a-z A-Z 0-9 e . )";
 ?>
