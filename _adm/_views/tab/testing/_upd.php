<?php
$r=_record($tab,"id",$id_record);
$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
?>
<?php $rSlug=_record($TAB_slug,"id2",$id_record," AND tab='".$tab."' "); ?>
<?php echo select(array_merge(array(''),$A_MODELLI),"MOD_VAR",$rSlug['modello']); ?>
<?php echo select(array_merge(array(''),$A_COMPORTAMENTI),"COMP_VAR",$rSlug['comportamento']); ?>

<?php echo $generaForm->_hidden("SLUG_RADICE","1"); ?>

<?php echo $htmlHelper->filtroRelazione($tab,$tab2[0],'molti-a-uno','id_testing_cat',$r['id_testing_cat'],false,false); ?>
<div>nome (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>
<div>nome_uri (varchar(200))<br/>
<input type="text" value="<?php echo $r['nome_uri']; ?>" name="nome_uri"></div>
<div>testo (blob)<br/>
<textarea name="testo"><?php echo $r['testo']; ?></textarea></div>
<div>testo2 (mediumtext)<br/>
<textarea name="testo2"><?php echo $r['testo2']; ?></textarea></div>
	<div>data (datetime)<br/>
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
	<div>visibile (int(1))<br/>
	<?php echo $htmlHelper->_select(array('0','1'),'visibile',$r['visibile'],array($lang['no'],$lang['si'])); ?>	</div>
	<div>inhome (int(1))<br/>
	<?php echo $htmlHelper->_select(array('0','1'),'inhome',$r['inhome'],array($lang['no'],$lang['si'])); ?>	</div>
	<?php 	$aCampi=array();for($i=-50;$i<51;$i++){$aCampi[]=$i;} 	?>
	<div>posizione (int(11))<br/>
	<?php echo $htmlHelper->_select($aCampi,'posizione',$r['posizione'],$aCampi_namePosizione); ?>	</div>
<input type="submit" value="invia">
</form>