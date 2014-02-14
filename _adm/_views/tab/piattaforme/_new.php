<?php
$generaForm=new generaForm();
echo _formStart('new','new','new');
?>
<div>nome (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>
<div>testo (varchar(250))<br/>
<input type="text" value="..." name="testo"></div>
<div>visibile (int(11))<br/>
<input type="text" value="1" name="visibile"></div>
	<?php 	$aCampi=array();for($i=-50;$i<51;$i++){$aCampi[]=$i;} 	?>
	<div>posizione (int(11))<br/>
	<?php echo $htmlHelper->_select($aCampi,'posizione',$r['posizione'],$aCampi_namePosizione); ?>	</div>
<input type="submit" value="invia">
</form>
