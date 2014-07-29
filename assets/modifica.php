<?php
session_start();
//ini_set('display_errors', 'Off');
//ini_set('display_startup_errors', 'Off');
//error_reporting(0);


include("class/mysql.class.php");

$_SESSION['path'] =  dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR;

$id_pro = $_GET['id'];
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 
 $db1->Open();
 $sql = "select * from progetti where idprogetti = '".$id_pro."'";
 //echo $sql."<br />";
 $result = $db1->QuerySingleRowArray($sql);
 $db1->Close();
 
 $idtipo = ($result['idtipologia']);
 $nome = ($result['nome']);
 $luogo = ($result['luogo']);
 $data_mese = ($result['data_mese']);
 $data_anno = ($result['data_anno']);
 $stato = ($result['stato']);
 $committente = ($result['committente']);
 $budget = ($result['budget']);
 $team = ($result['team']);
 $superficie = ($result['superficie']);
 $testo = ($result['testo']);
 $path = ($result['path']);
 
  




 function findexts($filename) 
 { 
 $filename = strtolower($filename) ; 
 //echo $filename."<br />";
 $exts = substr(strrchr($filename, '.'), 1);
/* $exts = preg_split("[/\\.]", $filename) ; 
 $n = count($exts)-1; 
 $exts = $exts[$n];*/ 
 //echo "estensione: " . $filename . " - " . $exts ."<br>";
 return $exts; 
 } 
 
 
 

function id_immagine($path)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 
 $db1->Open();
 $sql = "select idimmagini from immagini where path = '".$path."'";
 //echo $sql."<br />";
 $result = $db1->QueryArray($sql);
 $db1->Close();
 //print_r($result);
 return $result[0]['idimmagini'];
}


 
function immagini($directory,$ricorsiva) {
$size = 0;
$file_immagini = array();
$i = 0;    
$last_path = $directory;
if (file_exists($directory))
{
//echo $directory . "<br>";
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
       try {
         $ext = findexts($file);
       if (($ext == 'png') || ($ext == 'jpg') || ($ext == 'gif'))
	     {
           $file_immagini[$i]["path"] = str_replace("\\","/",$file);
		   $file_immagini[$i]["ext"] = $ext;
         //  $file_immagini[$i]["last_mod"] = date("d.m.y H:i",filemtime($file));
         //  $file_immagini[$i]["dim"] = format_bytes($file->getSize());
         //  $file_immagini[$i]["filename"] = basename($file);
         //  $file_immagini[$i]["realpath"] = $file;
         //  $file_immagini[$i]["onlypath"] = str_replace("/".$file_immagini[$i]["filename"],"",$file_immagini[$i]["realpath"]);
         //  $last_path = $file_immagini[$i]["onlypath"];
		 //  $file_immagini[$i]["resolution"] = resolution($file);
             $file_immagini[$i]["title"] = $dati_db['title']; 
             $file_immagini[$i]["description"] = $dati_db['description']; 

          $i += 1;  
         }
       
       }
catch (Exception $e) {}
    }

if (count($file_immagini) == 0)
{
 return false;
}
else { 
   return $file_immagini; 
} 
}
} 



function create_tipologia_drop_box($id)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 
 $db1->Open();
 $sql = "select idtipologia,tipologia,peso from tipologia order by peso";
 //echo $sql."<br />";
 $result = $db1->QueryArray($sql);
 $db1->Close();

 $drop = "<select id='db_tipologie'>";
 for ($i=0;$i<count($result);$i++)
  {
	if ($result[$i]['idtipologia'] == $id)
	 {
		  $sel = "selected='selected'";
	 }
	else
	 {
		  $sel = "";
	 }    
    $drop .= "<option value='".$result[$i]['idtipologia']."' ".$sel." >".utf8_decode($result[$i]['tipologia'])."</option>";
  } 
 $drop .= "</select>";
return $drop;
}


function create_stato_drop_box($id)
{
 $db1 = new MySQL(true);
 if ($db1->Error()) $db1->Kill();
 
 $db1->Open();
 $sql = "select idstato,descrizione,peso from stato order by peso";
 //echo $sql."<br />";
 $result = $db1->QueryArray($sql);
 $db1->Close();

 $drop = "<select id='pro_stato'>";
 for ($i=0;$i<count($result);$i++)
  {
	if ($result[$i]['idstato'] == $id)
	 {
		  $sel = "selected='selected'";
	 }
	else
	 {
		  $sel = "";
	 }    
	  
    $drop .= "<option value='".$result[$i]['idstato']."' ".$sel." >".$result[$i]['descrizione']."</option>";
  } 
 $drop .= "</select>";
return $drop;
}



?>
<!DOCTYPE html>
<html>
 <head>
  <title>Architetto Alberto Tonelli</title>
    <!-- Bootstrap -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
 </head>
<body>






<div class="container">
<div class="row-fluid">
<div class="span8">	
 <h2><a href="admin.php">< Admin</a> PROGETTO "<? echo $nome; ?>"</h2>
</div>
<div class="span4">
<button class="btn" onclick="modifica_progetto()">Conferma Modifiche</button><br />
</div>
</div>	 
<div class="row-fluid">
<div class="span4">
Seleziona tipologia
</div>
<div class="span8">
<? echo create_tipologia_drop_box($idtipo) ?>
</div>
</div>
<div class="row-fluid">
<div class="span4">
Nome Progetto
</div>
<div class="span8">
<input type=text id=pro_nome value="<? echo $nome; ?>" />
</div>
</div>
<div class="row-fluid">
<div class="span4">
Luogo
</div>
<div class="span8">
<input type=text id=pro_luogo  value="<? echo $luogo; ?>" />
</div>
</div>
<div class="row-fluid">
<div class="span4">
Mese
</div>
<div class="span8">
<input type=text id=pro_data_mese  value="<? echo $data_mese; ?>" />
</div>
</div>
<div class="row-fluid">
<div class="span4">
Anno
</div>
<div class="span8">
<input type=text id=pro_data_anno  value="<? echo $data_anno; ?>" />
</div>
</div>
<div class="row-fluid">
<div class="span4">
Stato Progetto
</div>
<div class="span8">
<? echo create_stato_drop_box($stato) ?>
</div>
</div>
<div class="row-fluid">
<div class="span4">
Committente
</div>
<div class="span8">
<input type=text id=pro_comm  value="<? echo $committente; ?>" />
</div>
</div>
<div class="row-fluid">
<div class="span4">
Budget
</div>
<div class="span8">
<input type=text id=pro_budget  value="<? echo $budget; ?>" />
</div>
</div>
<div class="row-fluid">
<div class="span4">
Team
</div>
<div class="span8">
<input type=text id=pro_team  value="<? echo $team; ?>" />
</div>
</div>
<div class="row-fluid">
<div class="span4">
Superficie
</div>
<div class="span8">
<input type=text id=pro_superf  value="<? echo $superficie; ?>" />
</div>
</div>
<div class="row-fluid">
<div class="span4">
Note
</div>
<div class="span8">
<textarea id=pro_note><? echo $testo; ?></textarea>
</div>
</div>
<div class="row-fluid">
<div class="span4">
Path
</div>
<div class="span8">
<input type="text" readonly id=pro_path value="<? echo $path; ?>" />
</div>
</div>

 
  <div class="row-fluid">
  <div class="span12">
  <h5>thumbs</h5>
  </div>
  <div class="span12">
       <?
		//$path = $path;
		//echo $path;
		$imm = immagini($path,false); 

		for ($j=0;$j<count($imm);$j++)
		{
		  //echo "<div class='row-fluid'>";	 
		  echo "<img src='img.php?fn=file:///".$imm[$j]['path']."&s=250'>";
		  if (file_exists($imm[$j]['path']))
		   {
            echo "<button class='btn' onclick=delete_immagine('".id_immagine($imm[$j]['path'])."')>Elimina</button><br /><hr>";
           }
		}
		?>
  </div>
  </div>    
  </div>

 


</body>
</html>
<script>

function modifica_progetto()
{
var t;
t = document.getElementById("db_tipologie");
var tipologia = t.options[t.selectedIndex].value;

var id = <?echo $id_pro; ?>;
var nome = document.getElementById("pro_nome").value;
var luogo = document.getElementById("pro_luogo").value;
var data_mese = document.getElementById("pro_data_mese").value;
var data_anno = document.getElementById("pro_data_anno").value;
var stato = document.getElementById("pro_stato").value;
var comm = document.getElementById("pro_comm").value;
var budget = document.getElementById("pro_budget").value;
var team = document.getElementById("pro_team").value;
var superf = document.getElementById("pro_superf").value;
var note = document.getElementById("pro_note").value;
var path = document.getElementById("pro_path").value;

if (nome != '')
 {
   var $param = "id=" + id + "&n=" + nome + "&l=" + luogo + "&dm=" + data_mese+ "&da=" + data_anno + "&s=" + stato + "&c=" + comm + "&b=" + budget + "&t=" + team + "&su=" + superf + "&no=" + note + "&tipo=" + tipologia + "&pa=" + path;
   //alert($param);
   var $doIt = aPost("callback/mod_progetto.php", $param);
   //alert($doIt);
   window.location.href='admin.php';
 }
else
 {
	 alert("Devi inserire almeno il nome del progetto!"); 
 }   
}




function delete_progetto(id)
{
 if (confirm('Elimino il progetto selezionato?')){

   var $param = "id=" + id ;
   var $doIt = aPost("callback/del_progetto.php", $param);
 //document.getElementById(tipologia).innerHTML = '';
 window.location.reload();
}
}
 


  
function aPost(url, parameters)
{
		if (window.XMLHttpRequest) { AJAX=new XMLHttpRequest(); } 
		else {  AJAX=new ActiveXObject("Microsoft.XMLHTTP");  }
		
		if (AJAX) {
					AJAX.open("POST", url, false);
					AJAX.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					AJAX.send(parameters);
					
					return AJAX.responseText;                                         
		} else { return false; }     
}  

function delete_immagine(id)
{
//	alert(id);
if (confirm('Sei sicuro di volerla eliminare?')){

  var $param = "id=" + id;
  aPost("callback/del_immagine.php",$param);
  window.location.reload();
}

}





</script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

