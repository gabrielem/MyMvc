<script type="text/javascript">
function showContent(vThis)
{
vParent = vThis.parentNode;
vSibling = vParent.nextSibling;
while (vSibling.nodeType==3) { // Fix for Mozilla/FireFox Empty Space becomes a TextNode or Something
vSibling = vSibling.nextSibling;
};
if(vSibling.style.display == "none")
{
vThis.src="<?php echo $rootBase."_adm/_template/_grafica/delete.png"; ?>";
vThis.alt = "Hide Div";
vSibling.style.display = "block";
} else {
vSibling.style.display = "none";
vThis.src="<?php echo $rootBase."_adm/_template/_grafica/add.png"; ?>";
vThis.alt = "Show Div";
}
return;
}



function setCheckedValue(id,id2) {
//alert(id);
//document.upd.priorita_spedizione[id].checked=true
 var myRadio = document.getElementById(id);
 if (!myRadio.checked)
 {
 myRadio.checked = true;
 } //else {myRadio.checked = false;}

 var myTxt = document.getElementById(id2);
 myTxt.value = '';

}
</script>




<?php



//$r=_record($tab,"id",$id_record);
$r=$datiComportamento['r'];

include("spese.php");
include("elenco_prodotti.php"); 


$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
?>
<input type="hidden" value="0" name="qta">
<input type="hidden" value="<?php echo "tab/crm_ordini/upd/".$id_record."/"; ?>" name="redirect">
<input type="hidden" value="<?php echo $tab2[1]; ?>" name="tab_valute">

<h1>Aggiornamento Ordine</h1>

<div style="float:left;width:500px;">
	<div><b>dati Ordine</b> <?php echo $r['qta']; ?><br /><br />
	<?php
	//creo array settings
	$settings=array(
	'name'=>data,
	'value'=>$r['data'],
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
	'value'=>$r['data_consegna'],
	'type'=>$value['Type']
	);
	?>
	<?php echo $htmlHelper->_inputData($settings,$value); ?>
	</div>


	<div style="float:left">
	<b>Ditta</b>:<br /> 
	<input type="hidden" name="id_crm_ditte" value="<?php echo $r['id_crm_ditte']; ?>"  />
	<?php if($r['id_crm_ditte']!='0')$selectStatus=true; else $selectStatus=false; ?>
	<?php echo $htmlHelper->filtroRelazione($tab,$tab2[0],'molti-a-uno','id_crm_ditte',$r['id_crm_ditte'],false,false,$selectStatus); ?>
	</div>


	<div style="float:left">
	<b>RT</b> [<i>coefficente</i>]<br /><input type="text" value="<?php echo $r['rt']; ?>" name="rt">
	</div>
	
	<div style="clear:both;"></div>

	<div><b>totale</b><br /><input type="text" value="<?php echo $r['costo_totale']; ?>" name="costo_totale" readonly>
	in Valuta:  
	<input type="hidden" name="id_crm_valute" value="<?php echo $r['id_crm_valute']; ?>"  />
	<?php if($r['id_crm_valute']!='0')$selectStatus=true; else $selectStatus=false; ?>
	<?php echo $htmlHelper->filtroRelazione($tab,$tab2[1],'molti-a-uno','id_crm_valute',$r['id_crm_valute'],false,false,$selectStatus); ?>
	</div>

	<div><b>costo totale in euro</b> <br/>
	<input type="text" value="<?php echo $r['costo_totale_euro']; ?>" name="" readonly></div>


	<div><b>costo spedizione [in <b>EURO</b>]</b> <br/>
	<input type="text" value="<?php echo $r['spedizione_costo']; ?>" name="spedizione_costo"
onclick="setCheckedValue('sped_pc','empty');" id="sped_costo" />

	<input type="radio" name="spedizione_priorita" id="sped_pc" value="costo"<?php if($r['spedizione_priorita']=="costo"){echo " checked";} ?>>
	<label for="sped_pc"><b>&euro;</b> Priorit&agrave; Costo  </label>
	</div>

	<div><b>costo spedizione perc (%)</b> <br/>
	<input type="text" value="<?php echo $r['spedizione_costo_perc']; ?>" name="spedizione_costo_perc" 
onclick="setCheckedValue('sped_pp','empty');"  id="sped_perc" />

	<input type="radio" name="spedizione_priorita" id="sped_pp" value="perc"<?php if($r['spedizione_priorita']=="perc"){echo " checked";} ?>>
	<label for="sped_pp"><b>%</b> Priorit&agrave; Percentuale </label>
	</div>


<input type="text" value="<?php echo $r['costo_totale_euro_rt']; ?>" name="costo_totale_euro_rt" id="costo_totale_euro_rt" />


	<input type="submit" value="salva dati ordine">



	
	</form>


<?php 
if($r['costo_totale']>0.00) 
{
echo $MEM_spese; 
//include("spese.php");
} ?>


</div>



<div style="float:left;width:490px;">
<?php 
echo $MEM_elenco_prodotti; 
?>
</div>
<div style="clear:both"></div>






