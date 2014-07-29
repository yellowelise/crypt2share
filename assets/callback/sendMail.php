<?php
session_start();
if ((!$_SESSION['iduser']) || ($_SESSION['iduser']<1))
  header("location: ../index.php/signin");
  
  
$e = urldecode($_POST['e']);
$s = urldecode($_POST['s']);
$t = urldecode($_POST['t']);
$l = urldecode($_POST['l']);

//echo $e;
//if(filter_var($e, FILTER_VALIDATE_EMAIL))
//{
	
$to      = $e;
$subject = $s;
$message = $t;
$headers = 'From: share@crypt2share.com' . "\r\n" .
    'Reply-To: '. $_SESSION['email'] . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

$headers .= "MIME-Version: 1.0\n";
$headers .= 'Content-Type: text/html; charset=\"iso-8859-1\"\n';
$headers .= "Content-Transfer-Encoding: 7bit\n\n";
//mail($to, $subject, $message, $headers);	
$tmpl = file_get_contents("../template/mail.tpl");
$message_tpl = str_replace("#messagebody#",str_replace("\n","<br />",$message. "\nlink: " . $l),$tmpl);

 echo mail($to,$subject,$message_tpl ,$headers);
 
//}
//else
// echo "error!";

 
 ?>
