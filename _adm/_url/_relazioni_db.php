<?php
$DIR_REL_save=rootDOC."_config/dbRelations/";


function checkTabManyToOne($tab,$arr){
	for($i=0;$i<count($arr);$i++)
	{
	if($arr[$i]['rel']=="many-to-one")
	{
		$TAB1=$tab;
		$TAB2=$arr[$i]['tab'];
		$ID1="id_".$tab;
		$ID2="id_".$arr[$i]['tab'];
			
		$exists=tableFiledExists($TAB1,$ID2);
			
		if(!$exists)
		{
		//pr("do not exists");
		$Q="ALTER TABLE  ".$TAB1." ADD  ".$ID2." INT NOT NULL";
		$result=dbAction::_exec(array('sql'=>$Q));
		}
		//echo'<p>'.$TAB1.' '.$TAB2.' '.$ID1.' '.$ID2.'</p>';
		
	}
	}
}
function checkTabManyToMany($tab,$arr){
//pr($arr);
	for($i=0;$i<count($arr);$i++)
	{
	if($arr[$i]['rel']=="many-to-many")
	{
		$TAB_REL=$tab."_".$arr[$i]['tab'];
		$ID1="id_".$tab;
		$ID2="id_".$arr[$i]['tab'];
		
		//echo'<p>'.$TAB_REL.'</p>';
		$TAB_EXIST=dbAction::_record(array('tab'=>$TAB_REL,'value'=>'1','_ERR_NUM_'=>true,'echo'=>'0'));
		//pr("aaa".$TAB_EXIST);
		//pr($TAB_EXIST);
		if(!is_array($TAB_EXIST) && $TAB_EXIST=='1146')
		{
			//echo'<p>CREATE TAB: '.$TAB_REL.'</p>';

$SQL="
CREATE TABLE IF NOT EXISTS ".$TAB_REL." (
  id int(11) NOT NULL AUTO_INCREMENT,
  ".$ID1." int(11) NOT NULL,
  ".$ID2." int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
";
dbAction::_exec(array('sql'=>$SQL,'echo'=>true));



		}
	}
	}
}
?>








<?php $tabElenco=elencoTAB(); ?>
<?php $generaForm=new generaForm(); ?>


<h1><?php echo $lang['TIT_Crea_una_relazione']; ?>:</h1>



<div style="float:left;width:210px;">
	<?php
		
	$RELATIONS_DB_ARRAY___DISPLAY=$RELATIONS_DB_ARRAY;
		
		if(isset($_GET['SEESAVE']) && file_exists($DIR_REL_save.$_GET['SEESAVE']))
		{
			include($DIR_REL_save.$_GET['SEESAVE']);
			$RELATIONS_DB_ARRAY___DISPLAY=$RELATIONS_DB_ARRAY;
			//include($fileRELAZIONI_DB);
		echo'<div style="font-size:11px;margin:5px;padding:5px;border:1px #dfdfdf solid;background:#ffffcc;">';
			if($_GET['SEESAVE']!="LAST_BU"){echo'<b>SAVED ON: '.date("d-m-y H.i.m",$_GET['SEESAVE']).'</b><br />';}
			else{echo'<b>Last BackUp File</b><br />';}
			echo'
			this is only a READ file, to see the saved file <br />
			<a href="'.rootWWW.$_GET['url'].'" style="color:blue;">back to actual file</a>.
		</div>';
		}
	?>
<?php echo _formStart("CLEAR"); ?>
<?php //echo _formSubmit($lang['tasto_azzera_relazioni']); ?>
<?php echo _formSubmit('CLEAR ALL'); ?>
</form>
<?php echo _formStart("SAVE"); ?>
<?php //echo _formSubmit($lang['tasto_azzera_relazioni']); ?>
<?php echo _formSubmit('SAVE THIS'); ?>
</form>

<br/>

	<?php echo _formStart("ADD"); ?>
	<div>
	Per la tabella:<br/>
	<?php echo htmlHelper::_select($tabElenco,'tab1'); ?>
	</div>
	
	<div>
	Con la tabella:<br/>
	<?php echo htmlHelper::_select($tabElenco,'tab2'); ?>
	</div>
	
	<div>
	Di tipo:<br/>
	<?php echo htmlHelper::_select($DB_RELTIONS_TYPE,'tipo'); ?>
	</div>
	
	<?php echo _formSubmit($lang['tasto_aggiorna_relazioni']); ?>
	
	</form>
	
	
	
	<?php
	$saveF=_CORE::dirToArray($DIR_REL_save,array('type'=>file));
	if($saveF)
	{
		echo'<div style="border:1px #dfdfdf solid;margin-top:15px;padding:5px;">';
		echo'<b>Lista dei salvataggi</b>';
	foreach($saveF as $k=>$v)
	{
		if($v!="LAST_BU")
		{
		echo'<div style="font-size:10px;padding:3px;margin:2px;background:#ffffcc;">
		'.date("d-m-y H.i.s",$v).'';
		echo '<tt style="font-size:11px;">';
		echo ' <a href="?SEESAVE='.$v.'" style="color:blue;">see</a>';
		echo ' <a href="?USESAVE='.$v.'" style="color:green;">use</a>';
		echo ' <a href="?DELSAVE='.$v.'" style="color:red;">del</a>';
		echo '</tt>';
		
		echo'</div>';
		}
		else{$BUEXISTS=true;}
	}
		if($BUEXISTS)
		{
		echo'<div style="font-size:10px;padding:3px;margin:2px;background:#dfdfdf;">
		BU-file';
		echo '<tt style="font-size:11px;">';
		echo ' <a href="?SEESAVE=LAST_BU" style="color:blue;">see</a>';
		echo ' <a href="?USESAVE=LAST_BU" style="color:green;">use</a>';
		echo ' <a href="?DELSAVE=LAST_BU" style="color:red;">del</a>';
		echo '</tt>';
		
		echo'</div>';
			
		}
		echo '</div>';
	}
	?>
	
	
</div>

<div style="float:left;width:490px;">
	
	
	
	<?php if(is_array($RELATIONS_DB_ARRAY___DISPLAY)){ ?>
	
		<?php //for($i=0;$i<count($RELATIONS_DB_ARRAY);$i++){ ?>
	
		<?php foreach($RELATIONS_DB_ARRAY___DISPLAY as $tab=>$arr){?>
			
			<?php checkTabManyToOne($tab,$arr); ?>
			<?php checkTabManyToMany($tab,$arr); ?>
			
	<b><?php echo $tab; ?></b><br />
			<?php for($i=0;$i<count($arr);$i++){ ?>
			<div style="float:left;width:210px;font-size:11px;background-color:#ffffcc;margin:3px;padding:5px;">
			<?php echo $arr[$i]['tab']; ?>
			</div>
			<div style="float:left;width:90px;font-size:11px;background-color:#ffffcc;margin:3px;padding:5px;text-align:center;">
			<?php echo $arr[$i]['rel']; ?>
			</div>
			<div style="float:left;width:90px;padding:5px;">
			<?php echo _formStart("DEL"); ?>
			<?php echo $generaForm->_hidden("tab",$tab); ?>
			<?php echo $generaForm->_hidden("i",$i); ?>
			<input type="submit" value="DELETE" style="font-size:11px;padding:0px;background:red;color:#ffffff;border:1px red solid;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;" />
			</form>
			</div>
			<div id="clear"></div>
			<?php } ?>
	
	
	
	
		<?php } ?>
	<?php } ?>
</div>

<div id="clear"></div>
			


<?php //pr($RELATIONS_DB_ARRAY); ?>

<?php 
$urlToGo=urlMenuAdmin(array('selettore'=>'url','id_s'=>'_relazioni_db'));
	//if($_POST['DEL']!="" || $_POST['ADD']!=""){
$mem_START='<?php'."\n";
$mem_START.='$RELATIONS_DB_ARRAY=array();'."\n";
$mem_END.='?>';


if($_GET['DELSAVE'])
{
	unlink($DIR_REL_save.$_GET['DELSAVE']);
	htmlHelper::setFlash('msg',"Deleted!");
	//pr($_GET['url']);
	_CORE::redirect(array('location'=>rootWWW.$_GET['url']));
}

if($_GET['USESAVE'])
{
	if(file_exists($DIR_REL_save.$_GET['USESAVE']))
	{
	/**/
	unlink($DIR_REL_save."LAST_BU");
	copy($fileRELAZIONI_DB,$DIR_REL_save."LAST_BU");
	unlink($fileRELAZIONI_DB);
	copy($DIR_REL_save.$_GET['USESAVE'],$fileRELAZIONI_DB);
	htmlHelper::setFlash('msg',"Saved!");
	_CORE::redirect(array('location'=>rootWWW.$_GET['url']));
	
	}
	else{
	htmlHelper::setFlash('err',"file not exists");
	}
}

if($_POST['SAVE']!="")
{
	//htmlHelper::setFlash('msg',"SAVE");
	//pr($fileRELAZIONI_DB);
	
	$perms=substr(sprintf('%o', @fileperms($DIR_REL_save)), -3);
	//pr($perms);
		
	if($perms!="755" && $perms!="777")
	{
		htmlHelper::setFlash('msg',"NEED a DIR:<br />".$DIR_REL_save." [755 or 777]");
	}
	else
	{
		copy($fileRELAZIONI_DB,$DIR_REL_save.time());
		_CORE::redirect(array('location'=>rootWWW.$_GET['url']));
	}
	
}


if($_POST['ADD']!="" || $_POST['DEL']!="")
{
	$TAB1=$_POST['tab1'];
	$TAB2=$_POST['tab2'];
	
	
	if($_POST['DEL']!="")
	{
	$TAB1="1";
	$TAB2="2";
		
		
		
			//Devo scorrere l'array
			foreach($RELATIONS_DB_ARRAY as $tab=>$arr)
			{
				
				for($i=0;$i<count($arr);$i++)
				{
					if($_POST['tab']==$tab && $_POST['i']==$i)
					{
					//DO NOTHING	
					}else{
					$mem.='$RELATIONS_DB_ARRAY[\''.$tab.'\'][]=';
					$mem.="array('tab'=>'".$arr[$i]['tab']."','rel'=>'".$arr[$i]['rel']."');\n";
					}
				}
			//echo '<p>'.$tab.'</p>'.pr($arr);
			}

		
		
	}
	else
	{
		if(!is_array($RELATIONS_DB_ARRAY))
		{
			//Vuoto!
			$mem='$RELATIONS_DB_ARRAY[\''.$TAB1.'\'][]=';
			$mem.="array('tab'=>'".$TAB2."','rel'=>'".$_POST['tipo']."');\n";
		}
		elseif(isset($RELATIONS_DB_ARRAY[$TAB1]))
		{
			//Devo scorrere l'array
			foreach($RELATIONS_DB_ARRAY as $tab=>$arr)
			{
				
				for($i=0;$i<count($arr);$i++)
				{
				$mem.='$RELATIONS_DB_ARRAY[\''.$tab.'\'][]=';
				$mem.="array('tab'=>'".$arr[$i]['tab']."','rel'=>'".$arr[$i]['rel']."');\n";
						
					if($TAB1==$tab && $TAB2==$arr[$i]['tab'])
					{
					$err=true;
					htmlHelper::setFlash('msg',$lang['aggiornamentoRelazioniNonRiuscito'].": RELATION EXISTS"); 
					}						
				}
				
				if($TAB1==$tab){
				$mem.='$RELATIONS_DB_ARRAY[\''.$tab.'\'][]=';
				$mem.="array('tab'=>'".$TAB2."','rel'=>'".$_POST['tipo']."');\n";
				}
			//echo '<p>'.$tab.'</p>'.pr($arr);
			}
			
			
		}
		else
		{
			//echo 'AAA';exit;
			
			
			//Devo scorrere l'array
			foreach($RELATIONS_DB_ARRAY as $tab=>$arr)
			{
				
				for($i=0;$i<count($arr);$i++)
				{
				$mem.='$RELATIONS_DB_ARRAY[\''.$tab.'\'][]=';
				$mem.="array('tab'=>'".$arr[$i]['tab']."','rel'=>'".$arr[$i]['rel']."');\n";					
				}
			//echo '<p>'.$tab.'</p>'.pr($arr);
			}
			
			$mem.='$RELATIONS_DB_ARRAY[\''.$TAB1.'\'][]=';
			$mem.="array('tab'=>'".$TAB2."','rel'=>'".$_POST['tipo']."');\n";
	
	
	
	
		}
	}
	$mem_array=$mem_START.$mem.$mem_END;

		if(empty($mem)) exit;
	
	if($TAB1==$TAB2)
	{
	htmlHelper::setFlash('msg',$lang['aggiornamentoRelazioniNonRiuscito'].": SAME TABLE"); 
	$err=true;
	}
	
	
	if(!$err)
	{
		if(write($fileRELAZIONI_DB,$mem_array)){
		htmlHelper::setFlash('msg',$lang['aggiornamentoRelazioniRiuscito']); 
		} else {
		htmlHelper::setFlash('msg',$lang['aggiornamentoRelazioniNonRiuscito']); 
		}
	}
	header("location: ".$urlToGo);
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
