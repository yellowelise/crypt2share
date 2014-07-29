<?php
session_start();
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include("class/mysql.class.php");
include("config.php");
//include("../func/functions.php");


function home_from_email($em)
{
	 $db1 = new MySQL(true);
	 if ($db1->Error()) $db1->Kill();
	 $db1->Open();
	 $sql = "select username from users where email ='".$em."'";
	// echo $sql."<br />";
	 $results = $db1->QueryArray($sql);
	if ($results[0]['username']!= '') 
	 return $_SESSION['path'] . preg_replace('/[^a-zA-Z0-9.]/s', '', $results[0]['username'])."/";
    else
     return $em;
}

if( $mbox = imap_open("{ocshared-de12.owncube.com:993/imap/ssl}INBOX", "upload@crypt2share.com", "cicnff")){
    echo "connesso!<br />";
     $path = "/var/www/crypt/mailatt/";
    $check = imap_mailboxmsginfo($mbox);     
    function getmsg($mbox,$mid) {   
        global $charset,$htmlmsg,$plainmsg,$attachments,$from,$to,$subj,$timages,$path;
        $htmlmsg = $plainmsg = $charset = '';
        $attachments = array();
        // HEADER
        $h = imap_headerinfo($mbox,$mid);
        // add code here to get date, from, to, cc, subject...
        $date = $h->date;
        $from = $h->fromaddress;
        $to = $h->toaddress;
          $subj = htmlspecialchars($h->Subject);
        // BODY
        $s = imap_fetchstructure($mbox,$mid);
        if (!$s->parts)  // simple
        getpart($mbox,$mid,$s,0,$from);  // pass 0 as part-number
        else {  // multipart: cycle through each part
        foreach ($s->parts as $partno0=>$p)
          getpart($mbox,$mid,$p,$partno0+1,$from);
        }
    }

    function getpart($mbox,$mid,$p,$partno,$from) {
		//echo "getpart";
        // $partno = '1', '2', '2.1', '2.1.3', etc for multipart, 0 if simple
        global $htmlmsg,$plainmsg,$charset,$attachments,$partid,$last_mail_id,$patterns,$pic,$newstr,$c,$ok,$timages,$subj,$path;
        
          $start = strpos($from,"<") + 1;
		  $stop = strpos($from,">");
		  $e_mail = substr($from,$start,$stop-$start);	
		 // echo "<pre>".$from."</pre>--".$e_mail."<br />";
		  if (!file_exists($path.$e_mail))
		   mkdir($path.$e_mail."/");	
        
        
        
        $patterns = array();
        $pic =  array();
        $image=array();
        $data = ($partno) ? imap_fetchbody($mbox,$mid,$partno) : imap_body($mbox,$mid);  // simple
        if ($p->encoding==4)
         {
           $data = quoted_printable_decode($data);
         }
        else if ($p->encoding==3)
        $data = base64_decode($data);
        //   echo "---------<br>" . $data . "<br />--------------";
        // PARAMETERS    // get all parameters, like charset, filenames of attachments, etc.
        $params = array();
        if ($p->parameters)
        foreach ($p->parameters as $x)
            $params[strtolower($x->attribute)] = $x->value;
        if ($p->dparameters)
        foreach ($p->dparameters as $x)
            $params[strtolower($x->attribute)] = $x->value;

        // ATTACHMENT    // Any part with a filename is an attachment,
        // so an attached text file (type 0) is not mistaken as the message.
        if ($params['filename'] || $params['name']) {
        $partid = htmlentities($p->id,ENT_QUOTES);

           // filename may be given as 'Filename' or 'Name' or both
        $filename = ($params['filename'])? $params['filename'] : $params['name'];
        // filename may be encoded, so see imap_mime_header_decode()
         $attachments[$filename] = $data;  // this is a problem if two files have same name
        //store id and filename in array
        $image[$key] = $filename;

        }
        //save the attachments in the directory
        foreach( $attachments as $key => $val){
			//echo $key . "<br />";
          $fname = $key;
          
          $new_path = home_from_email($e_mail);
         // echo $new_path;
          if ($new_path == $e_mail)
           $fp = fopen("$path/$e_mail/$fname","w");
          else
           {
			if (!file_exists($new_path."/files/email upload/"))
			 mkdir($new_path."/files/email upload/");   
            $fp = fopen($new_path."/files/email upload/$fname","w");
           }
          fwrite($fp, $val);
          fclose($fp);
        }
            // TEXT
            if ($p->type==0 && $data) {
            // Messages may be split in different parts because of inline attachments,   // so append parts together with blank row.
            if (strtolower($p->subtype)=='plain')
                $plainmsg .= trim($data)."\n\n";
            else
                //preg_match_all('/<img[^>]+>/i',$data, $result);
                $htmlmsg .= $data."<br><br>";
                $charset = $params['charset'];  // assume all parts are same charset
            }

        // There are no PHP functions to parse embedded messages, so this just appends the raw source to the main message.
        else if ($p->type==2 && $data) {
        $plainmsg .= $data."\n\n";
        }
        // SUBPART RECURSION
        if ($p->parts) {
        foreach ($p->parts as $partno0=>$p2)
            getpart($mbox,$mid,$p2,$partno.'.'.($partno0+1),$store_att);  // 1.2, 1.2.1, etc.
        }
    }

    $attachments = array();
    $num_msg = imap_num_msg($mbox);
    echo "numero messaggi: ".$num_msg."<br />";
    if($num_msg>0) {
      for ($i = 1;$i<=$num_msg;$i++)
        {
		  
          getmsg($mbox,$i);
         
         imap_delete($mbox,$i); 
         imap_expunge($mbox);

        }  
    }

    //imap_delete and imap_expunge are used to delete the mail after fetching....Uncomment it if you want to delete the mail from mailbox
    imap_close($mbox);

}else { exit ("Can't connect: " . imap_last_error() ."\n");  echo "FAIL!\n";  };

?>
