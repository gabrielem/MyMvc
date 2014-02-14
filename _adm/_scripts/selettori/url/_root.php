<?php
#####################
### U R L 	  ###
#####################

$file=$_GET['id_s'];
//echo $file;
$includeContentURL=$rootAssoluta.$dirADMIN."_url/".$file.".php";
	if(!file_exists($includeContentURL))
	{
	$_GET['status']="404";
	}

//echo $file;


#######################################################################
### includo la gestione dei filtri
include($rootAssoluta.$dirADMIN."_scripts/selettori/tab/_filtri.php");
#######################################################################


#######################################################################
///INCLUDO SCRIPT SE SONO PRESENTI
$dirScriptSelettore=$rootAssoluta.$dirADMIN."_scripts/selettori/url/".$_GET['id_s']."/";
if(is_dir($dirScriptSelettore)){include($dirScriptSelettore."funzioni.php");}
#######################################################################


#######################################################################
### contenuto della view
$viewToC=$dirADMIN."_views/url/".$file.".php";
	if(!file_exists($rootAssoluta.$viewToC))
	{
	$viewToC=$dirADMIN."_views/url/.index";
	}
$contenuto_pagina=$viewToC;

//echo $contenuto_pagina;

?>
