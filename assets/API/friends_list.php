<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("../class/mysql.class.php");

$json_header = array(
"code"=>"",
"how_many_friends"=>"",
"friends"=>array()
);


 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 $db1->Open();
 
 $sql = "select distinct username,iduser,email from users where (iduser in (select id1 from friendship where id2 = '".$_SESSION['iduser']."' and status = 1)) or (iduser in (select id2 from friendship where id1 = '".$_SESSION['iduser']."' and status = 1))";
 
 //echo $sql."<br />";
 $results = $db1->QueryArray($sql);
 
 $db1->Close();
 $amici= array();
 if($results)
	{
		$json_header["code"] = "200";
		$json_header["how_many_friends"] = count($results);
			for ($i=0;$i<count($results);$i++)
				{
					$amici[$i]["username"] = $results[$i]["username"];
					$amici[$i]["id_friend"] = $results[$i]["iduser"];
					$amici[$i]["email"] = $results[$i]["email"];
				}
				
	}
 else
	{
		$json_header["code"] = "407";//"Nessun amico";
		$json_header["how_many_friends"] = 0;
	}
	$json_header["friends"] = $amici;
 
echo json_encode($json_header);
	       
?>
