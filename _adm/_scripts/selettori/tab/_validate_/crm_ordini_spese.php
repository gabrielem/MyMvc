<?php
class valiDate_Crm_ordini_spese extends valiDate
{


	function vData($k,$_POST,$P,$campi)
	{//echo '111';

echo'<hr>';

echo'<hr style="color:red;">';

		//evito i controlli sul Campo ID
		if($k!="id" && $k!="note")
		{
		//per prima coso controllo che tutti i campi siano presenti nell'ARRAY $_POST
			//if(!isset($P[$k])){$err="1";}
			
			//poi verifico se i campi sono vuoti e se non devono esserlo
				//if($P[$k]==""){$err="1";echo "".$k;}
			
			//return $err;
		}	

	}


	function _specialDati($k,$_POST,$P,$campi)
	{

	$value=$P[$k];

		if($k=="perc" && $P['costo']!="")
		{
		//
		//calcolo il valore in euro:
		$valuta=_record($P['tab_valute'],'id',$P['id_crm_valute']);
		$costo_totale_euro=number_format($P['costo_totale']*$valuta['euro'], 2, '.', '');		
		$value=number_format($P['costo']/$costo_totale_euro*100, 3, '.', '');

		}
		elseif($k=="costo" && $P['perc']!="")
		{
		//
		//calcolo il valore in euro:
		$valuta=_record($P['tab_valute'],'id',$P['id_crm_valute']);
		$costo_totale_euro=number_format($P['costo_totale']*$valuta['euro'], 2, '.', '');		
		$value=number_format($costo_totale_euro/100*$P['perc'], 2, '.', '');
		
		}
	echo'<p>'.$k.'=>'.$P[$k].' ('.$value.')</p>';
	return $value;
	}


}
?>
