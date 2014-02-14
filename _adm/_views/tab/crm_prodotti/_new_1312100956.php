<?php
$generaForm=new generaForm();
echo _formStart('new','new','new');
?>
<div>nome (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>
<?php echo $htmlHelper->filtroRelazione($tab,$tab2[1],'molti-a-uno','id_crm_prodotti_tipi',$r['id_crm_prodotti_tipi'],false,false); ?>
<?php echo $htmlHelper->filtroRelazione($tab,$tab2[0],'molti-a-uno','id_crm_prodotti_cat',$r['id_crm_prodotti_cat'],false,false); ?>
<div>descrizione (mediumtext)<br/>
<textarea name="descrizione"><?php echo $r['descrizione']; ?></textarea></div>
<div>codice (varchar(200))<br/>
<input type="text" value="<?php echo $r['codice']; ?>" name="codice"></div>
<?php echo $htmlHelper->filtroRelazione($tab,$tab2[2],'molti-a-uno','id_crm_ditte',$r['id_crm_ditte'],false,false); ?>
<input type="submit" value="invia">
</form>
