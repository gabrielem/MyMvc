<?php
$generaForm=new generaForm();
echo _formStart('new','new','new');
?>
<input type="hidden" value="0" name="qta">
<input type="hidden" value="GO_2_UPDATE" name="redirect">
<input type="hidden" value="<?php echo $tab2[1]; ?>" name="tab_valute">



Inserisci un nuovo Ordine
	<div><b>data Ordine</b><br/>
	<?php
	//creo array settings
	$settings=array(
	'name'=>data,
	'value'=>time(),
	'type'=>$value['Type']
	);
	?>
	<?php echo $htmlHelper->_inputData($settings,$value); ?>
	</div>

	<div><b>Data consegna stimata</b><br/>
	<?php
	//creo array settings
	$settings=array(
	'name'=>data_consegna,
	'value'=>time(),
	'type'=>$value['Type']
	);
	?>
	<?php echo $htmlHelper->_inputData($settings,$value); ?>
	</div>




<!-- <b>totale</b><br /> -->
<input type="hidden" value="0.00" name="costo_totale">
<div>
Imposta Valuta:  <?php echo $htmlHelper->filtroRelazione($tab,$tab2[1],'molti-a-uno','id_crm_valute',$r['id_crm_valute'],false,false); ?>
</div>

<div>
<b>Ditta</b>:<br /> 
<?php echo $htmlHelper->filtroRelazione($tab,$tab2[0],'molti-a-uno','id_crm_ditte',$r['id_crm_ditte'],false,false); ?>
</div>

<input type="hidden" value="<?php echo $r['costo_totale_euro']; ?>" name="costo_totale_euro">
<!-- 
<div><b>costo totale in euro</b> <br/></div>
-->

<input type="submit" value="invia">
</form>
