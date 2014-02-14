<?php
$generaForm=new generaForm();
echo _formStart('new','new','new');
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



<input type="hidden" name="visibile" value="1">
<input type="hidden" name="posizione" value="<?php if(empty($r['posizione'])) {$r['posizione']="0";}echo $r['posizione']; ?>">

<input type="submit" value="save" class="save">

</form>


