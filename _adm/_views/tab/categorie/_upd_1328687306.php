<?php
$r=_record($tab,"id",$id_record);
$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
?>
<?php $rSlug=_record($TAB_slug,"id2",$id_record," AND tab='".$tab."' "); ?>
<?php echo select(array_merge(array(''),$A_MODELLI),"MOD_VAR",$rSlug['modello']); ?>
<?php echo select(array_merge(array(''),$A_COMPORTAMENTI),"COMP_VAR",$rSlug['comportamento']); ?>
<?php echo select(array('0','1'),"SLUG_RADICE",$rSlug['radice'],array('n','y')); ?>
<div>nome (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>
<div>nome_uti (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome_uti']; ?>" name="nome_uti"></div>
<div>testo (mediumtext)<br/>
<textarea name="testo"><?php echo $r['testo']; ?></textarea></div>
<div>visibile (int(11))<br/>
<input type="text" value="<?php echo $r['visibile']; ?>" name="visibile"></div>
	<?php 	$aCampi=array();for($i=-50;$i<51;$i++){$aCampi[]=$i;} 	?>
	<div>posizione (int(11))<br/>
	<?php echo $htmlHelper->_select($aCampi,'posizione',$r['posizione'],$aCampi_namePosizione); ?>	</div>
<input type="submit" value="invia">
</form>
