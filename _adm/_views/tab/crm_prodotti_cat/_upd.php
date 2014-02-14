<?php
$r=_record($tab,"id",$id_record);
$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
?>
<div>nome (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>
<div>descrizione (varchar(250))<br/>
<input type="text" value="<?php echo $r['descrizione']; ?>" name="descrizione"></div>
<input type="submit" value="invia">
</form>
