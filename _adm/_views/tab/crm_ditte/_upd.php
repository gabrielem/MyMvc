<?php
$r=_record($tab,"id",$id_record);
$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
?>
<div>nome (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>
<div>indirizzo (varchar(250))<br/>
<input type="text" value="<?php echo $r['indirizzo']; ?>" name="indirizzo"></div>
<div>paese (varchar(250))<br/>
<input type="text" value="<?php echo $r['paese']; ?>" name="paese"></div>
<div>citta (varchar(250))<br/>
<input type="text" value="<?php echo $r['citta']; ?>" name="citta"></div>
<div>cap (varchar(250))<br/>
<input type="text" value="<?php echo $r['cap']; ?>" name="cap"></div>
<div>descrizione (varchar(250))<br/>
<input type="text" value="<?php echo $r['descrizione']; ?>" name="descrizione"></div>
<div>telefono (varchar(250))<br/>
<input type="text" value="<?php echo $r['telefono']; ?>" name="telefono"></div>
<div>cellulare (varchar(250))<br/>
<input type="text" value="<?php echo $r['cellulare']; ?>" name="cellulare"></div>
<div>email (varchar(250))<br/>
<input type="text" value="<?php echo $r['email']; ?>" name="email"></div>
<div>sito (varchar(250))<br/>
<input type="text" value="<?php echo $r['sito']; ?>" name="sito"></div>
<div>note (mediumtext)<br/>
<textarea name="note"><?php echo $r['note']; ?></textarea></div>
<div>contatto (mediumtext)<br/>
<textarea name="contatto"><?php echo $r['contatto']; ?></textarea></div>
<input type="submit" value="invia">
</form>
