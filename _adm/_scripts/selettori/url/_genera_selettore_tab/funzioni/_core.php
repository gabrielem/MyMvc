<?php
function checkAzione($t,$a)
{
global $rootAssoluta;
global $dirADMIN;

$a=strtolower($a);
	
	$file=$rootAssoluta.$dirADMIN."_views/tab/".$t."/_".$a.".php";
	if(file_exists($file))
	{
	return true;
	}
	return false;
}



function generaIndex($t)
{
$campiTab=campiTab($t,"1");
#pr($campiTab);
#########
## selectCat
$html.='<?php $selectCat=$htmlHelper->filtroRelazione($tab,$tab2,$tipoRelazioneDB,"id2",$FILTRO_id2); ?>'."\n";
###################

### LOOP DEI FILTRI NECESSARI... (come si sceglie i filtri necessari?) 1. con int(1), 2. con tab molti-a-uno
if(!empty($selectFiltri))
{
	for($i=0;$i<count($selectFiltri);$i++)
	{
	$html.='<?php echo $selectFiltriName[$i].": ".$selectFiltri['.$i.']; ?>'."\n";
	}
}



### paginazione
$html.='<?php if($paginate){ ?>
<p>
<?php if($paginate[\'indietro\']) {?><a href="<?php echo $selettoreUrl."pag/".$paginate[\'indietro\']; ?>">indietro</a><?php } ?>&nbsp;
	<?php for($i=1;$i<$paginate[\'totPagine\'];$i++){ ?>
	<a href="<?php echo $selettoreUrl."pag/".$i; ?>"<?php if($i==$paginate[\'pag\']){echo \' class="sel" \';} ?>><?php echo $i; ?></a>&nbsp;
	<?php } ?>
<?php if($paginate[\'avanti\']) {?><a href="<?php echo $selettoreUrl."pag/".$paginate[\'avanti\']; ?>">avanti</a><?php } ?>&nbsp;
</p>
<?php } ?>'."\n";


### link nuovo record
$html.='<a href="<?php echo $selettoreUrl ?>new/"><?php echo $lang[\'linkNuovoRecord\']; ?></a>'."\n";

### select di categoria (molti-a-uno)
$html.='<?php echo $selectCat; ?>'."\n";

### select dei filtri
###### SERVE LOOP
$html.='<?php echo $selectVisibile; ?>'."\n";




### LOOP DEI DATI

$html.='<?php if($dati){ ?>'."\n";
$html.='	<table border="1"> '."\n";

$html.='	<tr>'."\n";

$html.='	<?php if($dirImg)echo \'<th>img</th>\'; ?>'."\n";

	### LOOP Dei CAMPI PER SCriVerli UNO PEr UNO
	foreach($campiTab as $k=>$v){ 

$html.='	<th>'.$k.'</th>'."\n";
	}
$html.='	<th></th>'."\n";
$html.='	<th></th>'."\n";

$html.='	</tr>'."\n";


$html.='	<?php for($i=0;$i<count($dati);$i++){ ?>'."\n";
$html.='	<?php $imgDati=$imgUrl=$IMG->_img($tab."/".$dati[$i][\'nome_uri\'].$SET_IMG[0]); ?>'."\n";

$html.='	<tr>'."\n";
$html.='	<?php if($dirImg)echo \'<td>\'; ?>'."\n";
$html.='	<?php if($imgDati)echo \'<img src="\'.$imgDati[\'url\'].\'" width="50" border="0" alt="" />\'; ?>'."\n";
$html.='	<?php if($dirImg)echo \'</td>\'; ?>'."\n";



$html.='	<?php $ii=0;?>';
	### LOOP Dei CAMPI PER SCriVerli UNO PEr UNO
	foreach($campiTab as $k=>$v){ 
		if($k=='id2'){
$html.='	<td><?php echo $dati[$i][\'id2_dati\'][\'nome\']; ?></td>'."\n";
		} else {



			if($v['Type']=="int(1)" || $k=="posizione")
			{
		//si tratta di un true/flase
$html.='	<td><?php echo $htmlHelper->filtraCampi($tab,$dati[$i],$campi[$ii],$dati[$i][\''.$k.'\']); ?></td>'."\n";		
			}


			else
			{
$html.='	<td><?php echo $dati[$i]['.$v['Field'].']; ?></td>'."\n";
			}


		}
$html.='	<?php $ii++; ?>';
	}

$html.='	<td><a href="<?php echo $selettoreUrl; ?>upd/<?php echo $dati[$i][\'id\']; ?>"><?php echo $lang[\'linkModificaRecord\']; ?></a></td>'."\n";
$html.='	<td><a href="<?php echo $selettoreUrl; ?>del/<?php echo $dati[$i][\'id\']; ?>"><?php echo $lang[\'linkCancellaRecord\']; ?></a></td>'."\n";
$html.='	</tr>'."\n";

$html.='	<?php } ?>'."\n";


$html.='	</table>'."\n";
$html.='<?php } else { ?>'."\n";
$html.='<?php echo $lang[\'MSG_nessun_record_trovato\']; ?>'."\n";
$html.='<?php } ?>';








	$html_display=htmlentities($html);
	$html_write=$html;
	$html=array();
	$html['display']=$html_display;
	$html['write']=$html_write;



return $html;
}




function generaNew($t)
{
$html=generaUpd($t,"new");
return $html;
}






function generaUpd($t,$a=null)
{
global $TIPI_CAMPO_TESTO;
global $lang;
global $rootAssolutaImg;
global $RELAZIONI_DB_ARRAY;
global $TAB_slug;
global $CONTENT_TAB;

if(empty($a))$a="upd";
$campi=campiTab($t,"1");
#pr($campiTab);

## apro tag PHP
$html.='<?php'."\n";
	### ADD ONLY FOR UPD
	if($a=="upd")
	{
	$html.='$r=_record($tab,"id",$id_record);'."\n";
	}
## istanzio la Classe generaForm
$html.='$generaForm=new generaForm();'."\n";
## apro TAG form
$html.='echo _formStart(\''.$a.'\',\''.$a.'\',\''.$a.'\');'."\n";
$html.='?>'."\n";




//solo se la tab in questione è un "contenuto"
//pr($CONTENT_TAB);
if(in_array($t,$CONTENT_TAB))
{
### 
### dati SLUG
 if($a=="upd") 
 {
 $html.='<?php $rSlug=_record($TAB_slug,"id2",$id_record," AND tab=\'".$tab."\' "); ?>'."\n"; 
 } 

### MODELLO 
$html.='<?php echo select(array_merge(array(\'\'),$A_MODELLI),"MOD_VAR",$rSlug[\'modello\']); ?>'."\n"; 

### COMPORTAMENTO
$html.='<?php echo select(array_merge(array(\'\'),$A_COMPORTAMENTI),"COMP_VAR",$rSlug[\'comportamento\']); ?>'."\n"; 

### RADICE
$html.='<?php echo select(array(\'0\',\'1\'),"SLUG_RADICE",$rSlug[\'radice\'],array(\'n\',\'y\')); ?>'."\n"; 


}









## Loop CAMPI
 foreach($campi as $key => $value)
 {
	## escludo il campo ID
	if(strtolower($value['Field'])=='id' || strtolower($value['Extra'])=='auto_increment')
	{
	//non fare nulla!
	}
	## ID_TAB
	else 	if(substr($value['Field'],0,2)=="id" && $value['Key']!="PRI")
	{

	 //creo un array delle tab relazionate molti-a-uno
	 $TAB_2_LIST=array();
	 for($i=0;$i<count($RELAZIONI_DB_ARRAY);$i++)
	 {	
		if($RELAZIONI_DB_ARRAY[$i]['tab1']==$t && $RELAZIONI_DB_ARRAY[$i]['tipo']=="molti-a-uno")
		{
		$TAB_2_LIST[]=$RELAZIONI_DB_ARRAY[$i]['tab2'];
		}
	 }


		for($i=0;$i<count($TAB_2_LIST);$i++)
		{
		 if($value['Field']=="id_".$TAB_2_LIST[$i])
		 {
$html.='<?php echo $htmlHelper->';
$html.='filtroRelazione($tab,$tab2['.$i.'],\'molti-a-uno\',\''.$value['Field'].'\',$r[\''.$value['Field'].'\'],false,false); ?>'."\n";
		 }
		}
	}

	## nome_uri
	else if(strtolower($value['Field'])=='nome_uri')
	{

		if($a=="upd")
		{
	$html.='<div>'.$key.' ('.$value['Type'].')<br/>'."\n";
	$html.='<input type="text" value="<?php echo $r[\''.$value['Field'].'\']; ?>" name="'.$value['Field'].'"></div>'."\n";	
		}
		else
		{
	$html.='<?php echo $generaForm->_hidden("nome_uri",$r['.$value['Field'].']); ?>'."\n";
		}
	}
	## posizione
	else if($value['Field']=='posizione')
	{
	$html.='	<?php'." ";
	$html.='	$aCampi=array();for($i=-50;$i<51;$i++){$aCampi[]=$i;}'." ";
	$html.='	?>'."\n";


		if($r[$value['Field']]=="")$r[$value['Field']]=$value['Default'];

	$html.='	<div>'.$key.' ('.$value['Type'].')<br/>'."\n";
	$html.='	<?php echo $htmlHelper->_select($aCampi,\''.$value['Field'].'\',$r[\''.$value['Field'].'\'],$aCampi_namePosizione); ?>';
	$html.='	</div>'."\n";
	
	}
	## TRUE/FALSE
	else if($value['Type']=='int(1)')
	{
		if($r[$value['Field']]=="")$r[$value['Field']]=$value['Default'];
	
	$html.='	<div>'.$key.' ('.$value['Type'].')<br/>'."\n";
			$a1='array(\'0\',\'1\')';
			$a2='array($lang[\'no\'],$lang[\'si\'])';
	$html.='	<?php echo $htmlHelper->_select('.$a1.',\''.$value['Field'].'\',$r[\''.$value['Field'].'\'],'.$a2.'); ?>';
	$html.='	</div>'."\n";
	}
	## campi DATA
	else if(substr($value['Field'],0,4)=="data")
	{
	$html.='	<div>'.$key.' ('.$value['Type'].')<br/>'."\n";
		
		### VALORiZZO IL CampO in modo diverso, se è TIMESTAMP oppure DATE
		if(substr($value['Type'],0,3)=="int"){$r[$value['Field']]=time();}
		else{$r[$value['Field']]=date("Y-m-d H:i:s");}
	
	$html.='	<?php'."\n";
	$html.='	//creo array settings'."\n";
	$html.='	$settings=array('."\n";
	$html.='	\'name\'=>'.$value['Field'].','."\n";

			if($a=="upd")		
			{
	$html.='	\'value\'=>$r[\''.$value['Field'].'\'],'."\n";
			}
			else
			{
	$html.='	\'value\'=>time(),'."\n";
			}

	$html.='	\'type\'=>$value[\'Type\']'."\n";
	$html.='	);'."\n";
	$html.='	?>'."\n";

	$html.='	<?php echo $htmlHelper->_inputData($settings,$value); ?>'."\n";
	$html.='	</div>'."\n";
	}
	## campi TESTI
	else if(in_array($value['Type'],$TIPI_CAMPO_TESTO))
	{
	$html.='<div>'.$key.' ('.$value['Type'].')<br/>'."\n";
	$html.='<textarea name="'.$value['Field'].'"><?php echo $r[\''.$value['Field'].'\']; ?></textarea></div>'."\n";	
	}
	else
	{
	$html.='<div>'.$key.' ('.$value['Type'].')<br/>'."\n";
	$html.='<input type="text" value="<?php echo $r[\''.$value['Field'].'\']; ?>" name="'.$value['Field'].'"></div>'."\n";	
	}
 }


	## aggiungo campo IMG se sono in UPD e se la directory IMG esiste



	if($a=="upd" && is_dir($rootAssolutaImg.$t."/"))
	{

	$html.='<?php
		if(!empty($r[\'nome_uri\']))
		{
		$generaForm=new generaForm();
		$formIMG=$generaForm->_hidden("nome_uri_save",$r[\'nome_uri\']);
		$formIMG.=$generaForm->_hidden("campoImgUpload",\'img\'); //deve essere uguale al nome del FormImg
		$formIMG.=$generaForm->_img(\'img\',$r);
		}
		else
		{
		$formIMG="<p class=\"red\">".$lang[\'MSG_MancaCampoNomeUriPerImg\']."</p>";
		}
	?>'."\n";
	
	$html.='<?php echo $formIMG;  ?>'."\n";
	
	}



$html.='<input type="submit" value="'.$lang['tasto_invia_nuovo'].'">'."\n";
$html.='</form>'."\n";

	$html_display=htmlentities($html);
	$html_write=$html;
	$html=array();
	$html['display']=$html_display;
	$html['write']=$html_write;

return $html;
}





?>
