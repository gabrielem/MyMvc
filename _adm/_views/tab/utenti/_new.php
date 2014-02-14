<?php
$generaForm=new generaForm();
echo _formStart('new','new','new');
?>
<?php echo $htmlHelper->filtroRelazione($tab,$tab2[0],'molti-a-uno','id_utenti_cat',$r['id_utenti_cat'],false,false); ?>
<div>nome (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>
<div>cognome (varchar(250))<br/>
<input type="text" value="<?php echo $r['cognome']; ?>" name="cognome"></div>
<div>email (varchar(200))<br/>
<input type="text" value="<?php echo $r['email']; ?>" name="email"></div>
<div>password (varchar(200))<br/>
<input type="text" value="<?php echo $r['password']; ?>" name="password"></div>
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
<div>attivo (int(11))<br/>
<input type="text" value="<?php echo $r['attivo']; ?>" name="attivo"></div>
<div>bannato (int(11))<br/>
<input type="text" value="<?php echo $r['bannato']; ?>" name="bannato"></div>
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
<div>segue_rinpoche_dal (varchar(50))<br/>
<input type="text" value="<?php echo $r['segue_rinpoche_dal']; ?>" name="segue_rinpoche_dal"></div>
<div>primo_livello (varchar(50))<br/>
<input type="text" value="<?php echo $r['primo_livello']; ?>" name="primo_livello"></div>
<div>secondo_livello (varchar(50))<br/>
<input type="text" value="<?php echo $r['secondo_livello']; ?>" name="secondo_livello"></div>
<input type="submit" value="invia">
</form>
