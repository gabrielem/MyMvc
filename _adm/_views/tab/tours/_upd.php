<?php
$r=_record($tab,"id",$id_record);
//pr($r);
$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
?>


<div>nome (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>

<?php echo $generaForm->_hidden("nome_uri",$r[nome_uri]); ?>


<div id="div33">Cost<br/>
<input type="text" value="<?php echo $r['cost']; ?>" name="cost" style="width:210px"></div>
<div id="div33">Time<br/>
<input type="text" value="<?php echo $r['time']; ?>" name="time" style="width:210px"></div>
<div id="div33">Duration<br/>
<input type="text" value="<?php echo $r['duration']; ?>" name="duration" style="width:210px"></div>
<div id="clear"></div>


<div>Description<br/>
<?php	
$editor_textarea['id']="ed_2";
$editor_textarea['name']="text";
$editor_textarea['value']=$r['text'];
$editor_textarea['w']="700px";
$editor_textarea['h']="350px";
include($rootAssoluta.$dirADMIN."editor_textarea.php");
?>
</div>


<!-- 
<div>visible (int(11))<br/>
<input type="text" value="<?php echo $r['visible']; ?>" name="visible"></div>
<div>position (int(11))<br/>
<input type="text" value="<?php echo $r['position']; ?>" name="position"></div>
-->

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


<input type="hidden" name="visibile" value="<?php echo $r['visibile']; ?>">
<input type="hidden" name="posizione" value="<?php echo $r['posizione']; ?>">

<input type="submit" value="save" class="save">


</form>
