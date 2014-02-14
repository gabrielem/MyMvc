<?php
$r=_record($tab,"id",$id_record);
$generaForm=new generaForm();
echo _formStart('upd','upd','upd');
?>
<?php $rSlug=_record($TAB_slug,"id2",$id_record," AND tab='".$tab."' "); ?>

<?php if(empty($rSlug['modello']))$rSlug['modello']="test_cat"; ?>
<?php if(empty($rSlug['radice']))$rSlug['radice']="1"; ?>


<?php echo select(array_merge(array(''),$A_MODELLI),"MOD_VAR",$rSlug['modello']); ?>
<?php echo select(array_merge(array(''),$A_COMPORTAMENTI),"COMP_VAR",$rSlug['comportamento']); ?>
<?php echo select(array('0','1'),"SLUG_RADICE",$rSlug['radice'],array('n','y')); ?>
<div>nome (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome']; ?>" name="nome"></div>
<div>nome_uri (varchar(250))<br/>
<input type="text" value="<?php echo $r['nome_uri']; ?>" name="nome_uri"></div>
<input type="submit" value="invia">
</form>
