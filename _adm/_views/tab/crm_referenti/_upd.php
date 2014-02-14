<?php
$r=_record($tab,"id",$id_record);
$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
?>
<div>nome (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>
<div>cognome (varchar(250))<br/>
<input type="text" value="<?php echo $r['cognome']; ?>" name="cognome"></div>
<div>email (varchar(250))<br/>
<input type="text" value="<?php echo $r['email']; ?>" name="email"></div>
<div>telefono (varchar(250))<br/>
<input type="text" value="<?php echo $r['telefono']; ?>" name="telefono"></div>
<div>cellulare (varchar(250))<br/>
<input type="text" value="<?php echo $r['cellulare']; ?>" name="cellulare"></div>
<div>note (varchar(250))<br/>
<input type="text" value="<?php echo $r['note']; ?>" name="note"></div>
<?php echo $htmlHelper->filtroRelazione($tab,$tab2[0],'molti-a-uno','id_crm_ditte',$r['id_crm_ditte'],false,false); ?>
<input type="submit" value="invia">
</form>
