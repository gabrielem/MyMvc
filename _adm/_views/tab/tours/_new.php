<?php
$generaForm=new generaForm();
echo _formStart('new','new','new');
?>



<div>Title<br/>
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
$editor_textarea['value']=$r['testo'];
$editor_textarea['w']="700px";
$editor_textarea['h']="350px";
include($rootAssoluta.$dirADMIN."editor_textarea.php");
?>
</div>


<input type="hidden" name="visibile" value="1">
<input type="hidden" name="posizione" value="<?php if(empty($r['posizione'])) {$r['posizione']="0";}echo $r['posizione']; ?>">

<input type="submit" value="save" class="save">

</form>
