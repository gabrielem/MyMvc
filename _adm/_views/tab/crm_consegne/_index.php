<script type="text/javascript">
function showContent(vThis)
{
//alert(vThis);

//vParent = vThis.parentNode;
//vSibling = vParent.nextSibling;
//while (vSibling.nodeType==3) { // Fix for Mozilla/FireFox Empty Space becomes a TextNode or Something
//vSibling = vSibling.nextSibling;
//};

var vSibling = document.getElementById(vThis); 

if(vSibling.style.display == "none")
{
vThis.src="chiudi dettagli";
vThis.alt = "Hide Div";
vSibling.style.display = "block";
} else {
vSibling.style.display = "none";
vThis.src="mostra dettagli";
vThis.alt = "Show Div";
}
return;
}



</script>


<a href="<?php echo $selettoreUrl ?>new/"><?php echo $lang['linkNuovoRecord']; ?></a>


<?php //selectFiltri(); ?>


<?php 
$tab=$TAB_crm_ordini;
$datiOrdini=$datiComportamento['loop_ordini'];

if($datiOrdini){ ?>
	<table id="tab_elenco_ordini"> 
	<tr>
	<?php if($dirImg)echo '<th>img</th>'; ?>
	<th>id</th>
	<th>data</th>
	<th>data_consegna</th>
	<th>qta</th>
	<th>costo_totale</th>
	<th>ditta</th>
	<th>costo_totale_euro</th>
	<th>consegne</th>
	<th></th>

	</tr>
	<?php for($i=0;$i<count($datiOrdini);$i++){ ?>
	<?php $imgDati=$imgUrl=$IMG->_img($tab."/".$datiOrdini[$i]['nome_uri'].$SET_IMG[0]); ?>
	<tr class="<?php echo $datiOrdini[$i]['tr_class']; ?>">
	<?php if($dirImg)echo '<td>'; ?>
	<?php if($imgDati)echo '<img src="'.$imgDati['url'].'" width="50" border="0" alt="" />'; ?>
	<?php if($dirImg)echo '</td>'; ?>
	<td><?php echo $datiOrdini[$i][id]; ?></td>
	<td><a name="ordine_<?php echo $datiOrdini[$i]['id']; ?>">
	<?php echo $htmlHelper->filtraCampi($tab,$datiOrdini[$i],'data',$datiOrdini[$i]['data']); ?></a></td>
	<td><?php echo $htmlHelper->filtraCampi($tab,$datiOrdini[$i],"data_consegna",$datiOrdini[$i]['data_consegna']); ?></td>
	<td><?php echo $datiOrdini[$i]['qta']; ?></td>
	<td><?php echo $datiOrdini[$i]['costo_totale']; ?></td>
	<td><?php echo $datiOrdini[$i]['nome_crm_ditta']; ?></td>
	<td><?php echo $datiOrdini[$i]['costo_totale_euro']; ?> </td>
	<td align="center">
	
	<?php 
	//pr($datiOrdini[$i]['dati_consegne']);



echo'
<form action="" method="post" enctype="multipart/form-data" name="new" id="new'.$datiOrdini[$i]['id'].'">
<input type="hidden" name="new" value="1">
<input type="hidden" value="GO_2_UPDATE" name="redirect"> 

<input type="hidden" name="datadd" value="'.date("d").'"> 
<input type="hidden" name="datamm" value="'.date("m").'"> 
<input type="hidden" name="datayyyy" value="'.date("Y").'"> 
<input type="hidden" name="datayyyy" value="'.date("Y").'"> 
<input type="hidden" name="datahh" value="00"> 
<input type="hidden" name="dataii" value="00"> 
<input type="hidden" name="datass" value="00"> 

<input type="hidden" name="id_crm_ordini" value="'.$datiOrdini[$i]['id'].'"> 

<input type="submit" value="aggiungi nuova consegna" style="padding:3px;height:21px;font-size:11px;color:blue;">

</form>

';



echo '
<script language="JavaScript">
function apri(url, w, h) {
var windowprops = "width=" + w + ",height=" + h;
popup = window.open(url,\'remote\',windowprops);
}
</script>
';
	if($datiOrdini[$i]['dati_consegne'])
	{
	echo '<div style="text-align:left;"><b style="font-size:11px;">Elenco consegne</b>';
	echo '<table>';
		for($i2=0;$i2<count($datiOrdini[$i]['dati_consegne']);$i2++)
		{
		$urlStampa=$rootBase.$directoryAdminName.'/url/stampa_consegna/id/'.$datiOrdini[$i]['dati_consegne'][$i2]['id'];
		echo '<tr style="font-size:10px;">
		<td>'.date("d-m-Y",$datiOrdini[$i]['dati_consegne'][$i2]['data']).'</td>
		
		<td><a href="'.$selettoreUrl.'upd/'.$datiOrdini[$i]['dati_consegne'][$i2]['id'].'">'.$lang['linkModificaRecord'].'</a></td>
		<td><a href="'.$selettoreUrl.'del/'.$datiOrdini[$i]['dati_consegne'][$i2]['id'].'">'.$lang['linkCancellaRecord'].'</a></td>
		<!-- <td><a href="JavaScript:apri(\''.$urlStampa.'\',\'900\',\'450\');">'.$lang['linkStampa'].'</a></td> -->
		<td><a href="'.$urlStampa.'" target="_blank">'.$lang['linkStampa'].'</a></td>
		</tr>';

		}
	echo '</table>';
	echo '</div>';
	} 
	?>
	</td>


	<?php if($datiOrdini[$i]['dati_consegne']) { ?> 
	<td style="font-size:11px;">	
	<!-- a href="#ordine_<?php echo $datiOrdini[$i]['id']; ?>" onclick="showContent('dettagli<?php echo $datiOrdini[$i]['id']; ?>');">dettagli</a -->
	<input type="button" value="dettagli" style="padding:3px;height:21px;font-size:11px;color:blue;" onclick="showContent('dettagli<?php echo $datiOrdini[$i]['id']; ?>');">
	</td>
	<?php } else { ?>
	<td>&nbsp;</td>
	<?php } ?>
	</tr>


<tr class="tre">
<td colspan="9">
<div style="display:none;margin:5px;margin-top:15px;background:#ffffcc;" id="dettagli<?php echo $datiOrdini[$i]['id']; ?>">
<?php
	echo '<table id="tab_elenco_ordini_dettagli">';
	echo '
	<tr>
	<th>data</th>
	<th>qta</th>
	<th>guasti</th>
	</tr>
	';
	for($iC=0;$iC<count($datiOrdini[$i]['dati_consegne']);$iC++)
	{
	//$datiOrdini[$i]['dati_consegne']
	echo '<tr>';
	echo '<td>'.date("d-m-Y",$datiOrdini[$i]['dati_consegne'][$iC]['data']).'</td>';
	echo '<td>'.$datiOrdini[$i]['dati_consegne'][$iC]['qta_attuale'].'</td>';
	echo '<td>'.$datiOrdini[$i]['dati_consegne'][$iC]['note'].'</td>';
	
	echo '</tr>';
	}
	echo '</table>';
?>


</div>
</td>
</tr>






	<?php } ?>
	</table>
<?php } else { ?>
<?php echo $lang['MSG_nessun_record_trovato']; ?>
<?php } ?>
