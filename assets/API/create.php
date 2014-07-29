<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
include("../class/mysql.class.php");
include("../config.php");

$u = strtolower($_REQUEST['u']);
$u_epu = preg_replace('/[^a-zA-Z0-9.]/s', '', $u);
$p = $_REQUEST['p'];
$m = $_REQUEST['m'];
$ip = $_SERVER['REMOTE_ADDR'];


$json = array(
"code"=>"",
"id"=>"",
"type"=>"Free",
);

 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();


if ($u == $u_epu)
{
$path = $_SESSION['path'] . $u_epu . DIRECTORY_SEPARATOR;
 
if (!file_exists($path))
{
 $db1->Open();
 $sql = "select email from users where email = '".$m."'";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $mail = $results[0]['email'];
 $db1->Close();


if ($mail == '')
{
 $db1->Open();
 $sql = "insert into users (username,password,email,ip,active) values ('".$u."','".sha1($p)."','".$m."','".$ip."','1') ";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 $db1->Close();

 $db1->Open();
 $sql = "select iduser from users where username = '".$u."' and password = '".sha1($p)."'";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $id = $results[0]['iduser'];
 $db1->Close();
//   if (!file_exists($path))
//  mkdir($path, 0777);
 $_SESSION['home'] = $_SESSION['path'] . $u_epu . DIRECTORY_SEPARATOR ;
 
 
 
 if (!file_exists($_SESSION['path']))
  mkdir($_SESSION['path']);
  
 //echo $_SESSION['home'];
 if (!file_exists($_SESSION['home']))
  mkdir($_SESSION['home']);

 if (!file_exists($_SESSION['home']."files"))
  mkdir($_SESSION['home']."files");

 if (file_exists($_SESSION['home']."files"))
  mkdir($_SESSION['home']."files/Documents");
 if (file_exists($_SESSION['home']."files"))
  mkdir($_SESSION['home']."files/Videos");
 if (file_exists($_SESSION['home']."files"))
  mkdir($_SESSION['home']."files/Musics");
 if (file_exists($_SESSION['home']."files"))
  mkdir($_SESSION['home']."files/Images");

 if (!file_exists($_SESSION['home']."files/mysite"))
  {
	//primo accesso   
    mkdir($_SESSION['home']."files/mysite");

  }
 if (!file_exists($_SESSION['app_path'] . "mysite/".$u."/index.php"))
  {
    mkdir($_SESSION['app_path']."mysite/" . $u . "/");
  //  echo "\n".$_SESSION['app_path']."mysite/" . $u . "/\n";
  // if (file_exists($_SESSION['app_path'] . "mysite/.mysite_template/1/index.php"))
  //	 echo "\nesiste index" . $_SESSION['app_path'] . "mysite/.mysite_template/1/index.php\n";
//	else
//	 echo "\nNon esiste index" . $_SESSION['app_path'] . "mysite/.mysite_template/1/index.php\n";
	    
   copy($_SESSION['app_path'] . "mysite/.mysite_template/1/index.php",$_SESSION['app_path'] . "/mysite/".$u."/index.php");
    copy($_SESSION['app_path'] . "mysite/.mysite_template/1/callback.php",$_SESSION['app_path'] . "/mysite/".$u."/callback.php");
//   echo "copiato" .$_SESSION['app_path'] . "mysite/".$u."/index.php";
  }

if ((md5_file($_SESSION['app_path'] . "mysite/.mysite_template/1/index.php") != md5_file($_SESSION['app_path'] . "/mysite/".$u."/index.php")) || (md5_file($_SESSION['app_path'] . "mysite/.mysite_template/1/callback.php") != md5_file($_SESSION['app_path'] . "/mysite/".$u."/callback.php")))
   {
    copy($_SESSION['app_path'] . "mysite/.mysite_template/1/index.php",$_SESSION['app_path'] . "/mysite/".$u."/index.php");
    copy($_SESSION['app_path'] . "mysite/.mysite_template/1/callback.php",$_SESSION['app_path'] . "/mysite/".$u."/callback.php");
    //echo "mysite aggiornato";
   }

  
mail("yellowelise@gmail.com","Nuova registrazione android",$u . "\n".$m);
  
//$res = mail($m,"Crypt2Share activation","Hi ".$u."\nClick or copy in browser this link to activate:\n https://www.crypt2share.com/activate.php?h=".sha1($p)."&u=".$u);
//echo "Completa la registrazione seguendo le istruzioni via mail.";
$json["code"] = "200";
$json["id"] = $id;
}
else
{
$json["code"] = "104";
	
}
}
else
{
$json["code"] = "105";
}
}
else
$json["code"] = "102";


echo json_encode($json);
?>
