<?php
$r=_record($tab,"id",$id_record);
$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
?>
<div>nome (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>
<div>testo (mediumtext)<br/>
<textarea name="testo"><?php echo $r['testo']; ?></textarea></div>
	<div>data_inizio (int(11))<br/>
	<?php
	//creo array settings
	$settings=array(
	'name'=>data_inizio,
	'value'=>$r['data_inizio'],
	'type'=>$value['Type']
	);
	?>
	<?php echo $htmlHelper->_inputData($settings,$value); ?>
	</div>
	<div>data_fine (int(11))<br/>
	<?php
	//creo array settings
	$settings=array(
	'name'=>data_fine,
	'value'=>$r['data_fine'],
	'type'=>$value['Type']
	);
	?>
	<?php echo $htmlHelper->_inputData($settings,$value); ?>
	</div>
<div>location (mediumtext)<br/>
<textarea name="location"><?php echo $r['location']; ?></textarea></div>
<div>contatto (mediumtext)<br/>
<textarea name="contatto"><?php echo $r['contatto']; ?></textarea></div>
<div>more_teacher (varchar(250))<br/>
<input type="text" value="<?php echo $r['more_teacher']; ?>" name="more_teacher"></div>
<input type="submit" value="invia">
</form>
