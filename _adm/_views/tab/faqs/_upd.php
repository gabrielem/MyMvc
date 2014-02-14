<?php
$r=_record($tab,"id",$id_record);
$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
?>
<div>question (varchar(250))<br/>
<input type="text" value="<?php echo $r['question']; ?>" name="question"></div>
<!-- 
<div>answers (varchar(250))<br/>
<input type="text" value="<?php echo $r['answers']; ?>" name="answers"></div>
-->

<div class="txtEditor">
Answers <br/>

<?php	
$editor_textarea['id']="ed_2";
$editor_textarea['name']="answers";
$editor_textarea['value']=$r['answers'];
$editor_textarea['w']="700px";
$editor_textarea['h']="180px";
include($rootAssoluta.$dirADMIN."editor_textarea.php");
?>
</div>

<!-- 
<div>visible (int(11))<br/>
<input type="text" value="<?php echo $r['visible']; ?>" name="visible"></div>
<div>position (int(11))<br/>
<input type="text" value="<?php echo $r['position']; ?>" name="position"></div>
-->

<input type="hidden" name="visibile" value="<?php echo $r['visibile']; ?>">
<input type="hidden" name="posizione" value="<?php echo $r['posizione']; ?>">

<input type="submit" value="save" class="save">

</form>
