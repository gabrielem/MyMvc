<?php if($paginate){ ?>
<p>
<?php if($paginate['indietro']) {?><a href="<?php echo $selettoreUrl."pag/".$paginate['indietro']; ?>">indietro</a><?php } ?>&nbsp;
	<?php for($i=1;$i<$paginate['totPagine'];$i++){ ?>
	<a href="<?php echo $selettoreUrl."pag/".$i; ?>"<?php if($i==$paginate['pag']){echo ' class="sel" ';} ?>><?php echo $i; ?></a>&nbsp;
	<?php } ?>
<?php if($paginate['avanti']) {?><a href="<?php echo $selettoreUrl."pag/".$paginate['avanti']; ?>">avanti</a><?php } ?>&nbsp;
</p>
<?php } ?>

<!-- 
<a class="new" href="<?php echo $selettoreUrl ?>new/"><?php echo $lang['linkNuovoRecord']; ?></a>
-->


<?php //echo $selectCat; ?>
<?php //echo $selectVisibile; ?>

<?php if($dati){ ?>
	<table border="0" cellpadding="0" cellspacing="0" id="index"> 
	<tr>
	<?php if($dirImg)echo '<th>img</th>'; ?>

	<th>Title</th>
	<th>In_Menu</th>
	<th>visibility</th>
	<th>position</th>
	<th></th>
	<th></th>
	</tr>
	
	<?php for($i=0;$i<count($dati);$i++){ ?>
	<?php $imgDati=$imgUrl=$IMG->_img($tab."/".$dati[$i]['nome_uri'].$SET_IMG[0]); ?>
	<tr>
	<?php if($dirImg)echo '<td>'; ?>
	<?php if($imgDati)echo '<img src="'.$imgDati['url'].'" width="50" border="0" alt="" />'; ?>
	<?php if($dirImg)echo '</td>'; ?>
	
	<td class="nome first"><?php echo $dati[$i][nome]; ?></td>
	
	<td class="in_menu"><?php
	$toolbar_nologin="<b style=\"color:red;\">no</b>";
	if($dati[$i][toolbar_nologin]=="1") {$toolbar_nologin="<b style=\"color:blue;\">yes</b>";} echo $toolbar_nologin;
	
	?></td>

			
	
	<td class="visibile"><?php echo $htmlHelper->filtraCampi($tab,$dati[$i],"visibile",$dati[$i]['visibile']); ?></td>
	<td class="posizione"><?php echo $htmlHelper->filtraCampi($tab,$dati[$i],"posizione",$dati[$i]['posizione']); ?></td>


	<td class="b_upd"><a class="upd" href="<?php echo $selettoreUrl; ?>upd/<?php echo $dati[$i]['id']; ?>"><?php echo $lang['linkModificaRecord']; ?></a></td>
	<td class="b_del"><a class="del" href="<?php echo $selettoreUrl; ?>del/<?php echo $dati[$i]['id']; ?>" onclick="return confirm('<?php echo $lang['linkCancellaRecordConfirm']; ?>');"><?php echo $lang['linkCancellaRecord']; ?></a></td>
	</tr>





		<?php
		if(is_array($dati[$i]['LOOP_SOTTOSEZIONI']))
		{
		echo '
		<tr>
		<td colspan="20" class="sub">';
			//pr($dati[$i]['LOOP_SOTTOSEZIONI']);
			echo '
			<table border="0" cellpadding="0" cellspacing="0" id="index" class="liv2">';
			
			for($i2=0;$i2<count($dati[$i]['LOOP_SOTTOSEZIONI']);$i2++)
			{
			?>
			<tr>
			<td class="first_liv2">
			<div class="icona_liv2"></div>
			
			<?php echo $dati[$i]['LOOP_SOTTOSEZIONI'][$i2]['nome']; ?></td>
			
<!--
			<td><?php echo $htmlHelper->filtraCampi($tab,$dati[$i]['LOOP_SOTTOSEZIONI'][$i2],"toolbar_nologin",$dati[$i]['LOOP_SOTTOSEZIONI'][$i2]['toolbar_nologin']); ?></td>
-->
	<td class="in_menu"><?php
	$toolbar_nologin2="<b style=\"color:red;\">no</b>";
	if($dati[$i]['LOOP_SOTTOSEZIONI'][$i2]['toolbar_nologin']=="1") {
	$toolbar_nologin2="<b style=\"color:blue;\">yes</b>";
	} echo $toolbar_nologin2;
	
	?></td>

			<td class="visibile"><?php echo $htmlHelper->filtraCampi($tab,$dati[$i]['LOOP_SOTTOSEZIONI'][$i2],"visibile",$dati[$i]['LOOP_SOTTOSEZIONI'][$i2]['visibile']); ?></td>

			<td class="posizione"><?php echo $htmlHelper->filtraCampi($tab,$dati[$i]['LOOP_SOTTOSEZIONI'][$i2],"posizione",$dati[$i]['LOOP_SOTTOSEZIONI'][$i2]['posizione']); ?></td>
			
			<td class="b_upd"><a class="upd" href="<?php echo $selettoreUrl; ?>upd/<?php echo $dati[$i]['LOOP_SOTTOSEZIONI'][$i2]['id']; ?>"><?php echo $lang['linkModificaRecord']; ?></a></td>
			<td class="b_del"><a class="del"  href="<?php echo $selettoreUrl; ?>del/<?php echo $dati[$i]['LOOP_SOTTOSEZIONI'][$i2]['id']; ?>" onclick="return confirm('<?php echo $lang['linkCancellaRecordConfirm']; ?>');"><?php echo $lang['linkCancellaRecord']; ?></a></td>
			</tr>
			<?php
				include("_index_3liv.php");
			}	
		echo '
			</table>
		
		</td>
		</tr>
		';
		}
		?>







	<?php } ?>
	</table>
<?php } else { ?>
<?php echo $lang['MSG_nessun_record_trovato']; ?>
<?php } ?>
