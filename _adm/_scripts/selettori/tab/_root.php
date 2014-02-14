<?php
//pr($_POST);
#####################
### T A B	  ###
#####################

$tab=$_GET['id_s'];
$campiTab=campiTab($tab);
$campiTabCompleti=campiTab($tab,1);

### aggiornamento veloce dalla riga di un solo campo
if($_GET['UPD_TF']!="")
{$d=explode("_",$_GET['UPD_TF']);$UPD=_update($tab,$d[2],$d[1],$d[0]);
	if($UPD){$htmlHelper->setFlash('msg',$lang['MSG_UPD_eseguito']); Header("location: ".$selettoreUrl);exit;}
	else{$htmlHelper->setFlash('msg',$lang['MSG_UPD_errore_imprevisto']); Header("location: ".$selettoreUrl);exit;}
}


### tab rel molto-a-uno e FILTRI
### 
include($rootAssoluta.$dirADMIN."_scripts/selettori/tab/_filtri.php");







//CONTROLLO DIRECTORY IMG
##########################
$IMG=new IMG();
$dirImg=$IMG->checkDir($tab);
##########################

##########################
### dati per filtro 
//if(!empty($tab2) && $tipoRelazioneDB=='molti-a-uno' && !empty($cat) && $cat!="ALL")
for($i=0;$i<count($FILTRI);$i++)
{
	$nomeFiltro="FILTRO_".$FILTRI[$i];
	if($$nomeFiltro!="" && $$nomeFiltro!="ALL" && @in_array($FILTRI[$i],$campiTab))
	{
	$valueFiltro=str_replace("ZERO","0",$$nomeFiltro); 
	$whereTAB1.=" AND ".$FILTRI[$i]."='".$valueFiltro."' "; 	
	}
}
##########################
if(!empty($whereTAB1)){$whereTAB1=" WHERE id!='' ".$whereTAB1." ";}
//echo '<h1>whereTAB1: '.$whereTAB1.'</h1>';



//PRELEVO I DATI DAL DB
###########################
	
	
	//pr($campiTab);
		$posizione=false;
		foreach($campiTab as $campo)
		{
		if($campo=="posizione") $posizione=true;
		}
		if($posizione)
		{
		$orderbyTAB1=" ORDER BY posizione ";
		}
		else
		{
		$orderbyTAB1=" ORDER BY id ";
		}
$dati=_loop($tab,$whereTAB1,$orderbyTAB1,$tab2);
$campi=campiTab($tab);
$campiAll=campiTab($tab,1);
//pr($dati);

//PAGINAZIONE DATI 
############################
$perPagina="30";
$paginate=paginate($dati,$perPagina,$_GET['pag']);
	if($paginate){$dati=$paginate['dati'];}
############################

//IMPORTO SE C'E' LA VaLiDazionE PERSONALE DELLA TABELLA
############################
$fileValidazioneTAB=$rootAssoluta.$dirADMIN."_scripts/selettori/tab/_validate_/".$tab.".php";
if(file_exists($fileValidazioneTAB)) include($fileValidazioneTAB);
############################









	if($_GET['pag']=="1")
	{
	//NOFOLLOW E CANonical pER PaG 1
	$scriviNOFOLLOW="<META NAME=\"ROBOTS\" CONTENT=\"NOINDEX, NOFOLLOW\">";
	$scriviCANONICAL='<link rel="canonical" href="'.$selettoreUrl.'"/>';
	}
	/*
	questo ora viene bloccato perchè in ADMIN
	ho bosogno di inviare dati in redirect anche delle pagine (FILTRI)
	else if(!$dati && isset($_GET['pag']))
	{
	//CONTROLLO PER REDIRECT su paginazione vuota
	$notFound="1";
	}
	*/
	


### CONTROLLO CHE LA TABELLA ESISTA: 
if(!campiTab($tab))
{
$notFound="1";
//$contenuto_pagina=$dirADMIN."_views/404.php";
}
















#################################################################################
#################################################################################
#################################################################################
### presento i contenuti



function returnContent($t,$a)
{
global $rootAssoluta;
global $dirADMIN;

	$file=$dirADMIN."_views/tab/".$t."/_".$a.".php";

	if(file_exists($rootAssoluta.$file))
	{
	$c=$file;
	} 
	else 
	{
	$c=$dirADMIN."_views/tab/.".$a."";
	}
	return $c;
}




















if($_GET['del']!=""){ $azione="del";$id_record=$_GET[$azione]; 
### seleziono il contenuto
$contenuto_pagina=returnContent($tab,$azione);

}else if($_GET['upd']!=""){ $azione="upd";$id_record=$_GET[$azione]; 
### seleziono il contenuto
$contenuto_pagina=returnContent($tab,$azione);

}else if(isset($_GET['new'])){ $azione="new";$id_record=$_GET[$azione]; 
### seleziono il contenuto
$contenuto_pagina=returnContent($tab,$azione);



}else{
$azione="index";
###
### INDEX
###	
$contenuto_pagina=returnContent($tab,$azione);
}

$_GET['_azione_']=$azione;







include($rootAssoluta.$dirADMIN."_scripts/selettori/tab/_comportamento.php");


















### includo controllo dati post
include($rootAssoluta.$dirADMIN."_scripts/selettori/tab/del.php");
include($rootAssoluta.$dirADMIN."_scripts/selettori/tab/new.php");
include($rootAssoluta.$dirADMIN."_scripts/selettori/tab/upd.php");











?>
