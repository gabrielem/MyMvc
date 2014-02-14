<?php
function slugDBcopy($TAB_slug,$slug,$id=null)
{

	if(!empty($id))
	{	
	//se id non è vuoto allora blocco il controllo del campo sull'id perchè sono in UPDATE
	//e quindi il record stesso non conta come doppinoe!
	$ADD_WHERE_RECORD=" AND id2!='".$id."' ";
	}
	//prima verifico se esiste già, in tal caso aggiungo un numero
	$r=_record($TAB_slug,"slug",$slug,$ADD_WHERE_RECORD);
	if($r) 
	{
	$slugPrimo=$slug;
	//lo slug esiste allora devo cambiarne il nome
		//quindi conto il numero di occorrenze trovate per lo slug
		for($i=1;$i>0;$i++)
		{
		$slug=$slugPrimo."-".$i;
		$r2=_record($TAB_slug,"slug",$slug);
			if(!$r2)
			{
			break;
			}
		}
	}
return $slug;
}

function slugDB($tab,$dati,$P,$mode,$lastId)
{
global $TAB_slug;
global $CONTENT_TAB;
//pr($dati);
//pr($P);

$mod=$P['MOD_VAR'];
$comp=$P['COMP_VAR'];
$LOGIN=$P['LOGIN_GROUP'];
$radice=$P['SLUG_RADICE'];

	// stabilisco il valore dello slug 
	// può essere preso da POST oppure da dati
	// prima controllo POST se è vuoto allora vado su dati['nome_uri']
	if($P['slug']!="")
	{
	$slug=$P['slug'];
	}
	else
	{
	$slug=$dati['nome_uri'];
	}

	$slug=slug($slug);
	
	//echo "<p>".$slug."</p>";

	if(!in_array($tab,$CONTENT_TAB))
	{
	### eseguo prima un controllo preventivo:
	### si tratta di una tab per i contenuti?
	### solo in tal caso procedo con le operazioni 
	### della creazione/modifica/cancellazione dello slug
	//
	}
	#############################################################
	### new slug
	else if($mode=="new")
	{
	// a questo punto verifico se esiste uno slug simile lo ricreo con numero progressivo
	// con la funzione slugDBcopy() appunto ^_^
	$slug=slugDBcopy($TAB_slug,$slug);

		//INSERT: nuovo slug
		$id2=$lastId;
		$dati_insert=array($tab,$id2,$slug,$mod,$comp,$LOGIN,$radice);
		//echo '<h1>qui</h1>';
		//inserisco lo slug e recupero ID

		if(_insert($TAB_slug,$dati_insert,"1"))
		{return true; }
		else{return false; }
	}
	#########################


	#############################################################
	### new slug
	elseif($mode=="upd")
	{
	// a questo punto verifico se esiste uno slug simile lo ricreo con numero progressivo
	// con la funzione slugDBcopy() appunto ^_^
//echo "?".$dati['id']."?";
	$slug=slugDBcopy($TAB_slug,$slug,$lastId);
//echo "<p style='color:red;'>".$slug."</p>";

		//UPDATE:  slug
		
			//recupero dati sullo slug
			$id2=$lastId;
		$dati_insert=array($tab,$id2,$slug,$mod,$comp,$LOGIN,$radice);
		$dati_update=array('tab'=>$tab,'id2'=>$id2,'slug'=>$slug,'modello'=>$mod,'comportamento'=>$comp,'login'=>$LOGIN,'radice'=>$radice);	
			//pr($dati_update);
			$ADD_WHERE_RECORD=" AND tab='".$tab."' ";
			$rSlug=_record($TAB_slug,"id2",$id2,$ADD_WHERE_RECORD);
			
			//controllo per bug se SLUG NON CREATO (es: tab prima priva di slug...)
		if($rSlug)
		{
			if(_update($TAB_slug,$dati_update,$rSlug['id']))
			{return true;}
			else
			{return false;}
		}
		else
		{
			if(_insert($TAB_slug,$dati_insert,"1"))
			{return true; }
			else{return false; }
		}
	}
	#########################





	#############################################################
	### del slug
	elseif($mode=="del")
	{
	// a questo punto verifico se esiste uno slug simile lo ricreo con numero progressivo
	// con la funzione slugDBcopy() appunto ^_^
	$slug=slugDBcopy($TAB_slug,$slug,$dati['id']);
	
		//recupero dati sullo slug
		$id2=$lastId;
		$dati_insert=array($tab,$id2,$slug);	
		$ADD_WHERE_RECORD=" AND tab='".$tab."' ";
		$rSlug=_record($TAB_slug,"id2",$id2,$ADD_WHERE_RECORD);

	_delete($TAB_slug,$rSlug['id']);
	}
	#########################
	
	



}
?>
