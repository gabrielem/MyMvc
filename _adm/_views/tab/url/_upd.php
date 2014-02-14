<?php
$r=_record($tab,"id",$id_record);
$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
?>
<?php $rSlug=_record($TAB_slug,"id2",$id_record," AND tab='".$tab."' "); ?>
<?php echo select(array_merge(array(''),$A_MODELLI),"MOD_VAR",$rSlug['modello']); ?>
<?php echo select(array_merge(array(''),$A_COMPORTAMENTI),"COMP_VAR",$rSlug['comportamento']); ?>
<?php echo select(array('0','1'),"SLUG_RADICE",$rSlug['radice'],array('n','y')); ?>

<input type="hidden" value="<?php echo $r['id_categorie']; ?>" name="id_categorie">
<input type="hidden" value="<?php echo $r['id_utenti']; ?>" name="id_utenti">
<input type="hidden" value="<?php echo $r['id_claim']; ?>" name="id_claim">

<div>twitter_user (varchar(250))<br/>
<input type="text" value="<?php echo $r['twitter_user']; ?>" name="twitter_user"></div>

<div>URL del sito (varchar(250))<br/>
<input type="text" value="<?php echo $r['url']; ?>" name="url"></div>


<div>nome_uri (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome_uri']; ?>" name="nome_uri"></div>

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
	'value'=>$r['data'],
	'type'=>$value['Type']
	);
	?>
	<?php echo $htmlHelper->_inputData($settings,$value); ?>
	</div>
<input type="submit" value="invia">
</form>
