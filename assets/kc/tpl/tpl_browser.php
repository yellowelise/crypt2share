<?php
include("../config.php");
if ((!$_SESSION['iduser']) || ($_SESSION['iduser']<1))
  header($_SESSION['not_logged']);
  
if ($_REQUEST['lang'])
 {
	 switch ($_REQUEST['lang'])
	  {
		  case "it":
		    $it_sel = "selected";
		    break; 
		  case "en":
		    $en_sel = "selected"; 
		    break; 
		  case "es":
		    $es_sel = "selected"; 
		    break; 
		  case "de":
		    $de_sel = "selected"; 
		    break; 
		  case "fr":
		    $fr_sel = "selected"; 
		    break; 
	  }
 }  
  
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Crypt2Share.com: /<?php echo $this->session['dir'] ?></title>
<?php INCLUDE "tpl/tpl_css.php" ?>
<?php INCLUDE "tpl/tpl_javascript.php" ?>
</head>
<body onload="secure()">
<!-- <img src="../images/logook200.png" /><font style="font-size:34.5px;"><b>Crypt2Share.com</b></font>
-->
<script type="text/javascript">
$('body').noContext();
</script>
<div id="resizer"></div>
<div id="shadow"></div>
<div id="dialog"></div>
<div id="mobile"></div>
<div id="alert"></div>
<div id="clipboard"></div>
<div id="all">
<div data-step="10" data-intro="Le cartelle che sono presenti nel tuo Crypt2Share. N.B. facendo click con il tasto destro del mouse appare un menu per le operazioni su di esse." data-position='right' id="left">
    <div id="folders"></div>    
    <div id="folders_action"><br /><button onclick="nuova_cartella(data.path)">Nuova Sotto Cartella...</button></div>
</div>
<div id="right">
    <div id="toolbar">
        <div>
        <a href="kcact:upload" data-step="1" data-intro="Serve per caricare files su Crypt2Share"><?php echo $this->label("Upload") ?></a>
        <a href="kcact:refresh" data-step="2" data-intro="Aggiorna il riquadro dei files"><?php echo $this->label("Refresh") ?></a>
        <a href="kcact:settings" data-step="3" data-intro="Preferenze per la visualizzazione e l'ordinamento dei files"><?php echo $this->label("Settings") ?></a>
      <!--  <a href="kcact:maximize"><?php echo $this->label("Maximize") ?></a> -->
      
        <a href="kcact:friendship" data-step="4" data-intro="Visualizzazione e gestione degli amici"><?php echo $this->label("Friends") ?></a>
        <a href="kcact:notify" data-step="5" data-intro="Storico delle notifiche"><?php echo $this->label("Notify") ?></a>
        <a href="kcact:invita" data-step="6" data-intro="Invita gli amici a Crypt2Share"><?php echo $this->label("Tell a friend") ?></a>
        <a href="kcact:crypted" data-step="7" data-intro="Visualizza o nascondi la sezione dei files criptati" id="link_crypted"><?php echo $this->label("View Crypted file") ?></a>
        <a href="kcact:mysite" data-step="8" data-intro="Visualizza il tuo personal site<br />Copia i file nella cartella mysite e se vuoi crea delle sottocartelle.<br />Avrai gratuitamente un tuo sito personale raggiungibile all'indirizzo:<br /><a target='_blank' href='http://my.crypt2share.com/<?php echo $_SESSION['username'] ?>'>http://my.crypt2share.com/<?php echo $_SESSION['username'] ?></a>"><?php echo $this->label("MySite") ?></a>
      <!--  <a href="kcact:about"><?php echo $this->label("About") ?></a>-->
        
        
        <div style="float:right;margin-left:10px;" data-step="10" data-intro="Fa il logout da Crypt2Share" data-position='left' ><button onclick="logout()">Logout (<?php echo $_SESSION['username']?>)</button></div>
        <div style="float:right;margin-left:10px;"><button onclick="javascript:introJs().start();">Help</button></div>
        <div style="float:right">
        <select data-step="9" data-intro="Cambia la lingua di Crypt2share" id="language" data-position='left' style="width:auto;height:25px;text-align:right;" onchange="change_lang()">
			<option <?php echo $it_sel ?> value="it">Italiano</option>
			<option <?php echo $en_sel ?> value="en">English</option>
			<option <?php echo $es_sel ?> value="es">Spanish</option>
			<option <?php echo $de_sel ?> value="de">Deutsch</option>
			<option <?php echo $fr_sel ?> value="fr">Français</option>
			
			</select>
        </div>

        
        </div>
    </div>
    <div id="settings">

    <div>
    <fieldset>
    <legend><?php echo $this->label("View:") ?></legend>
        <table summary="view" id="view"><tr>
        <th><input id="viewThumbs" type="radio" name="view" value="thumbs" /></th>
        <td><label for="viewThumbs">&nbsp;<?php echo $this->label("Thumbnails") ?></label> &nbsp;</td>
        <th><input id="viewList" type="radio" name="view" value="list" /></th>
        <td><label for="viewList">&nbsp;<?php echo $this->label("List") ?></label></td>
        </tr></table>
    </fieldset>
    </div>

    <div>
    <fieldset>
    <legend><?php echo $this->label("Show:") ?></legend>
        <table summary="show" id="show"><tr>
        <th><input id="showName" type="checkbox" name="name" /></th>
        <td><label for="showName">&nbsp;<?php echo $this->label("Name") ?></label> &nbsp;</td>
        <th><input id="showSize" type="checkbox" name="size" /></th>
        <td><label for="showSize">&nbsp;<?php echo $this->label("Size") ?></label> &nbsp;</td>
        <th><input id="showTime" type="checkbox" name="time" /></th>
        <td><label for="showTime">&nbsp;<?php echo $this->label("Date") ?></label></td>
        </tr></table>
    </fieldset>
    </div>

    <div>
    <fieldset>
    <legend><?php echo $this->label("Order by:") ?></legend>
        <table summary="order" id="order"><tr>
        <th><input id="sortName" type="radio" name="sort" value="name" /></th>
        <td><label for="sortName">&nbsp;<?php echo $this->label("Name") ?></label> &nbsp;</td>
        <th><input id="sortType" type="radio" name="sort" value="type" /></th>
        <td><label for="sortType">&nbsp;<?php echo $this->label("Type") ?></label> &nbsp;</td>
        <th><input id="sortSize" type="radio" name="sort" value="size" /></th>
        <td><label for="sortSize">&nbsp;<?php echo $this->label("Size") ?></label> &nbsp;</td>
        <th><input id="sortTime" type="radio" name="sort" value="date" /></th>
        <td><label for="sortTime">&nbsp;<?php echo $this->label("Date") ?></label> &nbsp;</td>
        <th><input id="sortOrder" type="checkbox" name="desc" /></th>
        <td><label for="sortOrder">&nbsp;<?php echo $this->label("Descending") ?></label></td>
        </tr></table>
    </fieldset>
    </div>

    </div>
    <div data-step="12" data-intro="I files presenti nella cartella selezionata. N.B. facendo click con il tasto destro del mouse appare un menu per le operazioni su di essi" data-position='left' id="files">
        <div id="content"></div>
    </div>
</div>
<div id="status"><span style="position:relative;left:10px;top:1px;" id="fileinfo">&nbsp;</span></div>
</div>
<div  id="secure"></div>

</body>
</html>
 
