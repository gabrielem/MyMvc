<?php

//da definire per ogNi tab... 
$FILTRI=array();
$FILTRI_DEFAULT=array();

$FILTRI[]="pag";
$FILTRI_DEFAULT[]="1";
$FILTRI_CLEAR[]="0";
$FILTRI_SELECT[]="0";
$FILTRI_CAMPI[]="";
$FILTRI_CAMPI_NOME[]="";

//CONTROLLO RELAZIONI 
##########################
### DA INCLUDERE IN UNA FUNZIONE...
//$RELAZIONI_DB_ARRAY
//pr($RELAZIONI_DB_ARRAY);
$ii=0;
for($i=0;$i<count($RELAZIONI_DB_ARRAY);$i++)
{ 

//echo $i." ] ".$RELAZIONI_DB_ARRAY[$i]['tab1']." - ".$RELAZIONI_DB_ARRAY[$i]['tab2']." - ".$RELAZIONI_DB_ARRAY[$i]['tipo']." [<br/>";



	### uno-a-molti
	if($RELAZIONI_DB_ARRAY[$i]['tab1']==$tab && $RELAZIONI_DB_ARRAY[$i]['tipo']=="uno-a-molti") 
	{
	$tab3[$ii]=$RELAZIONI_DB_ARRAY[$i]['tab2']; 	
	}

	else if($RELAZIONI_DB_ARRAY[$i]['tab2']==$tab && $RELAZIONI_DB_ARRAY[$i]['tipo']=="uno-a-molti") 
	{
	$tab3rev[$ii]=$RELAZIONI_DB_ARRAY[$i]['tab1']; 	
	}



	### molti-a-uno

	else if($RELAZIONI_DB_ARRAY[$i]['tab2']==$tab && $RELAZIONI_DB_ARRAY[$i]['tipo']=="molti-a-uno") 
	{
	//reversibilità
	$tab2rev[]=$RELAZIONI_DB_ARRAY[$i]['tab1']; 
	}

	else if($RELAZIONI_DB_ARRAY[$i]['tab1']==$tab && $RELAZIONI_DB_ARRAY[$i]['tipo']=="molti-a-uno") 
	{ 

	$indiceRelazioniDB=$i; 
	$RELAZIONI_DB_ARRAY[$i]['tipo']; 
	$tab2[$ii]=$RELAZIONI_DB_ARRAY[$i]['tab2'];
	$tipoRelazioneDB[$ii]=$RELAZIONI_DB_ARRAY[$i]['tipo']; 

	$FILTRI[]="id_".$tab2[$ii]; 
	$FILTRI_DEFAULT[]="ALL"; 
	$FILTRI_CLEAR[]="0"; 
	$FILTRI_SELECT[]="1"; 
		
		//array DATI TAB2 
		$l2=_loop($tab2[$ii]); 
$arrCampi="";
$arrCampiNome="";
		$arrCampi[]="ALL";
		$arrCampiNome[]="All";
		
		for($iii=0;$iii<count($l2);$iii++)
		{
		$arrCampi[]=$l2[$iii]['id'];
		$arrCampiNome[]=$l2[$iii]['nome'];
		}

		$arrCampi[]="ZERO";
		$arrCampiNome[]=$lang['SELECT_none'];

//pr($arrCampi);
		
	$FILTRI_CAMPI[]=$arrCampi;
	$FILTRI_CAMPI_NOME[]=$arrCampiNome;

	$ii++;
	}
}
//$tab2=$RELAZIONI_DB_ARRAY[$indiceRelazioniDB]['tab2'];
//$tipoRelazioneDB=$RELAZIONI_DB_ARRAY[$indiceRelazioniDB]['tipo'];
##########################

//valorizzo $campiTabCompleti
    //echo "aaa".$tab;
    if(!empty($tab))
    {
if(empty($campiTabCompleti)){$campiTabCompleti=campiTab($tab,1);}
    }


//pr($campiTabCompleti);
### agiungi i filtri dai campi:

if($campiTabCompleti)
{
foreach($campiTabCompleti as $k=>$v)
{
//$campiTab
	if($v['Type']=="int(1)")
	{
	$FILTRI[]=$v['Field'];
	$FILTRI_DEFAULT[]="ALL";
	$FILTRI_CLEAR[]="0";
	$FILTRI_SELECT[]="1";
	$FILTRI_CAMPI[]=array('ALL','1','ZERO');
	$FILTRI_CAMPI_NOME[]=array('All',$lang['si_'.$v['Field']],$lang['no_'.$v['Field']]);
	}
}
}















if($getPost->cercaVar($_GET,$FILTRI))
{
 for($i=0;$i<count($FILTRI);$i++)
 {$nomeFiltro="FILTRO_".$FILTRI[$i];
 // se il filtro necessita azzeramento e non sto valorizzando il iltro stesso allora RESETTO!
 if($FILTRI_CLEAR[$i]=="1"){if(!isset($_GET[$FILTRI[$i]])) {unset($_SESSION[$tab][$FILTRI[$i]]);}}
 }
}



for($i=0;$i<count($FILTRI);$i++)
{
$nomeFiltro="FILTRO_".$FILTRI[$i];
	//imposto valore del filtro!
	if(isset($_GET[$FILTRI[$i]])) 
	{
	//echo '___'.$_GET[$FILTRI[$i]];
	$_SESSION[$tab][$FILTRI[$i]]=$_GET[$FILTRI[$i]];
	Header("Location: ".$selettoreUrl);
	}
	$$nomeFiltro=$_SESSION[$tab][$FILTRI[$i]]; 
	if(empty($$nomeFiltro)){$$nomeFiltro=$FILTRI_DEFAULT[$i];}
	$_GET[$FILTRI[$i]]=$$nomeFiltro;
}










#############
## recupero dati e creo le select filtri

$selectFiltri=array();
$selectFiltriName=array();
for($i=0;$i<count($FILTRI);$i++)
{
	if($FILTRI_SELECT[$i]=="1")
	{
	$addScript='onChange="window.location.href=\''.$selettoreUrl.'\'+this.name+\'/\'+this.options[this.selectedIndex].value;"';
	//pr($FILTRI_CAMPI_NOME[$i]);
	$aCampi=$FILTRI_CAMPI[$i];
	$name=$FILTRI[$i];
	$nomeFILTRO="FILTRO_".$FILTRI[$i];
	$aCampi_name=$FILTRI_CAMPI_NOME[$i];
	$selectFiltri[]=$htmlHelper->_select($aCampi,$name,$$nomeFILTRO,$aCampi_name,'',$addScript); 
	$selectFiltriName[]=$FILTRI[$i];
	}
}


//$selectFiltri
function selectFiltri()
{
global $selectFiltri;
	for($i=0;$i<count($selectFiltri);$i++)
	{
	echo $selectFiltriName[$i]." ";
	echo $selectFiltri[$i]." ";
	}
}

//pr($tab2);
//pr($tab2rev);
?>
