
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
	<th>id</th>
	<th>id_utenti_cat</th>
	<th>nome</th>
	<th>cognome</th>
	<th>email</th>
	<th>password</th>
	<th>data_iscrizione</th>
	<th>attivo</th>
	<th>bannato</th>
	<th>data_nascita</th>
	<th>indirizzo</th>
	<th>citta</th>
	<th>provincia</th>
	<th>regione</th>
	<th>paese</th>
	<th>cap</th>
	<th>telefono</th>
	<th>cellulare</th>
	<th>segue_rinpoche_dal</th>
	<th>primo_livello</th>
	<th>secondo_livello</th>
	<th></th>
	<th></th>
	</tr>
	<?php for($i=0;$i<count($dati);$i++){ ?>
	<?php $imgDati=$imgUrl=$IMG->_img($tab."/".$dati[$i]['nome_uri'].$SET_IMG[0]); ?>
	<tr>
	<?php if($dirImg)echo '<td>'; ?>
	<?php if($imgDati)echo '<img src="'.$imgDati['url'].'" width="50" border="0" alt="" />'; ?>
	<?php if($dirImg)echo '</td>'; ?>
	<?php $ii=0;?>	<td><?php echo $dati[$i][id]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][id_utenti_cat]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][nome]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][cognome]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][email]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][password]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][data_iscrizione]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][attivo]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][bannato]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][data_nascita]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][indirizzo]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][citta]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][provincia]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][regione]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][paese]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][cap]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][telefono]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][cellulare]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][segue_rinpoche_dal]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][primo_livello]; ?></td>
	<?php $ii++; ?>	<td><?php echo $dati[$i][secondo_livello]; ?></td>
	<?php $ii++; ?>	<td><a href="<?php echo $selettoreUrl; ?>upd/<?php echo $dati[$i]['id']; ?>"><?php echo $lang['linkModificaRecord']; ?></a></td>
	<td><a href="<?php echo $selettoreUrl; ?>del/<?php echo $dati[$i]['id']; ?>"><?php echo $lang['linkCancellaRecord']; ?></a></td>
	</tr>
	<?php } ?>
	</table>
<?php } else { ?>
<?php echo $lang['MSG_nessun_record_trovato']; ?>
<?php } ?>
