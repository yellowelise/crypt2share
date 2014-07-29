	<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
include("../class/mysql.class.php");
include("../config.php");


function add_size_sender($e)
{
 $db = new MySQL(true);
 if ($db->Error()) $db->Kill();
 $db->Open();
 $sql = "select id_sender from invited where friend_email = '".$e."' and counted = '0'";
 //echo $sql."<br />";
 $results = $db->QueryArray($sql);
 $db->Close();
 if (($results)&&($results[0]['id_sender'] > '1')&&($results[0]['id_sender'] !=''))
	{
		 $db->Open();
		 $sql = "update invited set counted = '1' where friend_email = '".$e."'";
		 //echo $sql."<br />";
		 $db->Query($sql);
		 $db->Close();

		 $db->Open();
		 $sql = "update users set max_file_size = max_file_size + 10485760 where iduser = '".$results[0]['id_sender']."'";
		 //echo $sql."<br />";
		 $db->Query($sql);
		 $db->Close();
		
	}
	
//	10485760
}

$u =  strtolower($_POST['u']);
$u_epu = preg_replace('/[^a-zA-Z0-9.]/s', '', $u);

$p = sha1($_POST['p']);

//echo $_SESSION['path'];// =  "/home/crypt2/public_html/app/homes/";
//echo $u . "<>" . $u_epu;
if ($u == $u_epu)
{
 $sql = "select iduser,email,last_access,max_number_of_files,max_file_size from users where username = '".$u."' and password = '".$p."' and active = '1'";
 //echo $sql; 
 $db1 = new MySQL(true);
 if ($db1->Error()) 
	{
		echo "dberror";
		$db1->Kill();
	}
 $db1->Open();
// echo $sql."<br />";
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
 if (!file_exists($_SESSION['home']))
  {
   mkdir($_SESSION['home']);
   add_size_sender($_SESSION['email']);
  }
 if (!file_exists($_SESSION['home']."files"))
  {
	//primo accesso   
    mkdir($_SESSION['home']."files");
  mkdir($_SESSION['home']."files/Documents");
  mkdir($_SESSION['home']."files/Videos");
  mkdir($_SESSION['home']."files/Musics");
  mkdir($_SESSION['home']."files/Images");
  mkdir($_SESSION['home']."files/Desktop");
   
  }


  
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
// else
//  {
//   echo $_SESSION['app_path'] . "/mysite/".$u."/index.php";	  
//  }     

  if ((md5_file($_SESSION['app_path'] . "mysite/.mysite_template/1/index.php") != md5_file($_SESSION['app_path'] . "/mysite/".$u."/index.php")) || (md5_file($_SESSION['app_path'] . "mysite/.mysite_template/1/callback.php") != md5_file($_SESSION['app_path'] . "/mysite/".$u."/callback.php")))
   {
    copy($_SESSION['app_path'] . "mysite/.mysite_template/1/index.php",$_SESSION['app_path'] . "/mysite/".$u."/index.php");
    copy($_SESSION['app_path'] . "mysite/.mysite_template/1/callback.php",$_SESSION['app_path'] . "/mysite/".$u."/callback.php");
    //echo "mysite aggiornato";
   }
  
  //public_html/app/mysite/.mysite_template/1
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
