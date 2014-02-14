<?php
//class comportamento_crm_ordini extends valiDate
class comportamento_crm_ordini 
{

	function _elabora($dati)
	{
	global $TAB_crm_prodotti_tipi;
	global $TAB_crm_ordini_spese;
	global $TAB_crm_prodotti_cat;
	global $TAB_crm_prodotti;
	global $TAB_crm_valute;

	//echo '<p>azione: '.$dati['azione'].'</p>';
	$id_record=$_GET[$dati['azione']];
	
	$tab=$dati['tab'];
	$tab2=$dati['tab2'];
	$tab3=$dati['tab3'];
	
	//$r
	$datiR['r']=_record($tab,"id",$id_record);
	//$rSpese
	$datiR['rSpese']=_loop($TAB_crm_ordini_spese," WHERE id_crm_ordini='".$id_record."' ");
	
	//valuta_ordine
	//$valuta_ordine=_record($TAB_crm_valute,"id",$datiR['r']['id_crm_valute']); 
	$valuta_ordine=array("euro"=>$datiR['r']['valuta']);
	
	//$datiR['loop_prodotti']
	$loop_prodotti=_loop($tab3[2]," WHERE id_crm_ordini='".$id_record."' ");










	#####################
	### LOOP PRODOTTI RIADEGUATO 1
	##########################################	
	//ADesso esEGUo il loop PER riCrearE l?Array con i daTi aGGiUNtivi
	for($i=0;$i<count($loop_prodotti);$i++)
	{
	$QTA_ORDINE=$QTA_ORDINE+$loop_prodotti[$i]['qta'];
	//valuta
	//$valuta=_record($TAB_crm_valute,"id",$loop_prodotti[$i]['id_crm_valute']); 
	$valuta=array("euro"=>$datiR['r']['valuta']);
	
	//costoTotRecord
	$costoTotRecord=number_format($loop_prodotti[$i]['costo']*$loop_prodotti[$i]['qta'], 2, '.', '');
	//costoWO
	$costoWO=$this->contavalute($loop_prodotti[$i]['costo'],$valuta);
	//$costoWO_SPESE
	$costoWO_SPESE=$this->contavalute($costoWO_SPESE_valuta,$valuta);
	
	$datiProSingolo=_record($TAB_crm_prodotti,"id",$loop_prodotti[$i]['id_crm_prodotti']);
	$datiR['loop_prodotti'][]=array_merge(
	$loop_prodotti[$i],
		array(
		'costort_noiva'=>$costort_noiva,
		'valuta'=>$valuta,
		'costoWO'=>$costoWO,
		'costoTotRecord'=>$costoTotRecord,
		'datiPro'=>$datiProSingolo
		)
	); 
	}
	

	//aggiorno QTA
	_update($tab,$QTA_ORDINE,$id_record,"qta");


	//$datiR['QTA_ORDINE']=$QTA_ORDINE;
	
	$datiR['loop_tipi_prodotto']=_loop($TAB_crm_prodotti_tipi,"","ORDER BY nome");
	$datiR['loop_cat_prodotto']=_loop($TAB_crm_prodotti_cat,"","ORDER BY nome");

	$datiR['loop_prodotti_campione']=_loop($TAB_crm_prodotti," WHERE id_crm_ditte='".$datiR['r']['id_crm_ditte']."' ");

	
	//
	//calcolo totale ordine
	$totale_ordine=$this->totaleOrdine(array(
	'loop_prodotti'=>$datiR['loop_prodotti'])
	);	
	$datiR['totale_ordine']=$totale_ordine;

	//aggiorno costo totale
	_update($tab,$datiR['totale_ordine'],$id_record,"costo_totale");

	//aggiorno tot Euro	
	$totEuro=$this->contavalute($datiR['totale_ordine'],$valuta_ordine);
	//echo '<p>totEuro: '.$totEuro.'</p>';
	_update($tab,$totEuro,$id_record,"costo_totale_euro");
















	##############################
	### calcolo spese globali
	##########################################
	//spedizione_costo
	//spedizione_costo_perc
	//spedizione_priorita
	//number_format(, 2, '.', '');
		## RICALCOLO DELLA Percentuale e dEL Costo SPEDIZIONE
		if($datiR['r']['spedizione_priorita']=="perc")
		{
		$v=@number_format($totEuro/100*$datiR['r']['spedizione_costo_perc'], 2, '.', ''); 
		_update($tab,$v,$id_record,"spedizione_costo"); 
		}
		else
		{
		$v=@number_format($datiR['r']['spedizione_costo']/$totEuro*100, 3, '.', ''); 
		_update($tab,$v,$id_record,"spedizione_costo_perc"); 
		}
	
	
	$totSpeseCosto=number_format($totSpeseCosto+$datiR['r']['spedizione_costo'], 2, '.', '');
	$totSpesePerc=number_format($totSpesePerc+$datiR['r']['spedizione_costo_perc'], 2, '.', '');
	//echo "<p>".$totSpesePerc."</p>";
	

//pr($datiR['rSpese']);
		//loop spese
		//for($i=0;$i<count($loop_prodotti);$i++)
		for($i=0;$i<count($datiR['rSpese']);$i++)
		{
		//$datiR['rSpese']
			############
			## RICALCOLO DELLA Percentuale e dELle SPESE
			###################################################################à
			if($datiR['rSpese'][$i]['priorita']=="perc")
			{
			$v=@number_format($totEuro/100*$datiR['rSpese'][$i]['perc'], 2, '.', ''); 
			$datiR['rSpese'][$i]['costo']=$v;
			_update($TAB_crm_ordini_spese,$v,$datiR['rSpese'][$i]['id'],"costo"); 
			}
			else
			{
			$v=@number_format($datiR['rSpese'][$i]['costo']/$totEuro*100, 3, '.', ''); 
			$datiR['rSpese'][$i]['perc']=$v;
			_update($TAB_crm_ordini_spese,$v,$datiR['rSpese'][$i]['id'],"perc"); 
			}
			#########################################

		$totSpeseCosto=number_format($totSpeseCosto+$datiR['rSpese'][$i]['costo'], 2, '.', '');
		$totSpesePerc=number_format($totSpesePerc+$datiR['rSpese'][$i]['perc'], 2, '.', '');

		}


	//$totSpesePerc
	//costo
	//perc
	//id_crm_ordini
	//priorita
	
	###


	//$totSpesePerc=number_format($totSpeseCosto/($totEuro)*100, 3, '.', '');
	//$totSpesePerc="DEVO CALCOLARE... riga 177 crm_ordini.php";
	
	$datiR['totSpeseCosto']=$totSpeseCosto;
	$datiR['totSpesePerc']=$totSpesePerc;
	$datiR['totale_ordine_con_spese']=number_format($datiR['totale_ordine']+$totSpeseCosto, 2, '.', '');
	$datiR['costo_totale_euro_con_spese']=number_format($totEuro+$totSpeseCosto, 2, '.', '');
	$datiR['costo_totale_euro']=number_format($totEuro, 2, '.', '');
	

	//AGGIORNO COSTO TOTALE RT
	//$datiR['costo_totale_euro_con_spese']
	_update($tab,$datiR['costo_totale_euro_con_spese'],$id_record,"costo_totale_euro_rt");
	
	






	############
	### RIPRENDO I DATI AGGIORNATI
	##########################
	$datiR['r']=_record($tab,"id",$id_record);
	$datiR['rSpese']=_loop($TAB_crm_ordini_spese," WHERE id_crm_ordini='".$id_record."' ");












	##################### 
	### LOOP PRODOTTI RIADEGUATO 2 'costort_in_valuta'=>$costort_in_valuta
	##########################################	

	$loop_prodotti3=$datiR['loop_prodotti'];
	unset($datiR['loop_prodotti']);

	for($i=0;$i<count($loop_prodotti3);$i++) 
	{
	############## 
	### ricalcolo costi 
	
	//$datiR['r']['rt'] 
	//number_format(, 2, '.', ''); 
	$costo=$loop_prodotti3[$i]['costo']; 
	//$datiR['totSpesePerc']
	//$ivaRT=
	$percSpeseSingoloPro=number_format($costo/100*$datiR['totSpesePerc'], 2, '.', '');
	$costoConSpeseInValuta=number_format($costo+$percSpeseSingoloPro, 2, '.', ''); 
	$costoConSpese=$this->contavalute($costoConSpeseInValuta,$valuta_ordine); 	
	
	
	
	$MEM_costort=$loop_prodotti3[$i]['costort']; 

	$costort_consigliato=number_format($costoConSpese*$datiR['r']['rt'], 2, '.', ''); 
	

	//aggiorno il costort solo se vuoto, una volta che è valorizzato lo lascio com'è...
		if($MEM_costort=="0.00" || $MEM_costort=="0,00" || $MEM_costort=="")
		{
		//echo '<p>costo: '.$costo.'</p>';
		//echo '<p>costort_consigliato: '.$costort_consigliato.' </p>';
		//echo '<p>MEM_costort: '.$MEM_costort.'</p>';
		

		$loop_prodotti3[$i]['costort']=$costort_consigliato;
		_update($tab3[2],$loop_prodotti3[$i]['costort'],$loop_prodotti3[$i]['id'],"costort"); 
		}
		else
		{
		$loop_prodotti3[$i]['costort']=$MEM_costort;
		}
	
	//ivaRT
	$ivaRT=number_format($loop_prodotti3[$i]['costort']/100*20, 2, '.', '');
	//costort
	$costort_noiva=number_format($loop_prodotti3[$i]['costort']-$ivaRT, 2, '.', '');

	//$costort_in_valuta
	$costort_in_valuta=$this->contavalute($loop_prodotti3[$i]['costort'],$valuta_ordine,'inValuta');

	//$costort_per_qta
	$costort_per_qta=number_format($loop_prodotti3[$i]['costort']*$loop_prodotti3[$i]['qta'], 2, '.', '');

	$datiR['loop_prodotti'][]=array_merge(
	$loop_prodotti3[$i],
		array(
		'ivaRT'=>$ivaRT,
		'costoConSpese'=>$costoConSpese,
		'costoConSpeseInValuta'=>$costoConSpeseInValuta,
		'costort_consigliato'=>$costort_consigliato,
		'costort_noiva'=>$costort_noiva,
		'costort_in_valuta'=>$costort_in_valuta,
		'costort_per_qta'=>$costort_per_qta
		)
	); 


	
/**/

	}



















	


	//echo '<p>::'.$id_record.'';
	//pr($dati);




	
	return $datiR;
	}





####################
### altre funzioni
############################################################


	//aggiorna Totale Ordine
	function totaleOrdine($dati)
	{
		$r=$dati['loop_prodotti'];
		
		for($i=0;$i<count($r);$i++)
		{
		$costoTotRecord=$r[$i]['costoTotRecord'];
		$totaleOrdine=number_format($totaleOrdine+$costoTotRecord, 2, '.', '');
		}
	return $totaleOrdine;
	}

	

	function contavalute($valore,$arrayValute,$report="euro")
	{
		if($report=="euro")
		{
		//$valore,$arrayValute
		//echo '<p>questo: '.$valore.'</p>';
		$result=@number_format($valore*$arrayValute['euro'], 2, '.', '');
		//echo $result;
		//pr($arrayValute);
		}
		else
		{
		//echo $arrayValute['euro'];
		$result=@number_format($valore/$arrayValute['euro'], 2, '.', '');
		//$result="metodo non supportato";
		}
	return $result;
	}

	
}
?>
