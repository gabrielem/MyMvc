<?php
##########################################################################################
########## NUOVO RECORD
if($getPost->ascolta($_POST,"new"))
{

	if($getPost->ascolta($_POST,"tab")){
	$memTAB=$tab;
	$tab=$_POST['tab'];
	}


//echo 'questa e la tab: '.$tab;
include($rootAssoluta.$dirADMIN."_scripts/selettori/tab/select_validate_mode.php");


//echo '<h1>ora valido</h1>';
$validate= new $validazioneDati();


$dati	=$validate->dati($_POST,$tab);
$valid	=$validate->valid($dati,$tab);



	if($valid){
	$risultato=_insert($tab,$dati,"1");
	//echo '<h1>DATI VALIDI</h1>';
		if($risultato){


		
		### SLUG
			### aplico lo slug solo per le tabelle contenuti
			if($CONTENT_TAB)
		//a questo punto abbiamo la var nome_uri
		$slug_check=slugDB($tab,$dati,$_POST,'new',$risultato);



		//echo '<h1>MSG OK</h1>';
		$htmlHelper->setFlash('msg',$lang['MSG_NEW_eseguito']); 
		} else {
		//echo '<h1>MSG NOOO</h1>';
		$htmlHelper->setFlash('msg',$lang['MSG_NEW_errore_imprevisto']); 
		}

	if($_POST['redirect']!="")
	{
		if($_POST['redirect']=="GO_2_UPDATE")
		{
		$urlToGo=$selettoreUrl."upd/".$risultato."/";
		}
		else
		{
		$urlToGo=$rootBaseAdmin.$_POST['redirect'];
		}
	} 
	else 
	{
	$urlToGo=$selettoreUrl;
	}
header("location: ".$urlToGo);exit;

	} else {
	//echo '<h1>DATI NON VALIDI</h1>';
	$htmlHelper->setFlash('msg',$lang['MSG_NEW_compilare_correttamente']); 
	}



}
	if($memTAB!=""){
	$tab=$memTAB;
	}
####################################################################################################



?>
