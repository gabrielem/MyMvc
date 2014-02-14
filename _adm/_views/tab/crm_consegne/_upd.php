<?php
$r=_record($tab,"id",$id_record);
$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
?>


<div style="float:left;width:500px;">
	<div>data (int(11))<br/>
	<?php $settings=array('name'=>data,'value'=>$r['data'],'type'=>$value['Type']); echo $htmlHelper->_inputData($settings,$value); ?></div>
	Note<br />
	<textarea name="note"><?php echo $r['note']; ?></textarea>
	<br /><br />
	<input type="submit" value="invia">
</form>
</div>

<div style="float:left;width:500px;">
elenco prodotti in ordine: 

<?php
	if(!empty($datiComportamento['consegne_precedenti_tot']))
	{
	$totConsegne=$datiComportamento['consegne_precedenti_tot']+1;
	echo "<p><b>Ci sono state un totale di ".$totConsegne." consegne per questo ordine</b></p>";
	}

?>
<br />
In totale sono arrivati <?php echo $datiComportamento['qta_attuale_totale']; ?> prodotti su <?php echo $r['qta_totale']; ?>
<?php include("elenco_prodotti.php");  ?>

</div>
