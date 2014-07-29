<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);


include("../class/mysql.class.php");
include("../config.php");
//include("lang/IT.php");

$json = array(
"id"=>"",
"last_access"=>"",
"type"=>"free",
"code"=>"200",
"max_file_size"=>"",
"max_number_of_files"=>""

);

//$json["messages"] = $translate_message;


$u =  strtolower($_REQUEST['u']);
$u_epu = preg_replace('/[^a-zA-Z0-9.]/s', '', $u);

$p = sha1($_REQUEST['p']);

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
 $_SESSION['access_token'] = 	$results[0]['iduser'];
 $_SESSION['iduser'] = $results[0]['iduser'];
 $json["id"] = $_SESSION['iduser'];
 $json["last_access"] = $results[0]['last_access'];
 $json["max_file_size"] = $results[0]['max_file_size'];
 $json["max_number_of_files"] = $results[0]['max_number_of_files'];
 
 
 $_SESSION['email'] = $results[0]['email'];
 $_SESSION['home'] = $_SESSION['path'] . $u_epu . DIRECTORY_SEPARATOR ;
 
 $db1->Open();
 $sql = "update users set last_access = now() where username = '".$u."' and password = '".$p."' and active = '1'";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 
 
 if (!file_exists($_SESSION['path']))
  mkdir($_SESSION['path']);
  
 //echo $_SESSION['home'];
 if (!file_exists($_SESSION['home']))
  mkdir($_SESSION['home']);

 if (!file_exists($_SESSION['home']."files"))
  mkdir($_SESSION['home']."files");

 //if (!file_exists($_SESSION['home']."files". DIRECTORY_SEPARATOR ."crypt"))
 // mkdir($_SESSION['home']."files". DIRECTORY_SEPARATOR ."crypt");
 
 
 $_SESSION['username'] = $u; 
 //echo $_SESSION['home'];
}
else
{

$json["id"] = "";
$json["last_access"] = "";
$json["type"] = "";
$json["code"] = "101";//"Username o password errati!";

}
}
else
{
$json["id"] = "";
$json["last_access"] = "";
$json["type"] = "";
$json["message"] = "102";//"Caratteri non permessi nel nome utente... (a-z A-Z 0-9 e . )";
}
echo json_encode($json);
 ?>
