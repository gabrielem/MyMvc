<?php
##########################################################################################
########## MODIFICA RECORD
if($getPost->ascolta($_POST,"upd")){

include($rootAssoluta.$dirADMIN."_scripts/selettori/tab/select_validate_mode.php");

$validate= new $validazioneDati();
$dati	=$validate->dati($_POST,$tab);
$valid	=$validate->valid($dati,$tab);







//pr($valid);

	### CONTROLLO IMG 
	if(!empty($dirImg))
	{
	//echo '<h1>IMG</h1>';
	//echo 'nome del campo file per img: <b>"'.$_POST['campoImgUpload'].'"</b>...';
	$nomeCampoUpload=$_POST['campoImgUpload'];
		if($IMG->uploadJpg($tab,$dati['nome_uri'],$nomeCampoUpload=null))
		{
		//se è riuscito l'upload allora ridimensiono
		$IMG->riduciAllSet($tab,$dati['nome_uri'],"jpg","100");
		}
	}


	if($valid)
	{
	$risultato=_update($tab,$dati,$id_record);
	//echo '<h1>DATI VALIDI</h1>';

	//a questo punto abbiamo la var nome_uri
	$slug_check=slugDB($tab,$dati,$_POST,'upd',$id_record);


		### RINOMINO IMG IN BASE ALLO SLUG
		$IMG->renameAllSet($tab,$dati['nome_uri'],$_POST['nome_uri_save']);
		
		if($risultato)
		{
		$htmlHelper->setFlash('msg',$lang['MSG_UPD_eseguito']); 
		} else {
		$htmlHelper->setFlash('msg',$lang['MSG_UPD_errore_imprevisto']); 
		}

	### REDIRECT 
	if($_POST['redirect']!=""){
	$urlToGo=$rootBaseAdmin.$_POST['redirect'];
	} 
	else 
	{$urlToGo=$selettoreUrl;}
	
	header("location: ".$urlToGo);exit;

	} else {
	$htmlHelper->setFlash('msg',$lang['MSG_UPD_compilare_correttamente']); 
	
	}





}
####################################################################################################
?>
