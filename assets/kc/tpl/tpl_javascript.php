<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery.rightClick.js" type="text/javascript"></script>
<script src="js/jquery.drag.js" type="text/javascript"></script>
<script src="js/helper.js" type="text/javascript"></script>

<script src="js/browser/joiner.php" type="text/javascript"></script>
<script src="js_localize.php?lng=<?php echo $this->lang ?>" type="text/javascript"></script>
<script src="js/jquery.blockUI.js"></script>

<!--	<script src="../js/vendor/plugins.js"></script>
	<script src="../js/vendor/modernizer.js"></script>
    <script src="../js/sly.js" type="text/javascript"></script>
	<script src="../js/horizontal.js"></script>
<link rel="stylesheet" href="../css/horizontal.css">
<link rel="stylesheet" href="../css/normalize.css">
	-->
	
 <script type="text/javascript" src="../intro/intro.js"></script>

<?php IF (isset($this->opener['TinyMCE']) && $this->opener['TinyMCE']): ?>
<script src="<?php echo $this->config['_tinyMCEPath'] ?>/tiny_mce_popup.js" type="text/javascript"></script>
<?php ENDIF ?>
<?php IF (file_exists("themes/{$this->config['theme']}/init.js")): ?>
<script src="themes/<?php echo $this->config['theme'] ?>/init.js" type="text/javascript"></script>
<?php ENDIF ?>
<script type="text/javascript">
browser.version = "<?php echo self::VERSION ?>";
browser.support.chromeFrame = <?php echo (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), " chromeframe") !== false) ? "true" : "false" ?>;
browser.support.zip = <?php echo (class_exists('ZipArchive') && !$this->config['denyZipDownload']) ? "true" : "false" ?>;
browser.support.check4Update = <?php echo ((!isset($this->config['denyUpdateCheck']) || !$this->config['denyUpdateCheck']) && (ini_get("allow_url_fopen") || function_exists("http_get") || function_exists("curl_init") || function_exists('socket_create'))) ? "true" : "false" ?>;
browser.lang = "<?php echo text::jsValue($this->lang) ?>";
browser.type = "<?php echo text::jsValue($this->type) ?>";
browser.theme = "<?php echo text::jsValue($this->config['theme']) ?>";
browser.access = <?php echo json_encode($this->config['access']) ?>;
browser.dir = "<?php echo text::jsValue($this->session['dir']) ?>";
browser.uploadURL = "<?php echo text::jsValue($this->config['uploadURL']) ?>";
browser.thumbsURL = browser.uploadURL + "/<?php echo text::jsValue($this->config['thumbsDir']) ?>";
<?php IF (isset($this->get['opener']) && strlen($this->get['opener'])): ?>
browser.opener.name = "<?php echo text::jsValue($this->get['opener']) ?>";
<?php ENDIF ?>
<?php IF (isset($this->opener['CKEditor']['funcNum']) && preg_match('/^\d+$/', $this->opener['CKEditor']['funcNum'])): ?>
browser.opener.CKEditor = {};
browser.opener.CKEditor.funcNum = <?php echo $this->opener['CKEditor']['funcNum'] ?>;
<?php ENDIF ?>
<?php IF (isset($this->opener['TinyMCE']) && $this->opener['TinyMCE']): ?>
browser.opener.TinyMCE = true;
<?php ENDIF ?>
browser.cms = "<?php echo text::jsValue($this->cms) ?>";
_.kuki.domain = "<?php echo text::jsValue($this->config['cookieDomain']) ?>";
_.kuki.path = "<?php echo text::jsValue($this->config['cookiePath']) ?>";
_.kuki.prefix = "<?php echo text::jsValue($this->config['cookiePrefix']) ?>";
$(document).ready(function() {
    browser.resize();
    browser.init();
    $('#all').css('visibility', 'visible');
    $('#secure').css('visibility', 'hidden');
    var ret = check_email();
    if (ret==0)
     check_nofile();
     
  // load_img();
    
 });
$(window).resize(browser.resize);







var notif = '';
var old_notif = '';
var non_rompere = 0;
var gallery = 0;


setInterval(check_notification,5000);
setInterval(check_notification_owr,35000);
//setTimeout(load_img,3000);



function load_img()
{
	//alert('load_img');
	var dvImages = $("img[id^='thumb_']");
	//alert(dvImages.length);
	$.each(dvImages, function(index){
      //alert();
      
      //$(liImages[index]).attr('src', $(this).attr('src'));
      
      if (window["localStorage"]) 
       {
		  //alert('locals');   
          
          var value = localStorage.getItem($("#" + dvImages[index].id).attr('data-src'));
          //alert('key; ' + $("#img_" + index).attr('alt') + ' val:' + value);
          //alert(value);
          if (value != null)
	        {
              console.log('load localy'); 
              $("#" + dvImages[index].id).attr('src',value);
		    }
          else
           {
			  console.log('load remote');  
			  // alert("write: " + "key: img_" + index + 'value: ../img_my.php?fn='+ $("#img_" + index).attr('alt'));
			  // alert('save localy');
			   //localStorage.setItem("img_" + index,'../img_my.php?fn='+ $("#img_" + index).attr('alt'));
               $("#" + dvImages[index].id).attr('src','../usr_img.php?fn='+ $("#" + dvImages[index].id).attr('data-src') + '&c=1&s=100');
			   
			   $("#" + dvImages[index].id).load(function(){
                
                //alert('.load()');
			   	var canvas = document.createElement("canvas");
				canvas.width = this.width;
				canvas.height = this.height;
				
				var ctx = canvas.getContext("2d");
				ctx.drawImage(this, 0, 0);
				try 
					{
//					  if ($("#" + dvImages[index].id).attr('data-ext') == 'jpg')	
						localStorage[$("#" + dvImages[index].id).attr('data-src')]=canvas.toDataURL("image/jpg");
					  //  console.log('write ls: ');
					}
				catch(e)
					{
						console.log(e.code);
					//	$("#" + dvImages[index].id).attr('src','../usr_img.php?fn='+ $("#" + dvImages[index].id).attr('data-src') + '&c=1&s=100');
					}	

				});
			   	
			   	
		   }  
       
       
       }
      else  
       {
		 //  alert('no local storage');
         $("#" + dvImages[index].id).attr('src','../usr_img.php?fn='+ $("#" + dvImages[index].id).attr('data-src') + '&c=1&s=100');
       }  
    });



	
//	alert('load');
}










function set_email()
{
	var email = document.getElementById('set_email').value;
	var param = "e=" + email;
	var res = aPost("../callback/set_email.php",param);
	//alert(res);
	//check_email();
	close(); 
}

function check_email()
{
	var param = '';
	var res = aPost("../callback/have_email.php",param);
	//alert(res);
    if (res == '')
     {
		non_rompere = 1;
		$.blockUI({ message: "<div  style='background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:pointer;width:100%;height:100%;'  id='nomail'><a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close()'  onclick='return true'><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a><br /><div class='row-fluid'><div class='span12'><h2>Non hai ancora inserito il tuo indirizzo email</h2></div></div> <div class='row-fluid'><div class='span12'><hr /></div></div> <div class='row-fluid'><div class='span12'><strong>Perché è importante?</strong></div></div> <div class='row-fluid'><div class='span12'>Via Mail ti invieremo la password generata per accedere al tuo MySite e per accedere via Android app.</div><div class='row-fluid'><div class='span12'><hr /></div></div> <div class='row-fluid'><div class='span6'>Inserisci indirizzo email</div><div class='span4'><input type='text' id='set_email'></div><div class='span2'><button onclick=set_email()>Inserisci</button></div></div></div> </div>"
		, css: { 
   		height: ($(window).height() - 150) +'px',
		width: ($(window).width()/2) + 'px',
		top: "75px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: (($(window).width()/2)/2) + "px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
	  var ret = 1;	 
	 }
	else
	 var ret=0;
return ret;	  
}

function check_nofile()
{
	var param = '';
	var res = aPost("../callback/have_nofile.php",param);
	//if ('<?php echo $_SESSION['username']?>' == 'yellowelise')
	// alert(res);
    var iframe= "<iframe style='width:100%;height:"+($(window).height() - 280)+"px;' frameborder=0 src='https://www.crypt2share.com/faq'>";
    if (res < 6000)
     {
		non_rompere = 1;
		$.blockUI({ message: "<div  style='background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:pointer;width:100%;height:100%;'  id='nomail'><a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close()'  onclick='return true'><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a><br />    <div class='row-fluid'><div class='span12'><h2>Benvenuto su Crypt2Share.</h2><h6>Qui puoi imparare ad usare al meglio la piattaforma!</h6></div></div> <div class='row-fluid'><div class='span12'> "+iframe+" </div></div>   </div>"
		, css: { 
   		height: ($(window).height() - 150) +'px',
		width: ($(window).width() - 150) + 'px',
		top: "75px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "75px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
		 
	 }
}


function change_lang()
{
	window.location.href = "<?php echo $_SESSION['app_address'] . "kc/browse.php?lang="?>" + $("#language option:selected").val();
}


function startmq(ut)
{
	$('#mq_' +ut).attr('scrollamount','4');
	//alert(ut);
}
function stopmq(ut)
{
	$('#mq_' +ut).attr('scrollamount','1');
	//alert('out: ' + ut);
}


function show_mysite()
{
	window.open("<?php echo $_SESSION['mysite_address'] . $_SESSION['username']?>");
}

function nuova_cartella(path)
{
    non_rompere = 1;
	//alert(path);
	var dir = prompt("<?php echo $this->label("Insert folder name") ?>","<?php echo $this->label("New folder") ?>"); 
    if (dir)
     {
		 if ((dir != '.')&&(dir != '..')&&(dir != 'files'))
		  {
    		var $param = "d=" + path + "/" + dir;
	    	//alert($param);
		    var res = aPost("../callback/create_folder.php",$param);
		    if (res != '')
		     alert(res);
			window.location.reload();   
		  }
	 }
	 
		non_rompere = 0;
}


function crypt()
{
	non_rompere = 1;
	var pass =  document.getElementById("cry_pass").value; 
    var f = document.getElementById("filename").value;
    if (pass)
     {
		document.getElementById("crypting").innerHTML = "<a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close()'  onclick='return false'><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a><br /><h3><?php echo $this->label("Waiting...") ?></h3><br /><img style='width:50%;height:50%;' src='themes/oxygen/img/wait.gif' />";
		var $param = "f=" + f + "&p=" + pass;
		//alert($param);
		var res = aPost("../callback/moveto_secure.php",$param);
		if (res != '')
		 alert("Criptaggio completo\nDimensione: " + res + " Sec.");
		//e.stopPropagation();
		//e.cancelBubble = true;
		 parent.window.location.reload();
      }
		$.unblockUI();
		non_rompere = 0;	
 $('#chiudi').attr('onclick','return true');
}


function crypt_m()
{
	non_rompere = 1;
	var pass =  document.getElementById("cry_pass_m").value; 
    var fs = document.getElementById("filename_m").value;    
    var d = document.getElementById("dir_m").value;
    var mess = 'Criptaggio completo\n';
    var f = fs.split(',');
    for (j=0;j<f.length;j++)
    {
    if (pass)
     {
		document.getElementById("crypting").innerHTML = "<a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close()'  onclick='return false'><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a><br /><h3><?php echo $this->label("Waiting...") ?></h3><br /><img style='width:50%;height:50%;' src='themes/oxygen/img/wait.gif' />";
		var $param = "f=" + escape(d + "/" +f[j]) + "&p=" + pass;
//		alert($param);
		var res = aPost("../callback/moveto_secure.php",$param);
		if (res != '')
		 mess += f[j] + " dimensione: " + res + " Sec.\n";
		//e.stopPropagation();
		//e.cancelBubble = true;
      }
     else
      { 
        alert("Invalid pass");
        exit;
      } 
	 }
    if (mess == 'Criptaggio completo\n') 
	  {
	   parent.window.location.reload();
	  }
	else
	 {   
       alert(mess);
	   parent.window.location.reload();
	   	 
	   $.unblockUI();
	   non_rompere = 0;	
       $('#chiudi').attr('onclick','return true');
     }
}



function moveto_secure(f)
{
		non_rompere = 1;
		$.blockUI({ message: "<div style='background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:pointer;width:100%;height:100%;' id='crypting'><a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close()'  onclick='return true'><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a><br /><input type='hidden' id='filename' value='"+f+"'><h3><?php echo $this->label("Insert crypting password:") ?></h3> <br /><input id='cry_pass' type='password' /><button class='btn' style='vertical-align:top;' onclick=crypt() ><?php echo $this->label("Crypting") ?></button></div>"
		, css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width()/2) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: (($(window).width()/2)/2) + "px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
}


function moveto_secure_m(d,f)
{
		non_rompere = 1;
		$.blockUI({ message: "<div id='crypting'><a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close()'  onclick='return true'><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a><br /><input type='hidden' id='filename_m' value='"+f+"'><input type='hidden' id='dir_m' value='"+d+"'><h3><?php echo $this->label("Insert crypting password:") ?></h3> <br /><input id='cry_pass_m' type='password' /><button class='btn' style='vertical-align:top;' onclick=crypt_m() ><?php echo $this->label("Crypting") ?></button></div>"
		, css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width()/2) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: (($(window).width()/2)/2) + "px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
}
function mysite_m()
{
	non_rompere = 1;
    var fs = document.getElementById("filename_m").value;    
    var d = document.getElementById("dir_m").value;
    var f = fs.split(',');
    for (j=0;j<f.length;j++)
    {
		document.getElementById("copytomysite").innerHTML = "<a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close()'  onclick='return false'><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a><br /><h3><?php echo $this->label("Waiting...") ?></h3><br /><img style='width:50%;height:50%;' src='themes/oxygen/img/wait.gif' />";
		var $param = "f=" + escape(d + "/" +f[j]);// + "&p=" + pass;
//		alert($param);
		var res = aPost("../callback/copy_to_mysite.php",$param);
	 }
   $.unblockUI();
}

function copy_to_mysite_m(d,f)
{
	// alert(d);
	// alert(f);

   // var ff = f.split(',');
    var list = '';
    for (j=0;j<f.length;j++)
      {
		  list += d + "/" +f[j] + "<br />";
	  }
	  
		non_rompere = 1;
		//<div id='copytomysite' style='overflow:auto;background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:pointer;width:100%;height:100%; ><a style='float:left;height:20px;top:4px;' id='chiudi' onclick=close()><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a>
		$.blockUI({ message: "<div style='background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:pointer;width:100%;height:100%;overflow-y:auto;' id='copytomysite'><a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close()'  onclick='return true'><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a><br /><input type='hidden' id='filename_m' value='"+f+"'><input type='hidden' id='dir_m' value='"+d+"'><h3><?php echo $this->label("Copy to MySite:") ?></h3> <br /><h5>"+list+"</h5><br /><br /><button style='vertical-align:top;width:150px;height:40px;' onclick=mysite_m() ><?php echo $this->label("Copy to Mysite") ?></button><br /></div>"
		, css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width()/2) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: (($(window).width()/2)/2) + "px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
}


function create_pu(dir)
{
  var pass= $('#pupass').val();
  var repass= $('#repupass').val();
  if (pass == repass)
   {
	   //alert(dir + " OK!");
       var param = "dir=" + escape(dir) + "&p=" + pass;
       var resu = aPost("../callback/public_upload.php",param);
       var $param = "e=<?php echo $_SESSION['email']?>&s=Public Upload&t=ciao, <?echo $_SESSION['username']?> hai deciso di permettere l'upload (nella cartella '"+dir+"')\n a chiunque sia in possesso del codice:\n "+resu+" \n e della eventuale password da te scelta.\nIl link da inviare è il seguente: &l=<? echo $_SESSION['public_address'];?>";
	   //alert($param);	
	   res = aPost("../callback/sendMail.php",$param);
	   var list_public = aPost("../callback/get_list_public_upload.php","");
	   document.getElementById("public_list").innerHTML = list_public;
   }
  else 
   {
	   alert("Le password non coincidono.");
   }
  
}

function get_special()
{
 return "#Chrome EXT#Documents#Images#Videos#Musics#";
}
function get_MySite()
{
 return "#mysite#";
}

function get_Public()
{
  var param = "";
  var res = aPost("../callback/get_public_upload.php",param);	
 //alert(res);
 return res;
}

function delete_public(dir,divid)
{
	//alert(dir);
	aPost("../callback/delete_public.php","d=" + dir);
	$("#cont_"+divid).remove();
	$("#hr_"+divid).remove();
	
}

function create_public_upload(dir)
{
	//alert(dir);s
   var list_public = aPost("../callback/get_list_public_upload.php","");

	var msg = "<div style='background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:default;width:100%;height:100%;' id='public_upload'><a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close_hr()'  onclick='return true'><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a><br /><div id='public_upload_content' style='height:45%;'><h3>Permetti ai tuoi amici di caricare i file nel tuo Crypt2Share</h3><h5>Aggiunta ai termini di utilizzo</h5><p>Confermando con il tasto conferma accetti di permettere ai tuoi amici di caricare dei file nel tuo ambiente privato (nessuno tranne te potrà vedere i file caricati),<br />Crypt2Share non è responsabile per eventuali file illegali od offensivi che potresti trovare, <br />Puoi rimuovere in qualsiasi istante la condivisione di una cartella utilizzando Elimina Condivisione nella lista qui sotto. </p><h5>Hai scelto di permettere l'upload da parte di terzi nella cartella:</h5><h5>"+dir+"</h5><h5>Puoi proteggere l'upload impostando una password (consigliato)</h5><input placeholder='password' type='password' id='pupass'>&nbsp;<input  placeholder='ripeti password'  type='password' id='repupass'><br /><button onclick=create_pu('"+dir+"')>CONFERMA</button></div><div id='public_list' style='height:45%;overflow-y:auto;'>"+list_public+"</div></div>";
	//alert(msg);
		non_rompere = 1;
		$.blockUI({ message: msg  
		, css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width() - 50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
  //alert(document.getElementById("public_upload_content").style.height);	
	
}

function upload(dir)
{
	//alert(dir);
	var msg = "<div style='background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:pointer;width:100%;height:100%;' id='uploading'><a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close_r()'  onclick='return true'><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a><br /><iframe frameborder=0 style='position:absolute;left:0px;top:40px;width:100%;height:90%;' src='../plupload/examples/jquery/jupload.php?p="+dir+"'></iframe></div>";
	//alert(msg);
		non_rompere = 1;
		$.blockUI({ message: msg  
		, css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width() - 50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
}

function invita()
{
	//alert(dir);
	var msg = "<div style='background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:pointer;width:100%;height:100%;' id='tellfriends' ><a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close()'  onclick='return true'><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a><br /><iframe frameborder=0 style='position:absolute;left:0px;top:40px;width:100%;height:90%;' src='../invita.php'></iframe></div>";
	//alert(msg);
		non_rompere = 1;
		$.blockUI({ message: msg  
		, css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width() - 50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
}

function decrypt(id)
{
	non_rompere = 1;	
	var pass = document.getElementById("dec_pass").value; 
	if (pass)
	 {
		 document.getElementById("decrypting").innerHTML = "<a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close()'  onclick='return false'><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a><br /><h3><?php echo $this->label("Waiting...") ?></h3><br /><img style='width:50%;height:50%;' src='themes/oxygen/img/wait.gif' />";
		var $param = "id=" + id + "&p=" + pass;
		var res = aPost("../callback/moveto_unsecure.php",$param);
		if (res != '')
		 {
//		   alert(res);
           document.getElementById("decrypting").innerHTML = '<div style="background: url(../images/metallo.png) repeat scroll 0 0 transparent;width:100%;height:100%; cursor:pointer;" id="decrypting"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a><br /><h3>'+res+'</h3><h3><?php echo $this->label("Insert decrypting password:") ?></h3> <br /><input id="dec_pass" type="password" /><button class="btn" style="vertical-align:top;" onclick=decrypt("'+id+'")><?php echo $this->label("Decrypting") ?></button></div>';
	     }
	    else 
	     {
		 //window.location.reload();
		    close_r();
		    document.getElementById("crfile_" + id).style.visibility = "hidden";
		 }   
     }
	//	$.unblockUI();
       $('#chiudi').attr('onclick','return true');
       //$('#chiudi_l').attr('onclick','return true');
     //  	non_rompere = 0;
}

function decrypt_shared(id)
{
	non_rompere = 1;	
	var pass = document.getElementById("dec_pass").value; 
	if (pass)
	 {
		 document.getElementById("decrypting").innerHTML = "<a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close()'  onclick='return false'><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a><br /><h3><?php echo $this->label("Waiting...") ?></h3><br /><img style='width:50%;height:50%;' src='themes/oxygen/img/wait.gif' />";
		var $param = "id=" + id + "&p=" + pass;
		var res = aPost("../callback/decrypt_copy.php",$param);
		if (res != '')
		 {
		   //alert(res);
           document.getElementById("decrypting").innerHTML = '<div style="background: url(../images/metallo.png) repeat scroll 0 0 transparent;width:100%;height:100%; cursor:pointer;" id="decrypting"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a><br /><h3>'+res+'</h3><h3><?php echo $this->label("Insert decrypting password:") ?></h3> <br /><input id="dec_pass" type="password" /><button class="btn" style="vertical-align:top;" onclick=decrypt_shared("'+id+'")><?php echo $this->label("Decrypting") ?></button></div>';
	     }
	    else 
		 window.location.reload();
     }
	//	$.unblockUI();
       $('#chiudi').attr('onclick','return true');
       //$('#chiudi_l').attr('onclick','return true');
     //  	non_rompere = 0;
}

function shared_decrypt(id)
{
	non_rompere = 1;	
		$.blockUI({ message: '<div style="background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:pointer;" id="decrypting" ><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a><br /><h3><?php echo $this->label("Insert decrypting password:") ?></h3> <br /><input id="dec_pass" type="password" /><button class="btn" style="vertical-align:top;" onclick=decrypt_shared("'+id+'")><?php echo $this->label("Decrypting") ?></button></div>', css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width() -50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
}
function moveto_unsecure(id)
{
		non_rompere = 1;
		$.blockUI({ message: '<div style="background: url(../images/metallo.png) repeat scroll 0 0 transparent;width:100%;height:100%; cursor:pointer;" id="decrypting" ><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a><br /><h3><?php echo $this->label("Insert decrypting password:") ?></h3> <br /><input id="dec_pass" type="password" /><button class="btn" style="vertical-align:top;" onclick=decrypt("'+id+'")><?php echo $this->label("Decrypting") ?></button></div>', css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width() -50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
}

function aPost(url, parameters)
{
	//	non_rompere = 1;
		if (window.XMLHttpRequest) { AJAX=new XMLHttpRequest(); } 
		else {  AJAX=new ActiveXObject("Microsoft.XMLHTTP");  }
		
		if (AJAX) {
					AJAX.open("POST", url, false);
					AJAX.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					AJAX.send(parameters);
					
					return AJAX.responseText;                                         
		} else { return false; }   
	//		non_rompere = 0;  
}  


function delete_file(id)
{
non_rompere = 1;
 var answer = confirm("<?php echo $this->label("Delete file: ") ?>"+id+" <?php echo $this->label(" permanently?") ?>")
	if (answer){
	var $param = "id=" + id;
	var res = aPost("../callback/delete_file.php",$param);
 	if (res != '')
     alert(res);
    close_r();
}
	non_rompere = 0;
}


function share_file(id)
{
		non_rompere = 1;
 var answer = confirm("<?php echo $this->label("Sharing file: ") ?> "+id+"?")
	if (answer){
	  window.open("../share_file.php?f=" + id,"_blank","height=280,width=600,status=no,location=no,menubar=no,toolbar=no");	 
}
	non_rompere = 0;
}

function secure()
{
if (document.getElementById("secure").style.visibility == "visible")
 {	
    non_rompere = 1;
	var $param = "";
	var res = aPost("../callback/l_secure.php",$param);
	document.getElementById("secure").innerHTML = res;
	non_rompere = 0; 
 }
}

function d_secure(d)
{
		non_rompere = 1;
	var $param = "d="+d;
	var res = aPost("../callback/l_secure.php",$param);
	document.getElementById("secure").innerHTML = res;
		non_rompere = 0; 
}

function share_div(id)
{
		non_rompere = 1;
  var $param = "id=" + id;
  document.getElementById("sharing").innerHTML = "<a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close()'  onclick='return true'><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a><br /><iframe frameborder='0' src='../share.php?id=" + id + "&d=n' style='width:100%;height:90%;'></iframe>";	 
	//non_rompere = 0;
}

function drop_friends()
{
	var $param = "";
	var res = aPost("../callback/my_friends.php",$param);	
	//alert(res);
	return res;
	 
}
// v da tradurre
function copy(filename)
{
		non_rompere = 1;
	var id_friend = document.getElementById("friends").value;

	var $param = "idf=" + id_friend + "&f=" + filename;
	var res = aPost("../callback/copy_file.php",$param);	
    if (res != '')
     {
       var $param = "e=" + res + "&s=Un file per te&t=ciao, <?echo $_SESSION['username']?> ha copiato il file: "+filename+" \nnel tuo ambiente lo trovi in (ricevuti/<?echo $_SESSION['username']?>).&l=" + "<? echo $_SESSION['site_address'];?>";
		  //alert($param);	
	   res = aPost("../callback/sendMail.php",$param);
		 
	 }
      
  document.getElementById("coping").innerHTML = "<a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close()'  onclick='return true'><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a><br /><h3>"+decodeURI( unescape(filename))+" è stato copiato nell'ambiente di:<br /> "+$("#friends option:selected").html()+"</h3></iframe>";	 
	//alert(id_friend + " - " +filename);
	
}

function copy_m(f,d)
{
	non_rompere = 1;
	var id_friend = document.getElementById("friends").value;
    
    var fs = unescape(f);
    var filename = fs.split(",");
   // alert(filename.length);
	for (j=0;j<filename.length;j++)
    	{
		  var $param = "idf=" + id_friend + "&f=" + d + "/" + filename[j];
		 // alert($param);
		  var res = aPost("../callback/copy_file.php",$param);	
        } 
        
    var $param = "e=" + res + "&s=Alcuni files per te&t=ciao, <?echo $_SESSION['username']?> ha copiato alcuni files nel tuo ambiente lo trovi in (ricevuti/<?echo $_SESSION['username']?>).&l=" + "<? echo $_SESSION['site_address'];?>";
	//alert($param);	
    res = aPost("../callback/sendMail.php",$param);

	    var files = '';
	    for (j=0;j<filename.length;j++)
	     {
	      files += unescape(filename[j]) + "<br />";
	     // alert(files);
	     }
    
     document.getElementById("coping").innerHTML = "<a style='position:absolute;height:20px;left:4px;top:4px;' id='chiudi' href='javascript:close()'  onclick='return true'><img src='themes/oxygen/img/icons/close_j.png' style='vertical-align:middle'></a><br /><h4>"+ files +" copiati nell'ambiente di:<br /> "+$("#friends option:selected").html()+"</h4></iframe>";	 
	//alert(id_friend + " - " +filename);
	
}

function copy_to_friend(filename)
{
		non_rompere = 1;
	//decode_base64(filename)
        var thumb = "<img src='../usr_img.php?fn="+escape(filename)+"&s=150' />";
 		$.blockUI({ message: '<div id="coping" style="background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:default;width:100%;height:100%;"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a><br />'+thumb+'<h3>'+unescape(filename)+'<br />Scegli amico:</h3> <br />'+drop_friends()+'<br /><br /><button onclick=copy(\''+escape(filename)+'\')>Copia</button></div>', css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width() -50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });

}
function copy_to_friend_m(d,f)
{
		non_rompere = 1;
	//decode_base64(filename)
	    var filename = '<table style="margin-left: auto;margin-right: auto;">';
	    for (j=0;j<f.length;j++)
	     {
	      filename += "<tr><td><img src='../usr_img.php?fn="+d+"/"+f[j]+"&s=50&c=1' /></td><td><h5>" + unescape(f[j]) + "</h5></td></tr>";
	     }
	     filename += "</table>";
 		$.blockUI({ message: '<div id="coping" style="overflow:auto;background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:default;width:100%;height:100%;"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a><br />'+filename+'<br /><h4>Scegli amico:</h4> <br />'+drop_friends()+'<br /><br /><button onclick="copy_m(\''+escape(f)+'\',\'' + escape(d) + '\')">Copia</button></div>', css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width() -50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });

}

function h_delete_not(id)
{
	//alert(id);
	var param = "id=" + id;
	aPost("../callback/h_delete_not.php",param);
	view_notify();
}

function view_notify()
{
		non_rompere = 1;
	//decode_base64(filename)
 		$.blockUI({ message: '<div id="notify" style="background: url(../images/metallo.png) repeat scroll 0 0 transparent;cursor:default;width:100%;height:100%;"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a><br /><div id="view_notify" style="position:absolute;top:30px;left:5px;overflow:auto" ></div></div>', css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width() -50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
 document.getElementById("view_notify").style.width = $(window).width() - 110 + "px";
 document.getElementById("view_notify").style.height = $(window).height() - 160 + "px";


var res = aPost("../callback/view_notify.php");
document.getElementById("view_notify").innerHTML = res;
}


function share(id,filename) 
{
		non_rompere = 1;
		$.blockUI({ message: '<div id="sharing" style="background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:pointer;width:100%;height:100%;"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a><br /><h3>Condividi il file:</h3> <br /><h4>'+decode_base64(filename)+'<h4><br /><br /><button onclick="share_div('+id+')">Condividi</button></div>', css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width() -50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
			

		 }  });
	
	
	
	
}

function text_edit(filename) 
{
	//alert(filename);
	//var answer = confirm("Vuoi vedere il file: "+filename+"?")
	//if (answer){
	//  window.open("../video/play.php?f=" + filename,"_blank","height=480,width=800,status=no,location=no,menubar=no,toolbar=no");	 
		non_rompere = 1;
		$.blockUI({ message: '<div id="editor" style="background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:pointer;margin:0px;width:100%;height:100%;"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a><br /><iframe id="text_editor" style="position:absolute;top:30px;left:5px;" frameborder=0 src="../tmce/tmc/examples/index.php?fn=' + filename + '"></iframe></div>', css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width() -50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
 
 document.getElementById("text_editor").style.width = $(window).width() - 110 + "px";
 document.getElementById("text_editor").style.height = $(window).height() - 160 + "px";

//}
}


function play_video(filename) 
{
	//var answer = confirm("Vuoi vedere il file: "+filename+"?")
	//if (answer){
	//  window.open("../video/play.php?f=" + filename,"_blank","height=480,width=800,status=no,location=no,menubar=no,toolbar=no");	 
		non_rompere = 1;
		$.blockUI({ message: '<div id="player" style="background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:pointer;margin:0px;width:100%;height:100%;"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a><br /><iframe id="player_video" style="position:absolute;top:30px;left:5px;" frameborder=0 src="../video/play.php?f=' + filename + '&w='+($(window).width() - 120)+'&h='+($(window).height() - 170)+'"></iframe></div>', css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width() -50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
 document.getElementById("player_video").style.width = $(window).width() - 110 + "px";
 document.getElementById("player_video").style.height = $(window).height() - 160 + "px";

//}
}

function play_mp3(filename) 
{
	//var answer = confirm("Vuoi vedere il file: "+filename+"?")
	//if (answer){
	//  window.open("../video/play.php?f=" + filename,"_blank","height=480,width=800,status=no,location=no,menubar=no,toolbar=no");	 
		non_rompere = 1;
		$.blockUI({ message: '<div id="player" style="background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:pointer;margin:0px;width:100%;height:100%;"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a><br /><iframe id="player_video" style="position:absolute;top:30px;left:5px;" frameborder=0 src="../video/play.php?f=' + filename + '&w='+($(window).width() - 120)+'&h='+($(window).height() - 170)+'"></iframe></div>', css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width() -50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
 document.getElementById("player_video").style.width = $(window).width() - 110 + "px";
 document.getElementById("player_video").style.height = $(window).height() - 160 + "px";

//}
}


function download_cry(id,filename) 
{
	var answer = confirm("Vuoi scaricare il file criptato: "+decode_base64(filename)+"?")
	if (answer){
	
	var $param = "id=" + id;
	  window.open("../secure_download.php?id=" + id,"_blank","height=480,width=800,status=no,location=no,menubar=no,toolbar=no");	 

}
}
function delete_secure(id,filename)
{
	var answer = confirm("Eliminare il file: "+decode_base64(filename)+"?")
	if (answer){
	
	var $param = "id=" + id;
	var res = aPost("../callback/delete_secure.php",$param);
	if (res != '')
	alert(res);
    document.getElementById("crfile_" + id).style.visibility = "hidden";

	// window.location.reload();
	
}
}


function friendship()
{
		non_rompere = 1;
		$.blockUI({ message: '<div id="friendship" style="background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:pointer;width:100%;height:100%;"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a><br /><iframe id="friend_cont" style="position:absolute;top:30px;left:5px;" frameborder=0 src="../friends.php"></iframe></div>', css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width() -50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });
	
document.getElementById("friend_cont").style.width = $(window).width() - 65 + "px";
document.getElementById("friend_cont").style.height = $(window).height() - 120 + "px";

}

function logout()
{
var $param = "";
var res = aPost("../callback/signout.php",$param);
//alert(res);
 window.location.reload();
}

function decode_base64(s) {
    var e={},i,k,v=[],r='',w=String.fromCharCode;
    var n=[[65,91],[97,123],[48,58],[43,44],[47,48]];

    for(z in n){for(i=n[z][0];i<n[z][1];i++){v.push(w(i));}}
    for(i=0;i<64;i++){e[v[i]]=i;}

    for(i=0;i<s.length;i+=72){
    var b=0,c,x,l=0,o=s.substring(i,i+72);
         for(x=0;x<o.length;x++){
                c=e[o.charAt(x)];b=(b<<6)+c;l+=6;
                while(l>=8){r+=w((b>>>(l-=8))%256);}
         }
    }
    return r;
    }
function close()
{
	$.unblockUI();
	non_rompere = 0;
	gallery = 0;
}    
function close_hr()
{
 location.reload();
}    
function close_r()
{
        browser.refresh();
	$.unblockUI();
	non_rompere = 0;
        //return false;
}    

function check_notification()
{

 if (non_rompere == 0)
 {
 var $param = "";
 notif = aPost("../callback/check.php",$param);
 if (notif != old_notif)
  {
 $.blockUI({ 
            message: notif, 
            fadeIn: 700, 
            fadeOut: 700, 
            
            showOverlay: false, 
            centerY: false, 
            css: { 
                cursor: 'default',
                width: '350px', 
                top: '10px', 
                left: '', 
                right: '10px', 
                border: 'none', 
                padding: '5px', 
                backgroundColor: '#000', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                opacity: .6, 
                color: '#fff' 
            } 
        }); 	  
   old_notif = notif;
  }
}
}

function check_notification_owr()
{
 var $param = "";
 notif = aPost("../callback/check.php",$param);
}


function notification_read(id)
{
	var $param = "id=" + id;
	var res = aPost("../callback/read_notif.php",$param);
	//check_notification();
 if (id != '-1')
  {	
    var d = document.getElementById("not_" + id);
    d.parentNode.removeChild( d ); 
  }
 else
  {
	  document.getElementById("notific").innerHTML = '';
  } 
}

function select_all()
{
	$("div[class^='file']").attr('class', 'file selected');
}

function refresh_button(file)
{
	document.getElementById("tb_mts").onclick = function () {
      moveto_secure(file);
    };
	document.getElementById("tb_ctf").onclick = function () {
      copy_to_friend(file);
    };
	document.getElementById("tb_fbs").onclick = function () {
      fbs_click(file,"Crypt2Share.com");
    };
}



function next_image(d,f)
{
    	document.getElementById("m_prev").src = '../images/tcfloading.gif';
    	document.getElementById("show_img").src = '../images/tcfloading.gif';
	    document.getElementById("m_next").src = '../images/tcfloading.gif';
       

        var $param = "f=" + escape(f) + "&d=" + escape(d) + "/";
        var list = aPost("../callback/list_images.php",$param);
        var arr_list = list.split(",");
	
	
	 
        var window_w = ($(window).width() - 80);
		var window_h = ($(window).height() - 140);
		var w_img = ((window_w / 4)*2);
		var h_img = window_h;	
	
    	document.getElementById("m_prev").src = '../usr_img.php?fn='+d+'/'+arr_list[0]+'&w='+(w_img/4)+'&h='+(h_img/2);
    	document.getElementById("show_img").src = '../usr_img.php?fn='+d+'/'+arr_list[1]+'&w='+w_img+'&h='+h_img;
	    document.getElementById("m_next").src = '../usr_img.php?fn='+d+'/'+arr_list[2]+'&w='+(w_img/4)+'&h='+(h_img/2);


	document.getElementById("show_img").onclick = function () {
      next_image(d,arr_list[1]);
    };

	document.getElementById("next_i").onclick = function () {
      next_image(d,arr_list[2]);
    };

	document.getElementById("prev_i").onclick = function () {
      next_image(d,arr_list[0]);
    };

	document.getElementById("tb_mts").onclick = function () {
      moveto_secure(d + "/" + arr_list[1]);
    };
	document.getElementById("tb_ctf").onclick = function () {
      copy_to_friend(d+"/" +arr_list[1]);
    };
	document.getElementById("tb_fbs").onclick = function () {
      fbs_click(d + "/" + arr_list[1],"Crypt2Share.com");
    };
 document.getElementById("file_info").innerHTML = file_info(d,arr_list[1]);
	//alert(res);
//	show_gallery(d,res);

}

function file_info(d,f)
{
  	var $param = "f=" + escape(f) + "&d=" + escape(d) + "/";
    var res = aPost("../callback/file_info.php",$param);
	var obj = eval('('+res+')');
	var fi = "<b>" + obj['filename'] + "</b> [<i>" + obj['size'] + "</i>] data ultima modifica:" + obj['last_modified'];
	return fi;
}

function toolbar(d,f)
{
	var res = '<div style="width:100%;"><button style="visibility:hidden;" id="tb_mts" onclick=moveto_secure(\'' + escape(d +'/'+ f)+'\') ><img src="../images/encrypt_ss.png"> Move to Secure</button>&nbsp;<button  style="visibility:hidden;" id="tb_fbs" onclick=fbs_click(\'' + escape(d +'/'+ f)+'\',\'Crypt2Share.com\') ><img src="../images/facebookshare.png"> Facebook share</button>&nbsp;<button  style="visibility:hidden;" id="tb_ctf" onclick=copy_to_friend(\'' + escape(d +'/'+ f)+'\') ><img src="../images/friends.png"> Copy to friend</button>&nbsp;</div>';
return res;
}

function show_gallery(d,f)
{
		non_rompere = 1;
		gallery = 1;
		var window_w = ($(window).width() - 80);
		var window_h = ($(window).height() - 140);
		
		$.blockUI({ message: '<div id="gallery" style="background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:pointer;width:100%;height:100%;"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close_r()"  onclick="return true"><img src="themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a>'+toolbar(d,f)+'<br /><iframe frameborder=0 style="width:'+window_w+'px;height:'+window_h+'px;" src="../sly/gallery.php?w='+window_w+'&h='+window_h+'&f='+escape(f)+'&d='+escape(d)+'"></div>', css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width() -50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });


	
}

function __show_gallery(d,f)
{
		non_rompere = 1;
		var window_w = ($(window).width() - 80);
		var window_h = ($(window).height() - 140);
		var w_img = ((window_w / 4)*2);
		var h_img = window_h;
		
        var $param = "f=" + escape(f) + "&d=" + escape(d) + "/";
        var list = aPost("../callback/list_images.php",$param);
        var arr_list = list.split(",");

        //alert(arr_list[1]); 
		$.blockUI({ message: '<div id="gallery" style="background: url(../images/metallo.png) repeat scroll 0 0 transparent; cursor:pointer;width:100%;height:100%;"><a style="position:absolute;height:20px;left:4px;top:4px;" id="chiudi" href="javascript:close()"  onclick="return true"><img src="themes/oxygen/img/icons/close_j.png" style="vertical-align:middle"></a>'+toolbar(d,f)+'<br /><ul style="list-style:none outside none"><li ><img style="position:absolute;left:10px;top:'+(($(window).height() - 140)/2)+'px" id="prev_i" onclick="next_image(\''+d+'\',\''+arr_list[0]+'\')" src="../images/prev_img.png" /> <img id="m_prev" style="position:absolute;left:110px;top:'+(h_img /4)+'px" src="../usr_img.php?fn='+d+'/'+arr_list[0]+'&w='+(w_img/4)+'&h='+(h_img/2)+'" />&nbsp;<img id=show_img onclick="next_image(\''+d+'\',\''+arr_list[1]+'\')" src="../usr_img.php?fn='+d+'/'+arr_list[1]+'&w='+w_img+'&h='+h_img+'" />&nbsp;<img style="position:absolute;right:110px;top:'+(h_img /4)+'px" id="m_next" src="../usr_img.php?fn='+d+'/'+arr_list[2]+'&w='+(w_img/4)+'&h='+(h_img/2)+'" />&nbsp;<img style="position:absolute;right:10px;top:'+(($(window).height() - 140)/2)+'px" id="next_i" onclick="next_image(\''+d+'\',\''+arr_list[2]+'\')" src="../images/next_img.png" /></li><li id="file_info">'+file_info(d,f)+'</li></ul></div>', css: { 
   		height: ($(window).height() - 50) +'px',
		width: ($(window).width() -50) + 'px',
		top: "25px", //(($(window).height() - $('#sharing').height()) / 2) + "px",
		left: "25px"// (($(window).width() - $('#sharing').width()) / 2) + "px"
		
		 }  });

	
}

function show_hide_crypted()
{
	if (document.getElementById("secure").style.visibility == "visible")
     {	
		 document.getElementById("secure").style.visibility = "hidden";
		 document.getElementById("link_crypted").innerHTML = browser.label("View Crypted file");
		 browser.resize();
     }
    else
     {
		 document.getElementById("link_crypted").innerHTML = browser.label("Hide Crypted file");
		 document.getElementById("secure").style.visibility = "visible";
		 secure();
		 browser.resize();
	 }
}

function fbs_click(u,t) {
    	var $param = "f=" + u;
	    var res = aPost("../callback/share.php",$param);
		
		//alert(res);
        window.open('http://www.facebook.com/sharer.php?u=' +
             encodeURIComponent(res) +
             '&t=' +
             encodeURIComponent(t),
             ' sharer', 'toolbar=0, status=0, width=626, height=536');
        return false;
}
</script>

