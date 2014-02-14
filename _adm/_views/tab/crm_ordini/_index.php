

<?php if($paginate){ ?>
<p>
<?php if($paginate['indietro']) {?><a href="<?php echo $selettoreUrl."pag/".$paginate['indietro']; ?>">indietro</a><?php } ?>&nbsp;
	<?php for($i=1;$i<$paginate['totPagine'];$i++){ ?>
	<a href="<?php echo $selettoreUrl."pag/".$i; ?>"<?php if($i==$paginate['pag']){echo ' class="sel" ';} ?>><?php echo $i; ?></a>&nbsp;
	<?php } ?>
<?php if($paginate['avanti']) {?><a href="<?php echo $selettoreUrl."pag/".$paginate['avanti']; ?>">avanti</a><?php } ?>&nbsp;
</p>
<?php } ?>
<a href="<?php echo $selettoreUrl ?>new/"><?php echo $lang['linkNuovoRecord']; ?></a>


<?php selectFiltri(); ?>


<?php 
//pr($dati);

if($dati){ ?>
	<table id="tab_elenco_ordini"> 
	<tr>
	<?php if($dirImg)echo '<th>img</th>'; ?>
	<th>ditta</th>
	<th>data</th>
	<th>data di consegna</th>
	<th>qta</th>
	<th>totale</th>
	<th>&nbsp;</th>
	<th>valuta</th>
	
	<th>totale euro</th>
	<th>totale euro RT</th>
	<th></th>
	</tr>
	<?php for($i=0;$i<count($dati);$i++){ ?>
	<?php $imgDati=$imgUrl=$IMG->_img($tab."/".$dati[$i]['nome_uri'].$SET_IMG[0]); ?>


	<tr class="<?php echo $dati[$i]['tr_class']; ?>" ondblclick="javascript:location='<?php echo $selettoreUrl; ?>upd/<?php echo $dati[$i]['id']; ?>'">

	<?php if($dirImg)echo '<td>'; ?>
	<?php if($imgDati)echo '<img src="'.$imgDati['url'].'" width="50" border="0" alt="" />'; ?>
	<?php if($dirImg)echo '</td>'; ?>

	<td>
<!-- 
<?php echo $htmlHelper->filtraCampi($tab,$dati[$i],'id_crm_ditte',$dati[$i]['id_crm_ditte']); ?>
-->
<?php echo $dati[$i]['id_crm_ditte_dati']['nome']; ?>
	</td>

	
	<td><?php echo $htmlHelper->filtraCampi($tab,$dati[$i],'data',$dati[$i]['data']); ?></td>
	<td><?php echo $htmlHelper->filtraCampi($tab,$dati[$i],'data_consegna',$dati[$i]['data_consegna']); ?></td>
	<td><?php echo $dati[$i]['qta']; ?></td>
	<td><?php echo $dati[$i]['costo_totale']; ?></td>
	<td>
	<img src="<?php echo $rootBase.$DIR_template."_grafica/valute/".$dati[$i]['id_crm_valute']['id'].".png"; ?>" width="21" border="0" alt="" />
	</td>
	
	<td>
<!-- 
<?php echo $htmlHelper->filtraCampi($tab,$dati[$i],'id_crm_valute',$dati[$i]['id_crm_valute']); ?>
-->
<?php echo $dati[$i]['id_crm_valute_dati']['nome']; ?>

	</td>
	<td><?php echo $dati[$i]['costo_totale_euro']; ?></td>
	<td><?php echo $dati[$i]['costo_totale_euro_rt']; ?></td>
<!-- 
	<td><a href="<?php echo $selettoreUrl; ?>upd/<?php echo $dati[$i]['id']; ?>"><?php echo $lang['linkModificaRecord']; ?></a></td>
-->
	<td><a href="<?php echo $selettoreUrl; ?>del/<?php echo $dati[$i]['id']; ?>" onclick="return confirm('<?php echo $lang['linkCancellaRecordConfirm']; ?>');" class="canc">
	<?php echo $lang['linkCancellaRecord']; ?></a></td>
	</tr>
	<?php } ?>
	</table>
<?php } else { ?>
<?php echo $lang['MSG_nessun_record_trovato']; ?>
<?php } ?>
