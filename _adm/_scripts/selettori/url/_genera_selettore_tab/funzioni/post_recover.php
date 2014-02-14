<?php

function versioniList($action,$array,$tab)
{
global $selettoreUrl;
	for($i=0;$i<count($array);$i++)
	{
	echo $array[$i]."<br/>";
	$m=$array[$i];
	}
	if($array){
	echo '<p><a href="'.$selettoreUrl.'delete_copy/'.$tab."@".$action.'/">delete copy</a></p>';
	}

}

function checkDirGenera($dir)
{
	if(!is_dir($dir))
	{
	mkdir($dir,0755);
	}
}


function scriviFile($dir,$f,$dati,$MODE,$w=null) 
{

	if($w=="1")
	{
	//echo ''.$dir."";
	checkDirGenera($dir);
	$path_file=$dir.$f;

$timeNOW=time();
$path_fileCOPY=str_replace(".php","_".$timeNOW.".php",$path_file);
if(@copy($path_file,$path_fileCOPY)){$copy=true;}else{$copy=false;}

		if($MODE=="DEL")
		{
			if(unlink($path_file))
			{
			$return = true;
			}
			else
			{
			$return = false;
			}

		}
		else
		{
			if(write($path_file,$dati))
			{
			$return = true;
			}
			else
			{
			$return = false;
			}
		}


//aggiorno i dati
$path_fileDATI=str_replace(".php",".dati",$path_file);
@include($path_fileDATI);
//echo "<p>???: ".$SAVE_upd[0]."</p>";
	$fVar=str_replace(".php","",$f);
$DATI_START ='<?php'."\n";
$DATI_START.='$SAVE'.$fVar.'=array();'."\n";


	$nomeArraySave="SAVE".$fVar;
	$arrSave=$$nomeArraySave;

//echo "<p>0: ".$nomeArraySave."</p>";
//echo "<p>1: ".$SAVE_upd[0]."</p>";
//echo "<p>2: ".$arrSave[0]."</p>";

	for($i=0;$i<count($arrSave);$i++)
	{
//echo 'dati: '.$arrSave[$i]."<br>";
		if(!empty($arrSave[$i]))
		{
$DATI.='$SAVE'.$fVar.'[]="'.$arrSave[$i].'";'."\n";	
		}
	}
//$timeNOW
	if($copy)
	{
$DATI.='$SAVE'.$fVar.'[]="'.$timeNOW.'";'."\n";	
	}
$DATI_END.='?>'."\n";

//echo $path_fileDATI;

		if(!empty($DATI))
		{
		$DATI=$DATI_START.$DATI.$DATI_END;
		write($path_fileDATI,$DATI);
		}

	
	}
	
	return $return;
}

function __doIt($dirGenera,$f,$dati,$w,$MODE)
{
global $lang;
global $selettoreUrl;
$htmlHelper=new htmlHelper();
 


 if($w=="1")
 {
//echo '<p>chiamo scrivi file</p>';
  if(scriviFile($dirGenera,$f,$dati,$MODE,$w))
  {
  $htmlHelper->setFlash('msg',$lang['MSG_datiSalvati']); 
  Header("location: ".$selettoreUrl);
  exit;
  }
  else
  {
  $htmlHelper->setFlash('msg',$lang['MSG_datiNonSalvati']); 
  }
 }

}$return = true;


if($_POST['generate']!="")
{
$dirGenera=$rootAssoluta.$dirADMIN."_views/tab/".$_POST['tab']."/";

//echo "GENERO PER LA TAB: ".$_POST['tab']."<br/>";
	if($_POST['INDEX']=="1")
	{
	//echo "GENERO PER LA TAB: ".$_POST['tab']." INDEX<br/>";
	$index_data=generaIndex($_POST['tab']); 
	__doIt($dirGenera,"_index.php",$index_data['write'],$_POST['write'],$_POST['MODE']); 
	}

	if($_POST['NEW']=="1")
	{
	$new_data=generaNew($_POST['tab']);
	__doIt($dirGenera,"_new.php",$new_data['write'],$_POST['write'],$_POST['MODE']); 
	}

	if($_POST['UPD']=="1")
	{
	$upd_data=generaUpd($_POST['tab']);
	__doIt($dirGenera,"_upd.php",$upd_data['write'],$_POST['write'],$_POST['MODE']); 
	}

}




if($_GET['delete_copy']!="")
{
global $selettoreUrl;

//echo $_GET['delete_copy'];
$a=explode("@",$_GET['delete_copy']);
//echo "TAB: <b>".$a[0]."</b><br/>";
//echo "ACTION: <b>".$a[1]."</b><br/>";

$dirDelete=$rootAssoluta.$dirADMIN."_views/tab/".$a[0]."/";
$fileDati=$dirDelete."_".$a[1].".dati";
include($fileDati);
$nomeArray="SAVE_".$a[1];
$arrDel=$$nomeArray;
	for($i=0;$i<count($arrDel);$i++)
	{
	//$arrDel
	unlink($dirDelete."_".$a[1]."_".$arrDel[$i].".php");
	}
unlink($fileDati);	
  $htmlHelper->setFlash('msg',$lang['MSG_datiSalvati']); 
  Header("location: ".$selettoreUrl);
  exit;

}
?>
