<?php $creaFormNew = new generaForm(); 
$MEM_spese=$creaFormNew->_formTag('new','nuovaSpesa','','1'); 

$MEM_spese.='
<input type="hidden" name="tab" value="'.$TAB_crm_ordini_spese.'">
<input type="hidden" name="id_crm_ordini" value="'.$id_record.'">
<input type="hidden" name="redirect" value="'.$selettoreDati['selettore']."/".$selettoreDati['id_s']."/upd/".$id_record.'">

<input type="hidden" value="'.$tab2[1].'" name="tab_valute" />
<input type="hidden" value="'.$r['costo_totale'].'" name="costo_totale" />
<input type="hidden" value="'.$r['id_crm_valute'].'" name="id_crm_valute" />



<div>
<b>Spese Vaire</b>
<br />
Aggiungere solamente dopo aver inserito tutti i prodotti dell\'ordine
<br />
	<div style="float:left;">
	costo [EURO] <br/>
	<input type="text" value="" name="costo" style="width:90px;" onclick="setCheckedValue(\'spesa_pc\',\'spesa_perc\');" id="spesa_costo" />
	</div>
	
	<div style="float:left;">perentuale (%)</b> <br/>
	<input type="text" value="" name="perc" style="width:85px;" onclick="setCheckedValue(\'spesa_pp\',\'spesa_costo\');" id="spesa_perc" />
	</div>

	<div style="float:left;">causale</b> <br/>
	<input type="text" value="" name="nome" style="width:120px;" />
	</div>
	
	<div style="float:left;">
	&nbsp;<br />
	<input type="submit" value="aggiungi">
	</div>

	<div style="clear:both;background:#ffffff;padding:0px;margin:0px;"></div>

	<div>

	<input type="radio" name="priorita" id="spesa_pc" value="costo">
	<label><b>&euro;</b> Priorit&agrave; Costo  </label>

	<input type="radio" name="priorita" id="spesa_pp" value="perc" checked>
	<label><b>%</b> Priorit&agrave; Percentuale </label>

	</div>

</div>
<div style="clear:both;"></div>
<div>



</div>
</form>
';


//$rSpese=_loop($TAB_crm_ordini_spese," WHERE id_crm_ordini='".$id_record."' ");
$rSpese=$datiComportamento['rSpese'];


if($rSpese){

$MEM_spese.='
<table>
<tr style="background-color:#afafaf;color:#ffffff;font-size:11px;">
<td><b>causale</b></td>
<td><b>costo</b></td>
<td><b>perc</b></td>
<td><b>P.</b></td>
<td></td>
</tr>
';
	
	for($i=0;$i<count($rSpese);$i++){

	if($rSpese[$i]['priorita']=="perc")
	{
	$rSpesePriorita="<b>%</b>";
	}
	else
	{
	$rSpesePriorita="<b>&euro;</b>";
	}
$MEM_spese.='
<tr style="background-color:#ffffcc;color:#909090;font-size:11px;">
<td width="100%">'.$rSpese[$i]['nome'].'</td>
<td>&euro;.'.$rSpese[$i]['costo'].'</td>
<td>'.$rSpese[$i]['perc'].'</td>
<td style="color:green;">'.$rSpesePriorita.'</td>
<td>
<a href="'.urlMenuAdmin(array('selettore'=>'tab','id_s'=>$TAB_crm_ordini_spese)).'del/'.$rSpese[$i]['id'].'">
'.$lang['linkCancellaRecord'].'</a>
</td>

</tr>
';

	}
$MEM_spese.='
</table>';

}

?>
