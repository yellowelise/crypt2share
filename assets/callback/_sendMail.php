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

//mail($to, $subject, $message, $headers);	
 echo mail($to,$subject,$message . "\nlink: " . $l,$headers);
 
//}
//else
// echo "error!";

 
 ?>
