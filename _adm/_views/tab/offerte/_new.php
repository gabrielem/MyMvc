<?php
$generaForm=new generaForm();
echo _formStart('new','new','new');
?>
<div>euro (varchar(10))<br/>
<input type="text" value="<?php echo $r['euro']; ?>" name="euro"></div>
<div>special_gift (varchar(250))<br/>
<input type="text" value="<?php echo $r['special_gift']; ?>" name="special_gift"></div>
<div>testo_breve (varchar(250))<br/>
<input type="text" value="<?php echo $r['testo_breve']; ?>" name="testo_breve"></div>
<div>testo (mediumtext)<br/>
<textarea name="testo"><?php echo $r['testo']; ?></textarea></div>
<div>visibile (int(11))<br/>
<input type="text" value="<?php echo $r['visibile']; ?>" name="visibile"></div>
	<?php 	$aCampi=array();for($i=-50;$i<51;$i++){$aCampi[]=$i;} 	?>
	<div>posizione (int(11))<br/>
	<?php echo $htmlHelper->_select($aCampi,'posizione',$r['posizione'],$aCampi_namePosizione); ?>	</div>
<input type="submit" value="invia">
</form>
