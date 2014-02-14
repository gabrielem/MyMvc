<?php
$generaForm=new generaForm();
echo _formStart('new','new','new');
?>
<div>nome (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>
<div>descrizione (varchar(250))<br/>
<input type="text" value="<?php echo $r['descrizione']; ?>" name="descrizione"></div>
<input type="submit" value="invia">
</form>
