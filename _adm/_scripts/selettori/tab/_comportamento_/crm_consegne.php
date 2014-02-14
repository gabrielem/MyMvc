<?php
//class comportamento_crm_ordini extends valiDate
class comportamento_crm_consegne 
{

	function _elabora($dati)
	{
	global $TAB_crm_consegne;
	global $TAB_crm_consegne_prodotti;
	global $TAB_crm_ditte;
	global $TAB_crm_prodotti_tipi;
	global $TAB_crm_ordini;
	global $TAB_crm_ordini_prodotti;
	global $TAB_crm_prodotti_cat;
	global $TAB_crm_prodotti;
	global $TAB_crm_valute;

	//echo '<p>azione: '.$dati['azione'].'</p>';
	$id_record=$_GET[$dati['azione']];
	
	$tab=$dati['tab'];
	$tab2=$dati['tab2'];
	$tab3=$dati['tab3'];
	


if($dati['azione']=="del")
{
//DELETE
_delete($TAB_crm_consegne_prodotti,"0"," WHERE id_crm_consegne='".$id_record."'");
}







	//$r
	$datiR['r']=_record($tab,"id",$id_record);	

	//loop_ordini 
	$loop_ordini=_loop($TAB_crm_ordini, " WHERE consegna_ultimata='0'  ", " ORDER BY data_consegna DESC ");
	$TAB_2_LIST[]="crm_ditte";
	$TAB_2_LIST[]="crm_valute";
	
	//ricreo Array Ordini
	for($i=0;$i<count($loop_ordini);$i++)
	{
	$divisodue=$i%2;
		if($divisodue=="1")
		{
		$tr_class="due";
		}
		else
		{
		$tr_class="uno";
		}
	
	###nome_crm_ditta
	$nome_crm_ditta=_record($TAB_crm_ditte,"id",$loop_ordini[$i]['id_crm_ditte']);	

	### qta consegne
	$dati_consegne=_loop($TAB_crm_consegne, " WHERE id_crm_ordini='".$loop_ordini[$i]['id']."' "); 
	//echo'<p>dati_consegne ID:'.$loop_ordini[$i]['id'].'</p>'; 
	//pr($dati_consegne); 
	if($dati_consegne)
	{
	$qta_consegne=count($dati_consegne);
	}
	else
	{
	$qta_consegne="0";
	}

	$loop_ordini2[$i]=array_merge(
	$loop_ordini[$i],
		array(
		'nome_crm_ditta'=>$nome_crm_ditta['nome'],
		'qta_consegne'=>$qta_consegne,
		'dati_consegne'=>$dati_consegne,
		'divisodue'=>$divisodue,
		'tr_class'=>$tr_class
		
		)
	);
	
	}
	$datiR['loop_ordini']=$loop_ordini2;


	$dati_ordine=_record($TAB_crm_ordini,"id",$datiR['r']['id_crm_ordini']); 
	$datiR['dati_ordine']=$dati_ordine;

	$datiR['r']['data_ordine']=$dati_ordine['data'];
	_update($tab,$datiR['r']['data_ordine'],$id_record,"data_ordine");

	$datiR['r']['qta_totale']=$dati_ordine['qta'];
	_update($tab,$datiR['r']['qta_totale'],$id_record,"qta_totale");




	### recupero i dati delle cosegne precedenti;
	$datiConsegnePrecedenti=_loop($TAB_crm_consegne," WHERE 
	 id!='".$datiR['r']['id']."' AND  id_crm_ordini='".$datiR['r']['id_crm_ordini']."' ");
	
	$datiR['consegne_precedenti']=$datiConsegnePrecedenti;
	$datiR['consegne_precedenti_tot']=count($datiConsegnePrecedenti);
	
	

	
	$loop_prodotti=_loop($TAB_crm_ordini_prodotti," WHERE id_crm_ordini='".$datiR['r']['id_crm_ordini']."' ");

	#####################
	### LOOP PRODOTTI RIADEGUATO 1
	##########################################	
	//ADesso esEGUo il loop PER riCrearE l?Array con i daTi aGGiUNtivi
	for($i=0;$i<count($loop_prodotti);$i++)
	{
	//$qta_arrivata_precedente
	$datiProConsegna=flase;
	$datiProSingolo=_record($TAB_crm_prodotti,"id",$loop_prodotti[$i]['id_crm_prodotti']);

	$datiProConsegna=_record($TAB_crm_consegne_prodotti,"id_crm_ordini_prodotti",$loop_prodotti[$i]['id'],"
	 AND id_crm_consegne='".$datiR['r']['id']."' AND  id_crm_ordini='".$datiR['r']['id_crm_ordini']."' ");


	### $datiProConsegna2
	$datiProConsegna2="";
	$datiProConsegna2=_loop($TAB_crm_consegne_prodotti," WHERE id_crm_ordini_prodotti='".$loop_prodotti[$i]['id']."' 
	AND id_crm_consegne!='".$datiR['r']['id']."' AND  id_crm_ordini='".$datiR['r']['id_crm_ordini']."' ");


$qta_arrivata_attuale=$qta_arrivata_attuale+$datiProConsegna['qta'];


	### LOOP CONSEGNE PRECEDENTI PRODOTTI
$qta_arrivata_precedente="0";
	if($datiProConsegna2)
	{
//echo count($datiProConsegna2);
//pr($datiProConsegna2);
		/**/	
		$qta_arrivata_precedente="0";
		for($iC=0;$iC<count($datiProConsegna2);$iC++)
		{
		$qta_arrivata_precedente=$qta_arrivata_precedente+$datiProConsegna2[$iC]['qta'];
		}
//echo "<p>$qta_arrivata_precedente</p>";
$qta_arrivata_precedente_tot=$qta_arrivata_precedente_tot+$qta_arrivata_precedente;


	}




	### if($datiProConsegna){echo'<h1>1</h1>';}else{echo'<h1>2</h1>';}
	

	### calcolo il totale della QTA in arrivo
	$qta_arrivata=$qtaArrivata+$datiProConsegna['qta'];	
	


	$datiR['loop_prodotti'][]=array_merge(
	$loop_prodotti[$i],
		array(
		'qta_arrivata_precedente'=>$qta_arrivata_precedente,
		'datiPro'=>$datiProSingolo, 
		'datiProConsegna'=>$datiProConsegna, 
		'datiProConsegna2'=>$datiProConsegna2
		)
	); 
	}
	

	//$qta_arrivata_precedente_tot
	//$qta_arrivata_attuale
	//$qta_arrivata
	$datiR['qta_attuale']=$qta_arrivata_attuale;
	_update($tab,$qta_arrivata_attuale,$id_record,"qta_attuale");

	$datiR['qta_attuale_precedente']=$qta_arrivata_precedente_tot;
	//echo $datiR['qta_attuale_precedente'];
	$datiR['qta_attuale_totale']=$qta_arrivata_attuale+$qta_arrivata_precedente_tot;
	//echo $datiR['qta_attuale_totale'];

	
	
	//$qta_arrivata_precedente



	
	//echo '<p>::'.$id_record.'';
	//pr($dati);

	return $datiR;
	}





####################
### altre funzioni
############################################################
	
}
?>
