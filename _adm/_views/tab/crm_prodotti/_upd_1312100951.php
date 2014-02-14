<?php
$r=_record($tab,"id",$id_record);
$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
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
<?php
		if(!empty($r['nome_uri']))
		{
		$generaForm=new generaForm();
		$formIMG=$generaForm->_hidden("nome_uri_save",$r['nome_uri']);
		$formIMG.=$generaForm->_hidden("campoImgUpload",'img'); //deve essere uguale al nome del FormImg
		$formIMG.=$generaForm->_img('img',$r);
		}
		else
		{
		$formIMG="<p class=\"red\">".$lang['MSG_MancaCampoNomeUriPerImg']."</p>";
		}
	?>
<?php echo $formIMG;  ?>
<input type="submit" value="invia">
</form>
