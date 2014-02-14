<?php
class valiDate_crm_ordini extends valiDate
{


	function vData($k,$_POST,$P,$campi)
	{

		//evito i controlli sul Campo ID
		if(
		$k!="id" 
		&& $k!="data"  
		&& $k!="data_consegna"  
		&& $k!="qta"  
		&& $k!="costo_totale"  
		&& $k!="costo_totale_euro"  
		&& $k!="costo_totale_euro_rt"  
		
		&& $k!="valuta"  

		&& $k!="spedizione_costo"  
		&& $k!="spedizione_costo_perc"
		&& $k!="spedizione_priorita"
		&& $k!="rt"	
		&& $k!="consegna_ultimata"

		)
		{
		//per prima coso controllo che tutti i campi siano presenti nell'ARRAY $_POST
			if(!isset($P[$k])){$err="1";}
			echo "<p>".$k."</p>";
			//poi verifico se i campi sono vuoti e se non devono esserlo
				//if($P[$k]==""){$err="1";echo "".$k;}
				if($P['costo_totale']=="")
				{
				$err="1";echo "".$k;
				}
				
			return $err;
		}	
	}


	function _specialDati($k,$_POST,$P,$campi)
	{

	$value=$P[$k];


		if($k=="valuta" && $P['valuta']=="")
		{
		//calcolo il valore in euro:
		$valutaNow=_record($P['tab_valute'],'id',$P['id_crm_valute']);
		$value=$valutaNow['euro'];	
		}



/*	
		if($k=="costo_totale_euro" && $P['costo_totale_euro']=="")
		{
		//calcolo il valore in euro:
		$valuta=_record($P['tab_valute'],'id',$P['id_crm_valute']);
		$valuta=array("euro"=>$valuta['euro']);
		$value=number_format($P['costo_totale']*$valuta['euro'], 2, '.', '');		
		}


		### costo spedizione
		if($k=="spedizione_costo_perc" && $P['priorita_spedizione']=="costo")
		{
		//calcolo il valore in euro:
		$valuta=_record($P['tab_valute'],'id',$P['id_crm_valute']);
		$valuta=array("euro"=>$valuta['euro']);
		$costo_totale_euro=number_format($P['costo_totale']*$valuta['euro'], 2, '.', '');		
		
		//$value=number_format($costo_totale_euro/$P['spedizione_costo']*100, 2, '.', '');
		//$value=number_format($costo_totale_euro/$P['spedizione_costo'], 3, '.', '');
		$value=number_format($P['spedizione_costo']/$costo_totale_euro*100, 3, '.', '');
		}


		if($k=="spedizione_costo" && $P['priorita_spedizione']=="perc")
		{
		//calcolo il valore in euro:
		$valuta=_record($P['tab_valute'],'id',$P['id_crm_valute']);
		$valuta=array("euro"=>$valuta['euro']);
		$costo_totale_euro=number_format($P['costo_totale']*$valuta['euro'], 2, '.', '');		

		$value=number_format($costo_totale_euro/100*$P['spedizione_costo_perc'], 2, '.', '');
		}
*/




	return $value;
	}







}
?>
