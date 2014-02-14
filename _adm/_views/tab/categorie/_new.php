<?php
$generaForm=new generaForm();
echo _formStart('new','new','new');
?>
<?php echo select(array_merge(array(''),$A_MODELLI),"MOD_VAR",$rSlug['modello']); ?>
<?php echo select(array_merge(array(''),$A_COMPORTAMENTI),"COMP_VAR",$rSlug['comportamento']); ?>
<?php echo select(array('0','1'),"SLUG_RADICE",$rSlug['radice'],array('n','y')); ?>
<div>nome (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>
<?php echo $generaForm->_hidden("nome_uri",$r[nome_uri]); ?>
<div>testo (mediumtext)<br/>
<textarea name="testo"><?php echo $r['testo']; ?></textarea></div>
<div>visibile (int(11))<br/>
<input type="text" value="<?php echo $r['visibile']; ?>" name="visibile"></div>
	<?php 	$aCampi=array();for($i=-50;$i<51;$i++){$aCampi[]=$i;} 	?>
	<div>posizione (int(11))<br/>
	<?php echo $htmlHelper->_select($aCampi,'posizione',$r['posizione'],$aCampi_namePosizione); ?>	</div>
<input type="submit" value="invia">
</form>
