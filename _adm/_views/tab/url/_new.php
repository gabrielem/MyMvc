<?php
$generaForm=new generaForm();
echo _formStart('new','new','new');
?>
<?php echo select(array_merge(array(''),$A_MODELLI),"MOD_VAR",$rSlug['modello']); ?>
<?php echo select(array_merge(array(''),$A_COMPORTAMENTI),"COMP_VAR",$rSlug['comportamento']); ?>
<?php echo select(array('0','1'),"SLUG_RADICE",$rSlug['radice'],array('n','y')); ?>
<div>titolo (varchar(250))<br/>
<input type="text" value="<?php echo $r['titolo']; ?>" name="titolo"></div>
<div>testo (mediumtext)<br/>
<textarea name="testo"><?php echo $r['testo']; ?></textarea></div>
<div>visibile (int(11))<br/>
<input type="text" value="<?php echo $r['visibile']; ?>" name="visibile"></div>
<div>url_rss (varchar(250))<br/>
<input type="text" value="<?php echo $r['url_rss']; ?>" name="url_rss"></div>
<div>url_scambio_ospite (varchar(250))<br/>
<input type="text" value="<?php echo $r['url_scambio_ospite']; ?>" name="url_scambio_ospite"></div>
<div>url_scambio (varchar(250))<br/>
<input type="text" value="<?php echo $r['url_scambio']; ?>" name="url_scambio"></div>
<div>note (varchar(250))<br/>
<input type="text" value="<?php echo $r['note']; ?>" name="note"></div>
<div>ip (varchar(50))<br/>
<input type="text" value="<?php echo $r['ip']; ?>" name="ip"></div>
	<div>data (int(11))<br/>
	<?php
	//creo array settings
	$settings=array(
	'name'=>data,
	'value'=>time(),
	'type'=>$value['Type']
	);
	?>
	<?php echo $htmlHelper->_inputData($settings,$value); ?>
	</div>
<input type="submit" value="invia">
</form>
