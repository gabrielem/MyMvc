<?php $tabElenco=elencoTAB(); ?>
<?php $IMG=new IMG(); ?>

<?php
if($_GET['canc']!="" && in_array($_GET['canc'],$tabElenco)) {

	//cancello l'eventuale file dei dati	
	unlink($rootAssolutaImg.$_GET['canc']."/.dati");
	//poi cancello la directory
	if(rmdir($rootAssolutaImg.$_GET['canc']."/"))
	{
	$htmlHelper->setFlash("msg", $lang['MSG_dirctoryTabCancellata']);
	}
	else
	{
	$htmlHelper->setFlash("msg", $lang['MSG_dirctoryTabNonCancellata']);
	}
Header("Location: ".$selettoreUrl);
}


if($_GET['crea']!="" && in_array($_GET['crea'],$tabElenco)) {

	if(mkdir($rootAssolutaImg.$_GET['crea']."/"))
	{
	$htmlHelper->setFlash("msg", $lang['MSG_dirctoryTabCreata']);
	}
	else
	{
	$htmlHelper->setFlash("msg", $lang['MSG_dirctoryTabNonCreata']);
	}
Header("Location: ".$selettoreUrl);
}


//pr($_POST);

if($_POST['dati']=="1") {
echo 'aggiorno dati';
$dati ='<?php'."\n";
$dati.='#TAB: "'.$_POST['tab'].'";'."\n";

	for($i=1;$i<count($SET_IMG);$i++)
	{
$dati.="\n".'#$SET_IMG: "'.$SET_IMG[$i].'";'."\n";

$nome_W="w".$SET_IMG[$i];
$nome_H="h".$SET_IMG[$i];
	
$dati.='$w'.$SET_IMG[$i].'="'.$_POST['w'.$SET_IMG[$i]].'";'."\n";
$dati.='$h'.$SET_IMG[$i].'="'.$_POST['h'.$SET_IMG[$i]].'";'."\n";
	}

$dati.='?>'."\n";
$path_file=$rootAssolutaImg.$_POST['tab']."/.dati";
	if(write($path_file,$dati))
	{
	$htmlHelper->setFlash("msg", $lang['MSG_datiSalvati']);
	}
	else
	{
	$htmlHelper->setFlash("msg", $lang['MSG_datiNonSalvati']);
	}
//Header("Location: ".$selettoreUrl);
}
?>







<table cellspacing="3" cellpadding="9" border="0">
<?php for($i=0;$i<count($tabElenco);$i++){ ?>


<tr bgcolor="#efefff">
<td valign="top"><?php echo $tabElenco[$i]; ?></td>

<?php $generaForm = new generaForm(); 
$generaForm->_formTag('dati','dati'); ?>
<?php echo $generaForm->_hidden("tab",$tabElenco[$i]); ?>

<td valign="top">
	<?php if(!$IMG->checkDir($tabElenco[$i])){ ?>
	<?php echo $lang['MSG_DirectryImgTabNonEsiste']; ?>
	<?php echo $htmlHelper->_link(array('SELETTORE','crea/'.$tabElenco[$i]),$lang['MSG_creaDirectoryTab']); ?>

	<?php } else { ?>

<?php 
//directory esistente 
?>

	<?php echo $lang['MSG_DirectryImgTabEsiste']; ?>
	<?php echo $htmlHelper->_link(array('SELETTORE','canc/'.$tabElenco[$i]),$lang['MSG_cancellaDirectoryTab']); ?>	


<?php @include($rootAssolutaImg.$tabElenco[$i]."/.dati"); ?>

<!-- LOOP TIPI DI IMG -->

<div style="font-size:11px; background:#ffffff;border:1px #afafaf solid;padding:9px;margin:3px;">
<b><?php echo $lang['MSG_impostaDimensioniImg']; ?></b><br/><br/>

<?php for($i2=1;$i2<count($SET_IMG);$i2++) { ?>



	<?php
	$nome_W="w".$SET_IMG[$i2];
	$nome_H="h".$SET_IMG[$i2];
	?>
	
	<b><?php echo $SET_IMG[$i2]; ?></b><br/>
	<?php echo $lang['CAMPO_larghezza']; ?>
	<input type="text" name="<?php echo $nome_W; ?>" size="1" value="<?php echo $$nome_W; ?>">
	<?php echo $lang['CAMPO_altezza']; ?>
	<input type="text" name="<?php echo $nome_H; ?>" size="1" value="<?php echo $$nome_H; ?>">
	<input type="submit">
	<br/><br/>

<?php } ?>


<!-- LOOP TIPI DI IMG -->
	
	
</div>

	<?php } ?>
	
</td>
</form>
</tr>
<?php } ?>
</table>

