<?php
$r=_record($tab,"id",$id_record);
$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
?>


<?php $rSlug=_record($TAB_slug,"id2",$id_record," AND tab='".$tab."' "); ?>
<?php //pr($rSlug); ?>

<?php if($_SESSION['admin_level']=="1") { ?>




<?php echo select(array_merge(array(''),$A_MODELLI),"MOD_VAR",$rSlug['modello']); ?>
<?php echo select(array_merge(array(''),$A_COMPORTAMENTI),"COMP_VAR",$rSlug['comportamento']); ?>
<?php echo select(array('0','1'),"SLUG_RADICE",$rSlug['radice'],array('n','y')); ?>

<?php } else { ?>

<input type="hidden" name="MOD_VAR" value="<?php echo $rSlug['modello']; ?>">
<input type="hidden" name="COMP_VAR" value="<?php echo $rSlug['comportamento']; ?>">
<input type="hidden" name="SLUG_RADICE" value="<?php echo $rSlug['radice']; ?>">

<?php }  ?>

<?php
/*
$A_GRUPPI_UTENTI=_loop($TAB_utenti_cat);
for($i=0;$i<count($A_GRUPPI_UTENTI);$i++)
{
$A_GRUPPI_UTENTI_ID[]=$A_GRUPPI_UTENTI[$i]['id'];
$A_GRUPPI_UTENTI_NOME[]=$A_GRUPPI_UTENTI[$i]['nome']." (".$A_GRUPPI_UTENTI[$i]['id'].")";
}
*/
//echo select(array_merge(array(''),$A_GRUPPI_UTENTI_ID),"LOGIN_GROUP",$rSlug['login'],array_merge(array('No LOGIN?'),$A_GRUPPI_UTENTI_NOME)); 
?>


<!-- 
<div>
LANG<br/>
<input type="text" value="<?php echo $r['lang']; ?>" name="lang">
</div>
-->
<input type="hidden" name="lang" value="en">


<div>
Assegna alla sezione
<br />
<select name="id_sezioni">
<?php if(is_array($datiComportamento['LOOP_SEZIONI'])){ ?>
<option value="0">nessuna</option>
	<?php for($i=0;$i<count($datiComportamento['LOOP_SEZIONI']);$i++){?>
		
		<?php if($datiComportamento['LOOP_SEZIONI'][$i]['id']!=$r['id']){ ?>
		
			<option value="<?php echo $datiComportamento['LOOP_SEZIONI'][$i]['id']; ?>"<?php
				if($datiComportamento['LOOP_SEZIONI'][$i]['id']==$r['id_sezioni']) { echo " selected"; }
			?>><?php 
			echo $datiComportamento['LOOP_SEZIONI'][$i]['nome']; ?></option>
		<?php } ?>
		
	<?php } ?>
<?php } else { ?>
<option value="0">errore: non trovo sezioni...</option>
<?php } ?>

</select>
</div>



    

	<div>Insert in Menu<br/>
	<?php echo $htmlHelper->_select(array('0','1'),'toolbar_nologin',$r['toolbar_nologin'],array("no","yes")); ?>	</div>



<div>
Menu Name<br/>
<input type="text" value="<?php echo $r['voce_menu']; ?>" name="voce_menu">
</div>


<div>Title<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>




<?php if($_SESSION['admin_level']=="1") { ?>
<div>nome_uri<br/>
<input type="text" value="<?php echo $r['nome_uri']; ?>" name="nome_uri"></div>
<?php } else { ?>
<?php echo $generaForm->_hidden("nome_uri",$r[nome_uri]); ?>
<?php }  ?>



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
	'value'=>$r['data'],
	'type'=>$value['Type']
	);
	?>
	<?php echo $htmlHelper->_inputData($settings,$value); ?>
	</div>
-->

<input type="hidden" name="datadd" value="<?php echo date("d",$r['data']); ?>">
<input type="hidden" name="datamm" value="<?php echo date("m",$r['data']); ?>">
<input type="hidden" name="datayyyy" value="<?php echo date("Y",$r['data']); ?>">

<!-- 
	<div>visibile (int(1))<br/>
	<?php echo $htmlHelper->_select(array('0','1'),'visibile',$r['visibile'],array($lang['no'],$lang['si'])); ?>	</div>
-->

<input type="hidden" name="visibile" value="<?php echo $r['visibile']; ?>">

<!-- 
	<div>toolbar_login (int(1))<br/>
	<?php echo $htmlHelper->_select(array('0','1'),'toolbar_login',$r['toolbar_login'],array($lang['no'],$lang['si'])); ?>	</div>
	<div>toolbar_nologin (int(1))<br/>
	<?php echo $htmlHelper->_select(array('0','1'),'toolbar_nologin',$r['toolbar_nologin'],array($lang['no'],$lang['si'])); ?>	</div>

-->
<input type="hidden" name="toolbar_login" value="0">
    


<!-- 
	<?php 	$aCampi=array();for($i=-50;$i<51;$i++){$aCampi[]=$i;} 	?>
	<div>posizione (int(11))<br/>
	<?php echo $htmlHelper->_select($aCampi,'posizione',$r['posizione'],$aCampi_namePosizione); ?>	</div>
-->

<input type="hidden" name="posizione" value="<?php echo $r['posizione']; ?>">

<input type="submit" value="save" class="save">
</form>
