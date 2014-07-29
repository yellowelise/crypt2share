<?php
session_start();
include("config.php");
include("class/mysql.class.php");


$FILES = glob($_SESSION['app_path'].'public/*');
echo "temp file (".$_SESSION['app_path']."public/):<br />\n<pre>";
 foreach($FILES as $key => $file) {
   // echo $file . "<br />";
    $parts = split("_",basename($file));
   // echo $parts[1] . "<br />";
   // echo date("Y-m-d H:i:s",$parts[1]) . "<br />";
    $ore = round((((time() - $parts[1]) / 60)/60),1) . "<br />";
    if ($ore > 6)
     {
       echo "elimino: " . $file . "<br />\n";
       unlink($file);
     }
   }
echo "</pre>";

function email_from_username($user)
{
	 $db1 = new MySQL(true);
	 if ($db1->Error()) $db1->Kill();
	 $db1->Open();
	 $sql = "select email from users where username ='".$user."'";
	// echo $sql."<br />";
	 $results = $db1->QueryArray($sql);
     if ($results)
      return $results[0]['email'];
     else
      return ''; 
      
}


function timeDiff($firstTime,$lastTime)
{

// convert to unix timestamps
$firstTime=strtotime($firstTime);
$lastTime=strtotime($lastTime);

// perform subtraction to get the difference (in seconds) between times
$timeDiff=$lastTime-$firstTime;

// return the difference
return $timeDiff;
}

function check_for_notification()
{
	
 $user_access = array();	
   $db = new MySQL(true);
   if ($db->Error()) $db->Kill();
	$db->Open();
 $sql = "select max(date_last_view) as date_last_view,username from mysite_notifies group by username";
//echo $sql."<br />";
 $results = $db->QueryArray($sql);
 
 
 if ($results)
  for ($i=0;$i<count($results);$i++)
   {
    $user_access[$results[$i]['username']] = $results[$i]['date_last_view'];

   }
   
//  print_r($user_access);  
  	$db->Close();
  	$db->Open();
  
 $sql = "select count(comment) as num_comments,resource,max(date) as date,substr(resource,1, instr(resource,'%2F')-1) as owner from mysite_comments group by resource";
 //echo $sql;
 $results2 = $db->QueryArray($sql);
 //echo "Count:" . count($results2);
 if ($results2)
  for ($i=0;$i<count($results2);$i++)
    {
		if (timeDiff($results2[$i]['date'],$user_access[$results2[$i]['owner']])<0)
		  {
			$to      = email_from_username($results2[$i]['owner']);
			$subject = "Nuovi commenti su MySite";
			$message = "Hai dei nuovi commenti sul tuo MySite!\nAccedi al tuo MySite per leggerli.";
			$l = $_SESSION["mysite_address"] . $results2[$i]['owner'];
			$headers = 'From: share@crypt2share.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

			$headers .= "MIME-Version: 1.0\n";
			$headers .= 'Content-Type: text/html; charset=\"iso-8859-1\"\n';
			$headers .= "Content-Transfer-Encoding: 7bit\n\n";
			//mail($to, $subject, $message, $headers);	
			$tmpl = file_get_contents("template/mail.tpl");
			$message_tpl = str_replace("#messagebody#",str_replace("\n","<br />",$message. "\nlink: " . $l),$tmpl);

    	    mail($to,$subject,$message_tpl ,$headers);
		    echo $to . "<br />".$subject . "<br />";
 			  
		  }
	}
	    
   /*
 //echo "ultima visita: " . $data . "<br />";
// $sql = "select count(idmysite_notifies) as num_comments from mysite_notifies where (username !='".$user."' and resource ='".$resource."') and (TIME_TO_SEC(TIMEDIFF(now(),'".$data."')) > 0)";
 $sql = "select count(comment) as num_comments from mysite_comments where (comment_user !='".$user."' and resource ='".$resource."' and type=0) and (TIME_TO_SEC(TIMEDIFF(date,'".$data."')) > 0)";
 //echo $sql."\n";
 $results = $db->QueryArray($sql);
 if ($results)
  return $results[0]['num_comments'];
 else
  return "0";*/
   
}

check_for_notification();

?>
