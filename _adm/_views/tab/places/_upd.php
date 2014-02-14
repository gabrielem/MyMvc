<?php
$r=_record($tab,"id",$id_record);
$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
?>

<input type="hidden" name="MOD_VAR" value="places">
<input type="hidden" name="COMP_VAR" value="">
<input type="hidden" name="SLUG_RADICE" value="0">


<div>Title<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>
<!-- 
<div>slug (varchar(250))<br/>
<input type="text" value="<?php echo $r['slug']; ?>" name="slug"></div>
-->

<div class="txtEditor">
Content<br/>

<?php	
$editor_textarea['id']="ed_2";
$editor_textarea['name']="text";
$editor_textarea['value']=$r['text'];
$editor_textarea['w']="700px";
$editor_textarea['h']="190px";
include($rootAssoluta.$dirADMIN."editor_textarea.php");
?>
</div>

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


<input type="hidden" name="visibile" value="1">
<input type="hidden" name="posizione" value="<?php echo $r['posizione']; ?>">

<input type="submit" value="save" class="save">

</form>


