		<?php
		
		$array_3_liv=$dati[$i]['LOOP_SOTTOSEZIONI'][$i2]['LOOP_3LIV'];
		if(is_array($array_3_liv))
		{
		echo '
		<tr>
		<td colspan="20" class="sub">
			<table border="0" cellpadding="0" cellspacing="0" id="index" class="liv3"> ';
			
			for($i3=0;$i3<count($array_3_liv);$i3++)
			{
			?>
			<tr>
			
                        <td class="first_liv3">
                        <div class="icona_liv3"></div>
                        <?php echo $array_3_liv[$i3]['nome']; ?></td>

<!-- 
			<td><?php echo $htmlHelper->filtraCampi($tab,$array_3_liv[$i3],"toolbar_nologin",$array_3_liv[$i3]['toolbar_nologin']); ?></td>
-->
	<td class="in_menu"><?php
	$toolbar_nologin3="<b style=\"color:red;\">no</b>";
	if($array_3_liv[$i3]['toolbar_nologin']=="1") {
	$toolbar_nologin3="<b style=\"color:blue;\">yes</b>";
	} echo $toolbar_nologin3;
	
	?></td>

			<td class="visibile"><?php echo $htmlHelper->filtraCampi($tab,$array_3_liv[$i3],"visibile",$array_3_liv[$i3]['visibile']); ?></td>


			<td class="posizione"><?php echo $htmlHelper->filtraCampi($tab,$array_3_liv[$i3],"posizione",$array_3_liv[$i3]['posizione']); ?></td>


                        <td class="b_upd"><a class="upd" href="<?php echo $selettoreUrl; ?>upd/<?php echo $array_3_liv[$i3]['id']; ?>"><?php echo $lang['linkModificaRecord']; ?></a></td>
			<td class="b_del"><a class="del" href="<?php echo $selettoreUrl; ?>del/<?php echo $array_3_liv[$i3]['id']; ?>" onclick="return confirm('<?php echo $lang['linkCancellaRecordConfirm']; ?>');"><?php echo $lang['linkCancellaRecord']; ?></a></td>
			</tr>
			<?php 
			}	
		echo '
			</table>
		
		</td>
		</tr>
		';
		}
?>
