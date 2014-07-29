<?php
session_start();
include("class/mysql.class.php");
$id = $_REQUEST['id'];
$pass = $_REQUEST['p'];


 
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 $sql = "select filename, AES_DECRYPT(contents,'".$pass."') from cry_contents where iduser ='".$_SESSION['iduser']."' and idcry_contents = '".$id."' and hash_crypted = '".sha1($pass)."'";
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 $db1->Close();
 //echo "file:" . $results[0]['filename'];
 if ($results[0]['filename'] != '')
 {
 $file = $_SESSION['home'] . $results[0]['filename'];
 file_put_contents($file,$results[0]['contents']);
  

}
else
 echo "errore!"; 
?>
