<?php $tabElenco=elencoTAB(); ?>
<?php $generaForm=new generaForm(); ?>


<h1><?php echo $lang['TIT_Crea_una_relazione']; ?>:</h1>

<?php echo _formStart("CLEAR"); ?>
<?php echo _formSubmit($lang['tasto_azzera_relazioni']); ?>
</form>
<br/>


<?php echo _formStart("ADD"); ?>
<div>
Per la tabella:<br/>
<?php echo $htmlHelper->_select($tabElenco,'tab1'); ?>
</div>

<div>
Con la tabella:<br/>
<?php echo $htmlHelper->_select($tabElenco,'tab2'); ?>
</div>

<div>
Di tipo:<br/>
<?php echo $htmlHelper->_select($RELAZIONI_TYPE,'tipo'); ?>
</div>

<?php echo _formSubmit($lang['tasto_aggiorna_relazioni']); ?>

</form>


<br/>
<?php if(is_array($RELAZIONI_DB_ARRAY)){ ?>
<table width="500" celspacing="0" celpadding="15" border="0">
<tr style="font-size:11px;">
<th>tab1</th>
<th>tab2</th>
<th>tipo</th>
<th></th>
</tr>
	<?php for($i=0;$i<count($RELAZIONI_DB_ARRAY);$i++){ ?>
<tr>
<td style="background:#efefef; font-size:11px;"><?php echo "".$RELAZIONI_DB_ARRAY[$i]['tab1']; ?></td>
<td style="background:#efefef; font-size:11px;"><?php echo "".$RELAZIONI_DB_ARRAY[$i]['tab2']; ?></td>
<td style="background:#efefef; font-size:11px;"><?php echo "".$RELAZIONI_DB_ARRAY[$i]['tipo']; ?></td>

<?php echo _formStart("DEL"); ?>
<?php echo $generaForm->_hidden("indice",$i); ?>
<td><?php echo _formSubmit("DELETE"); ?></td>
</form>

</tr>
	<?php } ?>
<?php } ?>
</table>

<?php //pr($RELAZIONI_DB_ARRAY); ?>

<?php 
$urlToGo=urlMenuAdmin(array('selettore'=>'url','id_s'=>'_relazioni_db'));
	if($_POST['DEL']!="" || $_POST['ADD']!=""){

		$mem_START='<?php'."\n";
		
		$mem_START.='$RELAZIONI_DB_ARRAY=array();'."\n";

		$mem_arrayRighe=array();
		for($i=0;$i<count($RELAZIONI_DB_ARRAY);$i++){
			
		//memorizzo gli array presenti
		$mem='$RELAZIONI_DB_ARRAY[]=';
		$mem.="array('tab1'=>'".$RELAZIONI_DB_ARRAY[$i]['tab1']."',";
		$mem.="'tab2'=>'".$RELAZIONI_DB_ARRAY[$i]['tab2']."',";
		$mem.="'tipo'=>'".$RELAZIONI_DB_ARRAY[$i]['tipo']."');\n";
		
			
			
			//se corrisponde all'indice lo cancello
			if(isset($_POST['indice']) && $_POST['indice']==$i){$mem="";}
			
			echo '<p>mem '.$mem.'</p>';
			
			if(!empty($mem))
			{
			//echo '<p>memorizzo '.$i.'</p>';
			$mem_arrayRighe[]=$mem;
			}
		}
		$mem2="";
			if($_POST['ADD']!="")
			{
//echo '<p>agg '.$i.'</p>';
		$mem2.='$RELAZIONI_DB_ARRAY[]=';
		$mem2.="array('tab1'=>'".$_POST['tab1']."','tab2'=>'".$_POST['tab2']."','tipo'=>'".$_POST['tipo']."');\n";
		$mem_arrayRighe[]=$mem2;
			}
		
		$mem_END.='?>';


		//ricompongo array:
		for($i=0;$i<count($mem_arrayRighe);$i++)
		{
		//echo "<p>".$i."</p>";
		$mem_array.=$mem_arrayRighe[$i];
		}
		
		$mem_array=$mem_START.$mem_array.$mem_END;
		
		
		
//echo "<textarea style='width:100%;height:200px;'>".$mem_array."</textarea>";
		
		//SCRIVO IL FILE
/**/
		if(write($fileRELAZIONI_DB,$mem_array)){
		$htmlHelper->setFlash('msg',$lang['aggiornamentoRelazioniRiuscito']); 
		} else {
		$htmlHelper->setFlash('msg',$lang['aggiornamentoRelazioniNonRiuscito']); 
		}
	//header("location: ".$urlToGo);


	}


	if($_POST['CLEAR']!=""){
		if(write($fileRELAZIONI_DB,"")){
		echo $lang['aggiornamentoRelazioniRiuscito'];
		} else {
		echo $lang['aggiornamentoRelazioniNonRiuscito'];
		}
	header("location: ".$urlToGo);
	}


?>
