<?php
$generaForm=new generaForm();
echo _formStart('new','new','new');
?>
<div>nome (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>
<div>cognome (varchar(250))<br/>
<input type="text" value="<?php echo $r['cognome']; ?>" name="cognome"></div>
<div>email (varchar(200))<br/>
<input type="text" value="<?php echo $r['email']; ?>" name="email"></div>
	<div>data_iscrizione (int(11))<br/>
	<?php
	//creo array settings
	$settings=array(
	'name'=>data_iscrizione,
	'value'=>time(),
	'type'=>$value['Type']
	);
	?>
	<?php echo $htmlHelper->_inputData($settings,$value); ?>
	</div>
	<div>data_nascita (int(11))<br/>
	<?php
	//creo array settings
	$settings=array(
	'name'=>data_nascita,
	'value'=>time(),
	'type'=>$value['Type']
	);
	?>
	<?php echo $htmlHelper->_inputData($settings,$value); ?>
	</div>
<div>indirizzo (varchar(250))<br/>
<input type="text" value="<?php echo $r['indirizzo']; ?>" name="indirizzo"></div>
<div>citta (varchar(250))<br/>
<input type="text" value="<?php echo $r['citta']; ?>" name="citta"></div>
<div>provincia (varchar(250))<br/>
<input type="text" value="<?php echo $r['provincia']; ?>" name="provincia"></div>
<div>regione (varchar(250))<br/>
<input type="text" value="<?php echo $r['regione']; ?>" name="regione"></div>
<div>paese (varchar(250))<br/>
<input type="text" value="<?php echo $r['paese']; ?>" name="paese"></div>
<div>cap (varchar(10))<br/>
<input type="text" value="<?php echo $r['cap']; ?>" name="cap"></div>
<div>telefono (varchar(50))<br/>
<input type="text" value="<?php echo $r['telefono']; ?>" name="telefono"></div>
<div>cellulare (varchar(50))<br/>
<input type="text" value="<?php echo $r['cellulare']; ?>" name="cellulare"></div>
<div>cf (varchar(30))<br/>
<input type="text" value="<?php echo $r['cf']; ?>" name="cf"></div>
<div>codice (varchar(250))<br/>
<input type="text" value="<?php echo $r['codice']; ?>" name="codice"></div>
<div>note (mediumtext)<br/>
<textarea name="note"><?php echo $r['note']; ?></textarea></div>
<input type="submit" value="invia">
</form>
