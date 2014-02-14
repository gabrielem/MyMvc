
<?php $htmlHelper=new htmlHelper(); ?>


<div id="main">


<?php $r=_record($tab,'id',$id_record); ?>

<?php $creaFormUpd = new generaForm(); 
$creaFormUpd->_formTag('upd'); ?>




<input type="text" name="nome" value="<?php echo $r['nome']; ?>"> 
<?php echo $htmlHelper->_select(array('0','1'),'admin',$r['admin'],array('visibile per tutti','risevato agli admin')); ?>
<?php echo _formSubmit($lang['tasto_salva']); ?>
<br/>
<input type="text" name="posizione" value="<?php echo $r['posizione']; ?>"> 
<input type="text" name="url" value="<?php echo $r['url']; ?>"> 

</form>






<?php 
$a1=array('tab','opz','url');
$a1_name=array('Tabelle','Opzioni','url statiche');
$a2[0]=elencoTAB();
	for($i=0;$i<count($a2[0]);$i++){$a2_name[0][$i]="TAB: ".strtoupper($a2[0][$i]);}
$a2[1]=array('opz1','opz2');
$a2_name[1]=array('OPZIONE 1','OPZIONE 2');
$a2[2]=$URL_ADMIN;

$htmlHelper = new htmlHelper(); 
$selectArray=$htmlHelper->_selectDip($a1,$a2,"selettore","id_s",'nuovoItem',$a1_name,$a2_name); 
?>



<?php echo $selectArray['js'] ?>
<div style="padding:5px; font-size:11px;">
<?php $creaFormNew = new generaForm(); 
$creaFormNew->_formTag('new','nuovoItem'); ?>
<input type="hidden" name="tab" value="<?php echo $tab3[0]; ?>">
<?php echo $lang['MSG_Crea_una_nuova_voce_per_il_menu']; ?><br/>
<input type="text" name="nome" value=""> 
<input type="hidden" name="id_menu" value="<?php echo $id_record; ?>">
<input type="hidden" name="redirect" value="<?php echo $selettoreDati['selettore']."/".$selettoreDati['id_s']."/upd/".$id_record; ?>">


<br/>
<?php echo $selectArray['s1']; ?>
<?php echo $selectArray['s2']; ?>




<?php echo _formSubmit($lang['tasto_invia']); ?>
</form>
</div>



<?php $r2=_loop($tab3[0]," WHERE id_menu='".$id_record."' ");?>

<?php if($r2){ ?>
	<?php for($i=0;$i<count($r2);$i++){ ?>
	<?php echo $r2[$i]['nome']; ?> <?php echo $r2[$i]['selettore']; ?> <?php echo $r2[$i]['id_s']; ?>
	<a href="<?php echo urlMenuAdmin(array('selettore'=>'tab','id_s'=>$tab3[0])); ?>del/<?php echo $r2[$i]['id'] ?>"><?php echo $lang['linkCancellaRecord']; ?></a>
	<br/>
	<?php } ?>
<?php } else { ?>
<?php echo $lang['MSG_nessun_record_trovato']; ?>
<?php } ?>



</div>
