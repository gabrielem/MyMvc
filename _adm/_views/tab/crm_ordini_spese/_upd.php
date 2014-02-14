<?php
$r=_record($tab,"id",$id_record);
$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
?>
<div>nome (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>
<div>costo (decimal(10,2))<br/>
<input type="text" value="<?php echo $r['costo']; ?>" name="costo"></div>
<div>perc (decimal(10,3))<br/>
<input type="text" value="<?php echo $r['perc']; ?>" name="perc"></div>
<input type="submit" value="invia">
</form>
