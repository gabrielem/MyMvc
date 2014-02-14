<?php
$r=_record($tab,"id",$id_record);
$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
?>
<input type="hidden" value="<?php echo "tab/crm_ordini/upd/".$r['id_crm_ordini']."/"; ?>" name="redirect">
<div>
Prodotto <br/>
<?php echo $htmlHelper->filtroRelazione($tab,$tab2[1],'molti-a-uno','id_crm_prodotti',$r['id_crm_prodotti'],false,false); ?>
<?php echo $htmlHelper->filtroRelazione($tab,$tab2[0],'molti-a-uno','__VALUTA_SOLO_MOSTRARE',$r['id_crm_valute'],false,false,true); ?>

<input type="hidden" value="<?php echo $r['id_crm_valute']; ?>" name="id_crm_valute">
<input type="hidden" value="<?php echo $r['id_crm_ordini']; ?>" name="id_crm_ordini">
<?php //echo $htmlHelper->filtroRelazione($tab,$tab2[2],'molti-a-uno','id_crm_ordini',$r['id_crm_ordini'],false,false); ?>

</div>
<div>
	<div style="float:left;">
	qta (int(11))<br/>
	<input type="text" value="<?php echo $r['qta']; ?>" name="qta"></div>
	<div style="float:left;">
	costo (decimal(10,2))<br/>
	<input type="text" value="<?php echo $r['costo']; ?>" name="costo">
	</div>
	<div style="clear:both;margin:0px;padding:0px;"></div>
</div>



<input type="submit" value="invia">
</form>
