<?php
$generaForm=new generaForm();
echo _formStart('new','new','new');
?>

<?php if($_SESSION['admin_level']=="1") { ?>
<?php echo select(array_merge(array(''),$A_MODELLI),"MOD_VAR",$rSlug['modello']); ?>
<?php echo select(array_merge(array(''),$A_COMPORTAMENTI),"COMP_VAR",$rSlug['comportamento']); ?>
<?php echo select(array('0','1'),"SLUG_RADICE",$rSlug['radice'],array('n','y')); ?>
<?php } else { ?>
<input type="hidden" name="MOD_VAR" value="text">
<input type="hidden" name="SLUG_RADICE" value="1">
<?php }  ?>


<!--
<div>LANG<br/><input type="text" value="<?php echo $r['lang']; ?>" name="lang"></div>
<div>Menu Up<br/><input type="text" value="<?php echo $r['menu_up']; ?>" name="menu_up"></div>

-->

<input type="hidden" name="lang" value="en">



<div>
Assegna alla sezione
<br />
<select name="id_sezioni">
<?php if(is_array($datiComportamento['LOOP_SEZIONI'])){ ?>
<option value="0">nessuna</option>
	<?php for($i=0;$i<count($datiComportamento['LOOP_SEZIONI']);$i++){?>
	<option value="<?php echo $datiComportamento['LOOP_SEZIONI'][$i]['id']; ?>"<?php
		if($datiComportamento['LOOP_SEZIONI'][$i]['id']==$r['id_sezioni']) { echo " selected"; }
	?>><?php 
	echo $datiComportamento['LOOP_SEZIONI'][$i]['nome']; ?></option>
	<?php } ?>
<?php } else { ?>
<option value="0">errore: non trovo sezioni...</option>
<?php } ?>

</select>
</div>





	<div>Insert in Menu<br/>
	<?php echo $htmlHelper->_select(array('0','1'),'toolbar_nologin',$r['toolbar_nologin'],array($lang['no'],$lang['yes'])); ?>	</div>


<div>
Menu Name<br/>
<input type="text" value="<?php echo $r['voce_menu']; ?>" name="voce_menu">
</div>


<div>Title<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>
<?php echo $generaForm->_hidden("nome_uri",$r[nome_uri]); ?>

<div class="txtEditor">
Content<br/>

<?php	
$editor_textarea['id']="ed_2";
$editor_textarea['name']="testo";
$editor_textarea['value']=$r['testo'];
$editor_textarea['w']="700px";
$editor_textarea['h']="350px";
include($rootAssoluta.$dirADMIN."editor_textarea.php");
?>
</div>




<!-- 
	<div>data (datetime)<br/>
	<?php
	//creo array settings
	$settings=array(
	'name'=>data,
	'value'=>time(),
	'type'=>$value['Type']
	);
	?>
	<?php echo $htmlHelper->_inputData($settings,$value); ?>
	</div>
--> 

<input type="hidden" name="datadd" value="<?php echo date("d",time()); ?>">
<input type="hidden" name="datamm" value="<?php echo date("m",time()); ?>">
<input type="hidden" name="datayyyy" value="<?php echo date("Y",time()); ?>">

<!-- 
	<div>visibile (int(1))<br/>
	<?php echo $htmlHelper->_select(array('0','1'),'visibile',$r['visibile'],array($lang['no'],$lang['si'])); ?>	</div>
-->

<input type="hidden" name="visibile" value="1">


<!-- 
	<div>inhome (int(1))<br/>
	<?php echo $htmlHelper->_select(array('0','1'),'inhome',$r['inhome'],array($lang['no'],$lang['si'])); ?>	</div>
	<div>toolbar_login (int(1))<br/>
	<?php echo $htmlHelper->_select(array('0','1'),'toolbar_login',$r['toolbar_login'],array($lang['no'],$lang['si'])); ?>	</div>
-->
<input type="hidden" name="toolbar_login" value="0">


<!-- 
	<?php 	$aCampi=array();for($i=-50;$i<51;$i++){$aCampi[]=$i;} 	?>
	<div>posizione (int(11))<br/>
	<?php echo $htmlHelper->_select($aCampi,'posizione',$r['posizione'],$aCampi_namePosizione); ?>	</div>
-->

<input type="hidden" name="posizione" value="<?php if(empty($r['posizione'])) {$r['posizione']="0";}echo $r['posizione']; ?>">

<input type="submit" value="save" class="save">

</form>


