<?php
##########################################################################################
########## CANCELLA RECORD

if($azione=="del")
{

$record=_record($tab,'id',$id_record);
//echo $record['nome_uri'];
$IMG=new IMG();
$datiImg=$IMG->_img($tab."/".$record['nome_uri'].$SET_IMG[0]);
$IMG->delAllSet($tab,$record['nome_uri'],$datiImg['est']);


$risultato=_delete($tab,$id_record);
if($risultato){
	//cacnello anche lo slug relativo
	$slug_check=slugDB($tab,$record,$_POST,'del',$id_record);

	$locationSELETTORE=$rootBaseAdmin."".$_GET['t']."/".$tab."/";
	if($_SERVER['HTTP_REFERER']!="") {
	$location=$_SERVER['HTTP_REFERER'];
	}
	else
	{
	$location=$locationSELETTORE;
	}

$htmlHelper->setFlash('msg',$lang['MSG_DEL_eseguito']); 
} else {
$htmlHelper->setFlash('msg',$lang['MSG_DEL_errore_imprevisto']); 
}
header("location: ".$location);
exit;
}
####################################################################################################
?>
