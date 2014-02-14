<?php $selectCat=$htmlHelper->filtroRelazione($tab,$tab2,$tipoRelazioneDB,"id2",$FILTRO_id2); ?>
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
<?php echo $selectCat; ?>
<?php echo $selectVisibile; ?>
<?php if($dati){ ?>
	<table border="1"> 
	<tr>
	<?php if($dirImg)echo '<th>img</th>'; ?>
	<th>0</th>
	<th>1</th>
	<th>2</th>
	<th>3</th>
	<th>4</th>
	<th>5</th>
	<th>6</th>
	<th></th>
	<th></th>
	</tr>
	<?php for($i=0;$i<count($dati);$i++){ ?>
	<?php $imgDati=$imgUrl=$IMG->_img($tab."/".$dati[$i]['nome_uri'].$SET_IMG[0]); ?>
	<tr>
	<?php if($dirImg)echo '<td>'; ?>
	<?php if($imgDati)echo '<img src="'.$imgDati['url'].'" width="50" border="0" alt="" />'; ?>
	<?php if($dirImg)echo '</td>'; ?>
	<?php $ii=0;?>	<td><?php echo $dati[$i]['id2_dati']['nome']; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][nome]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][nome_uri]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][testo]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][testo2]; ?></td>
	<?php $ii++; ?>	<td><?php echo $htmlHelper->filtraCampi($tab,$dati[$i],$campi[$ii],$dati[$i]['5']); ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][posizione]; ?></td>
	<?php $ii++; ?>	<td><a href="<?php echo $selettoreUrl; ?>upd/<?php echo $dati[$i]['id']; ?>"><?php echo $lang['linkModificaRecord']; ?></a></td>
	<td><a href="<?php echo $selettoreUrl; ?>del/<?php echo $dati[$i]['id']; ?>"><?php echo $lang['linkCancellaRecord']; ?></a></td>
	</tr>
	<?php } ?>
	</table>
<?php } else { ?>
<?php echo $lang['MSG_nessun_record_trovato']; ?>
<?php } ?>