<?php

	function select($aCampi,$name,$value_selected=null,$aCampi_name=null,$id=null,$addScript=null,$disabled=false)
	{
			if($disabled)
			{
			$scrivi_disabled=" disabled";
			}
			else
			{
			$scrivi_disabled="";
			}

		$idS=$id; if(empty($idS))$idS=$name;
	$html.= '<select name="'.$name.'" id="'.$idS.'"'.$addScript.$scrivi_disabled.'>';
		for($i=0;$i<count($aCampi);$i++)
		{	$v=$aCampi[$i];
			$n=$v;if(!empty($aCampi_name[$i]))$n=$aCampi_name[$i];
			if($value_selected==$v){$s=" selected";}else{$s="";}
		$html.= '<option value="'.$v.'"'.$s.'>'.$n.'</option>';
		}

	$html.= '</select>';
	return $html;
	}


class htmlHelper 
{

	function filtraCampi($t,$aDati,$campo,$value)
	{
	global $lang; 
	global $selettoreUrl;
	$return = $value;
	$c=campiTab($t,'1');



	$urlUpdOne=$selettoreUrl."UPD_TF/";
	
	//ID PER TAB RELAZIONATE?
	if(substr($campo,0,2)=="id" && $c[$campo]['Key']!="PRI")
	{
	
		//CONTROLLO A LOOP PER TAB REL {$aDati['TAB_2_LIST']}
		for($i=0;$i<count($aDati['TAB_2_LIST']);$i++)
		{
		//echo '<p>'.$i.") ".$aDati['TAB_2_LIST'][$i].'</p>';
			if($campo=="id_".$aDati['TAB_2_LIST'][$i])
			{
			//echo 's';
			// si tratta di un (id2) campo relazionale per tab specifica
			// quindi ritorno il nome della tab relativa
			$nctl='id_'.$aDati['TAB_2_LIST'][$i].'_dati';
			//echo "".$aDati[$nctl]['nome'];
			$return = $aDati[$nctl]['nome'];
			}
		}
	}
	//campi true/flase int(1)
	//echo "?".$c[$campo]['Type'];
	else if($c[$campo]['Type']=="int(1)")
		{
		$aCampi=array('0','1');
		$aCampi_name=array($lang['no'],$lang['si']);
		$name="".$campo;
		
		$return="<form>";
		$addScript='onChange="window.location.href=\''.$urlUpdOne.'\'+this.name+\'_'.$aDati['id'].'_\'+this.options[this.selectedIndex].value;"';
		$return.=$this->_select($aCampi,$name,$value,$aCampi_name,$id_select,$addScript);
		$return.="</form>";	
		}
		

	// campi Data (che iniziano con data)
	else if(substr($campo,0,4)=="data" && is_numeric($value))
		{
		//si tratta di una data in fomrato timeStamp
		$return = date($lang['FORMATO_DATA'],$value);
		}
	
	// campo posizione
	else if($campo=='posizione')
		{
		$aCampi=array();for($i=-50;$i<51;$i++){$aCampi[]=$i;}
		$aCampi_name="";
		$name=$campo;

		//$urlUpdOne
		$return="<form>";
		$addScript='onChange="window.location.href=\''.$urlUpdOne.'\'+this.name+\'_'.$aDati['id'].'_\'+this.options[this.selectedIndex].value;"';
		$return.=$this->_select($aCampi,$name,$value,$aCampi_name,$id_select,$addScript);
		$return.="</form>";	
		}
		

		
		return $return;
	}



	function filtroRelazione($t=null,$t2=null,$relTipo=null,$nomeSelect,$id2_selected=null,$addScript=true,$addALL=true,$disabled=false,$array_valori_nome=null)
	{
	global $rootBaseAdmin;
	global $selettoreDATI;
	global $lang;
	global $selettoreUrl;

	
		if(empty($t2) || empty($relTipo))
		{
		return false;
		}
		else 
		{
		$mysql_access = connect();

		$loop=_loop($t2);
			if(!$loop)
			{
			return 0;
			}
		//costruisco la select del filtro
			if($relTipo=="uno-a-molti")
			{
			//uno-a-molti
			}
			else if($relTipo=="molti-a-uno")
			{

			//molti-a-uno
				//URL CAT
				$urlCat=$selettoreUrl;
			if($addScript){
			$addScript='onChange="window.location.href=\''.$urlCat.'\'+this.name+\'/\'+this.options[this.selectedIndex].value;"';
			}

				//Array id & nome
				$value=array();$name=array();
				for($i=0;$i<count($loop);$i++)
				{
				$id[]=$loop[$i]['id'];
					if(!empty($array_valori_nome))
					{
					//pr($array_valori_nome);

						$nomeMem="";
						for($i2=0;$i2<count($array_valori_nome);$i2++)
						{
							//
							
							$valueName=$loop[$i][$array_valori_nome[$i2]];
							if(substr($array_valori_nome[$i2],0,4)=="data")
							{
							$valueName=date("m-d-Y",$valueName);
							}
						$nomeMem.=$array_valori_nome[$i2].": ".$valueName." ";
						}
						$nome[]=$nomeMem;

					}
					else
					{
					$nome[]=$loop[$i]['nome'];
					}
				}
				
					if($addALL){
				$id[]='ALL';
				$nome[]=$lang['SELECT_all'];
					}
				$id[]='ZERO';
				$nome[]=$lang['SELECT_none'];
					
			$html=select($id,$nomeSelect,$id2_selected,$nome,'',$addScript,$disabled);
			}
		return $html;
		}
	
	
	
	
	}



	function _select($aCampi,$name,$value_selected=null,$aCampi_name=null,$id=null,$addScript=null)
	{
	return select($aCampi,$name,$value_selected,$aCampi_name,$id,$addScript);
	}







	function _selectDip($a1,$a2,$nameS1,$nameS2,$formName,$a1_name=null,$a2_name=null)
	{

$memScript='<script>'."\n";
$memScript.='function selectDipendenti(selezionata){'."\n";



	for($i=0;$i<count($a1);$i++)
	{
	$memINIT_ARRAY.='ar_'.$i.'=new Array();'."\n"; 
	
		for($ii=0;$ii<count($a2[$i]);$ii++)
		{
		$valueA2=$a2[$i][$ii];
		$name_A2=$a2[$i][$ii];
			if(!empty($a2_name[$i][$ii])){$name_A2=$a2_name[$i][$ii];}
		$memVALORI_ARRAY.="ar_".$i."[".$ii."]=new Option('".$name_A2."','".$valueA2."');"."\n"; 
			if($i=='0'){
			$memSelect2_item.='<option value="'.$valueA2.'">'.$name_A2.'</option>';
			}
		}
		$memVALORI_ARRAY.="\n"; 

	$memIF_SET.='if(selezionata=="'.$a1[$i].'")array_rif=ar_'.$i.';'."\n"; 





		$valueA1=$a1[$i];
		$name_A1=$a1[$i];
			if(!empty($a1_name)){$name_A1=$a1_name[$i];}	
	$memSelect1_item.='<option value="'.$valueA1.'">'.$name_A1.'</option>';
	}

$memScript.=$memINIT_ARRAY;
$memScript.=$memVALORI_ARRAY;
$memScript.=$memIF_SET;


//$memScript.='array_precedente=document.".$formName.".".$nameS2.".options;'."\n";
//$memScript.='alert("lunghezza array : "+array_rif.length+" - lunghezza array PREC : "+array_precedente.length+"");'."\n";
	

$memScript.='document.forms[\''.$formName.'\'].elements[\''.$nameS2.'\'].options.length=0;'."\n";
$memScript.="for(i=0;i<array_rif.length;i++) {
//alert(i);
document.".$formName.".".$nameS2.".options[i]=array_rif[i];
}"."\n"; 
//$memScript.='alert("lunghezza array: "+array_rif.length+" - formName:'.$formName.' - nameS2: '.$nameS2.'");'."\n";

$memScript.="}"."\n"; 
$memScript.="</script>"."\n"."\n"; 



$memSelect1='<select name="'.$nameS1.'" onChange="selectDipendenti(this[this.selectedIndex].value)">'."\n";
$memSelect1.=$memSelect1_item;
$memSelect1.='</select>'."\n";



$memSelect2='<select name="'.$nameS2.'">'."\n";
$memSelect2.=$memSelect2_item;
$memSelect2.='</select>'."\n";




$returVar=$memScript.$memSelect1.$memSelect2;

	$arrayToReturn=array();
	$arrayToReturn['js']=$memScript;
	$arrayToReturn['s1']=$memSelect1;
	$arrayToReturn['s2']=$memSelect2;

	//return $returVar;
	return $arrayToReturn;
	
	
	}









	function _inputData($settings=null)
	{
	global $lang;

//pr($settings);


		if(!empty($settings['value']))
		{

//echo "<p>".$settings['name']."</p>";
//echo "<p>".$settings['value']."</p>";

//echo "<p>".date("d",$settings['value'])."</p>";

//echo "<p>".date("Y-m-d H:i:s",$settings['value'])."</p>";
//echo "<p>".date("H:i:s",$settings['value'])."</p>";
//echo "<p>".date("H",$settings['value'])."</p>";
//echo "<p>".date("i",$settings['value'])."</p>";
//echo "<p>".date("s",$settings['value'])."</p>";

		// recupero i valori
			//ho due possibilità, che si tratti di una data i romato DATE oppure TIMESTAMP
			//verifico:
			//$settings['value']
			//echo $settings['value'];
				if(!is_numeric($settings['value']))
				{
				$settings['value']=strtotime($settings['value']);
				}
			$ddValue=date("j",$settings['value']);
			$mmValue=date("n",$settings['value']);
			$yyyyValue=date("Y",$settings['value']);
//echo "<p>".date("d",$settings['value'])."</p>";			
			$hhValue=date("H",$settings['value']);
			$iiValue=date("i",$settings['value']);
			$ssValue=date("s",$settings['value']);


//echo "?<b>".$ddValue."</b>?";
		}
	
		$ddA=array();
		for($i=1;$i<32;$i++){$ddA[]=$i;}
		$mmA=array();
		for($i=1;$i<13;$i++){$mmA[]=$i;}
		$yyyyA=array();
			if($settings['data_di_nascita'])
			{
		$yyyy_start="1900";
		$TOTANNI=(date("Y")-1898);
			}
			else
			{
		$yyyy_start=date("Y")-1;	
		$TOTANNI='6';
			}
		for($i=1;$i<$TOTANNI;$i++){$yyyyA[]=$yyyy_start;$yyyy_start++;}

		$hhA=array();
		for($i=0;$i<24;$i++){$i_ScRIvi=$i;if(strlen($i)=="1"){$i_ScRIvi="0".$i;}$hhA[]=$i_ScRIvi;}
		$iiA=array();
		for($i=0;$i<60;$i++){$i_ScRIvi=$i;if(strlen($i)=="1"){$i_ScRIvi="0".$i;}$iiA[]=$i_ScRIvi;}
		$ssA=array();
		for($i=0;$i<60;$i++){$i_ScRIvi=$i;if(strlen($i)=="1"){$i_ScRIvi="0".$i;}$ssA[]=$i_ScRIvi;}


		$ddName=$settings['name']."dd";
		$mmName=$settings['name']."mm";
		$yyyyName=$settings['name']."yyyy";

		$hhName=$settings['name']."hh";
		$iiName=$settings['name']."ii";
		$ssName=$settings['name']."ss";



	$dd	=select($ddA,$ddName,$ddValue,$ddA_name,$ddId,$addScript_dd);
	$mm	=select($mmA,$mmName,$mmValue,$mmA_name,$mmId,$addScript_mm);
	$yyyy	=select($yyyyA,$yyyyName,$yyyyValue,$yyyyA_name,$yyyyId,$addScript_yyyy);
	

	$hh	=select($hhA,$hhName,$hhValue,$hhA_name,$hhId,$addScript_hh);
	$ii	=select($iiA,$iiName,$iiValue,$iiA_name,$iiId,$addScript_ii);
	$ss	=select($ssA,$ssName,$ssValue,$ssA_name,$ssId,$addScript_ss);

	$html.=$lang['CAMPO_giorno'].''.$dd.'';
	$html.=$lang['CAMPO_mese'].''.$mm.'';
	$html.=$lang['CAMPO_anno'].''.$yyyy.'';

if($settings['h'] || !isset($settings['name']))
{
	$html.=$lang['CAMPO_ora'].''.$hh.'';
	$html.=$lang['CAMPO_minuti'].''.$ii.'';
	$html.=$lang['CAMPO_secondi'].''.$ss.'';
}
	$html.='';
	$html.='';
	
	return $html;
	}














function setFlash($name, $value,$class=null)
  { 
    $msg = serialize($value); 
    $_SESSION['fm'][$name] = $msg; 
  } 

function showFlash($name, $default = null) 
  { 
    $msg = unserialize($_SESSION['fm'][$name]); 
    if ($msg == "") 
      return null; 
    return $msg;   
  } 


function getFlash($name, $default = null) 
  { 
    $msg = unserialize($_SESSION['fm'][$name]); 
//    if ($msg == "") 
//      return null; 
    unset($_SESSION['fm'][$name]); // remove the session after being retrieve   
    return $msg;   
  } 
function hasFlash($name) 
  { 
    if (empty($_SESSION['fm'][$name]))
    { 
      return false; 
    } 
    return true; 
  } 









function _link($url,$anchorText,$att=null)
{
global $rootBase;
global $rootBaseAdmin;
global $selettoreDati;
global $selettoreUrl;
//pr($url);

$url[0]=str_replace("SELETTORE",$selettoreUrl,$url[0]);

$html ='<a href="'.$url[0].$url[1].'" '.$att.'>'.$anchorText.'</a>';
return $html;
}




}
?>
