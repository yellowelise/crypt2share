<?php
session_start();

include("class/mysql.class.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
 <head>
  <title>Secret Zone - Your private zone</title>
    <!-- Bootstrap -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
 </head>

	<body>
<div class="container">		
<div class="row-fluid">
	<div class="span12">
<?php
$path = $_SESSION['home'];
$pass = $_POST['pass'];
$page = "home.php";
$name = rand(1000,900000) . ".jpg";


echo "path: " . $path . "<br />";
echo "pass: " . $pass . "<br />";


//$_SERVER['PHP_SELF']; // you can get rid of $_SERVER['PHP_SELF']; and replace it with your own link. e.x: $page = "demo.html";
//header("Refresh: 3; url=$page");

//echo "path: ". $path;


function db_insert($filename,$tmp,$pass,$uploadticket)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "insert into cry_contents (filename,contents,hash_crypted,iduser,uploadticket) values ('".$filename."',AES_ENCRYPT('".$tmp."','".$pass."'),'".sha1($pass)."','".$_SESSION['iduser']."','".$uploadticket."') ";
 //echo $sql."<br />";
 $results = $db1->Query($sql);
 $db1->Close();
 
}

function db_insert_chunk($filename,$tmp,$pass)
{
    $fp = fopen($tmp, 'r');	
	$btotal = filesize($tmp);
	
	$da = 0;
	$quanti = 200000;
   // echo $btotal . "<br />";
    $uploadticket = rand(100,1000000000);
//	$part = stream_get_contents($fp,$da,$quanti);
//echo "un pezzo:".utf8_encode($part) . "<br />";    
	while (($da)< $btotal)
	 {
	   $part = stream_get_contents($fp,$quanti,$da);
	  // echo "da: ". $da." quanto: " . $quanti."<br />";
	  // echo "pezzo: ". $part . "<br />";
	   $da = $da + $quanti;
	   db_insert($filename,mysql_escape_mimic($part),$pass,$uploadticket);
	 }

}


function db_insert_from_tmp($filename,$tmp,$pass,$uploadticket)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 if (file_exists($tmp))
  echo "il file: " . $tmp . " esiste!<br />";
 else
  echo "il file: " . $tmp . " NON esiste!<br />";
   
 $sql = "insert into cry_contents (filename,contents,hash_crypted,iduser,uploadticket) values ('".$filename."',AES_ENCRYPT(LOAD_FILE('".$tmp."'),'".$pass."'),'".sha1($pass)."','".$_SESSION['iduser']."','".$uploadticket."') ";
 
 echo $sql."<br />";
 $results = $db1->Query($sql);
 $db1->Close();
 
}



function mysql_escape_mimic($inp) {
    if(is_array($inp))
        return array_map(__METHOD__, $inp);

    if(!empty($inp) && is_string($inp)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
    }

    return $inp;
}

$allowedExts = array("jpg", "jpeg", "gif", "png","zip","txt","doc","xls","m4a","flv");
$extension = end(explode(".", trim($name)));
echo "estensione: ".$extension . "<br />";

//if ((($_FILES["file"]["type"] == "image/gif")
//|| ($_FILES["file"]["type"] == "image/jpeg")
//|| ($_FILES["file"]["type"] == "application/zip")
//|| ($_FILES["file"]["type"] == "image/png")
//|| ($_FILES["file"]["type"] == "image/pjpeg"))
//&& ($_FILES["file"]["size"] < 20000000)
//&& in_array($extension, $allowedExts))
$proced = true;

if ($_FILES["file"]["size"] > 99000000)
 { 
	 $error = "file to big<br />";
	 $proced = false;
 }

if (!in_array($extension, $allowedExts))
 { 
	 $error .= "extension not allowed";
	 $proced = false;
 }


if ($proced)
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $name . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

//    if (file_exists($path . $_FILES["file"]["name"]))
//      {
//      echo $_FILES["file"]["name"] . " already exists. ";
//      }
//    else
//      {
           // popola_db($idtipo,$path. $_FILES["file"]["name"]);
           if ($pass != '')  
            {   
             $data = file_get_contents($_FILES["file"]["tmp_name"]);
             $data = mysql_escape_mimic($data);
             $filename = $name;
             db_insert_chunk($filename,$_FILES["file"]["tmp_name"],$pass);
            }
           else
            {
             move_uploaded_file($_FILES["file"]["tmp_name"],$path . $name);
             echo "Usecurely Stored in: " . $path . $name;
            } 
 //     }
    }
  }
else
  {
  echo "Error: ".$error. " " . $path . $name . "<br />";
  echo "filetype: ".$_FILES["file"]["type"] . "<br />";
  }

?> 
</div>
</div>
</div>
</body>
