<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
include("../class/mysql.class.php");
include("../config.php");
if ($_REQUEST['u'])
 {
   $u =  strtolower($_REQUEST['u']);
   $u_epu = preg_replace('/[^a-zA-Z0-9.]/s', '', $u);
 }
else
 {
   $u = '';
   $u_epu = '1';	 
 }

if ($_REQUEST['m'])
 {
   $m =  strtolower($_REQUEST['m']);
 }
else
 {
   $m = '';
 }

if ($_REQUEST['h'])
 {
   $h =  ($_REQUEST['h']);
 }
else
 {
   $h = '';
 }

if ($_REQUEST['p'])
 {
   $p =  ($_REQUEST['p']);
 }
else
 {
   $p = '';
 }
 
function rand_string( $length ) {

$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
return substr(str_shuffle($chars),0,$length);

} 



 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
  
//$_SESSION['path'] =  "/home/crypt2/public_html/app/homes/";
if (($u == $u_epu)||($m != ''))
{



if ($h == '')
{
 $sql = "select username,email,password from users where ((username = '".$u."') or (email = '".$m."'))";
 
 
 $results = $db1->QueryArray($sql);
 $db1->Close();
	if ($results[0]['email'] !='')
	{
	   
		$to      = $results[0]['email'];
		$subject = "Rigenera password Crypt2Share";
		$headers = 'From: share@crypt2share.com' . "\r\n" .
			'Reply-To: share@crypt2share.com \r\n' .
			'X-Mailer: PHP/' . phpversion();

		$headers .= "MIME-Version: 1.0\n";
		$headers .= 'Content-Type: text/html; charset=\"iso-8859-1\"\n';
		$headers .= "Content-Transfer-Encoding: 7bit\n\n";
		//mail($to, $subject, $message, $headers);	
		$message = "Per resettare la password clicca sul seguente ";
		$l = $_SESSION['app_address'] . "callback/reset_pass.php?u=" .$results[0]['username']."&h=" . $results[0]['password'] . "&m=" . $results[0]['email'] ;
		//$l = $_SESSION['site_address'] ."/index.php?cID=133&"
		
		$tmpl = file_get_contents("../template/mail.tpl");
		$message_tpl = str_replace("#messagebody#",str_replace("\n","<br />",$message. " link:\n" . $l),$tmpl);

        //echo $to."<br />".$subject."<br />".$message_tpl ."<br />".$headers;
		 mail($to,$subject,$message_tpl ,$headers);	
		 echo utf8_encode("Controlla la mail per il link di reset della password");

	}
}
else
 {
  
  
  if ($p == '')	 
    $new_pass = rand_string(10);
  else
    $new_pass = $p;
    
    
  //echo "u:" . $u . " h:" . $h;
  $sql = "update users set password = '".sha1($new_pass)."' where ((username = '".$u."') and (password = '".$h."') and (email = '".$m."'))";
  $results = $db1->Query($sql);
  $db1->Close();

		$to      = $m;
		$subject = "Password Crypt2Share Rigenerata";
		$headers = 'From: share@crypt2share.com' . "\r\n" .
			'Reply-To: share@crypt2share.com\r\n' .
			'X-Mailer: PHP/' . phpversion();

		$headers .= "MIME-Version: 1.0\n";
		$headers .= 'Content-Type: text/html; charset=\"iso-8859-1\"\n';
		$headers .= "Content-Transfer-Encoding: 7bit\n\n";
		//mail($to, $subject, $message, $headers);	
		$message = "la tua nuova password per Crypt2Share è: " . $new_pass;
		$tmpl = file_get_contents("../template/mail.tpl");
        $l = $_SESSION['site_address'] ."/index.php?cID=133&u=" . $u . "&h=" . sha1($new_pass) . "&m=" . $m . "&gen=" . $new_pass; 

		$message_tpl = str_replace("#messagebody#",str_replace("\n","<br />",$message . "\nPer cambiare la tua nuova password puoi ciccare qui:\n" . $l),$tmpl);
        //echo $to."<br />".$subject."<br />".$message_tpl ."<br />".$headers;
		 mail($to,$subject,$message_tpl ,$headers);	
		 if ($p == '')
		   echo utf8_encode("Controlla la mail per la tua nuova password.");
		 else
		   echo "Password modificata con successo.";  
 }
}
 ?>
