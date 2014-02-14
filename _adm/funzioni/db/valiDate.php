<?php
class valiDate
{	




	function vData($k,$_POST,$P,$campi)
	{
		//evito i controlli sul Campo ID
		if($k!="id")
		{
		//per prima coso controllo che tutti i campi siano presenti nell'ARRAY $_POST
			if(!isset($P[$k])){$err="1";}
			
			//poi verifico se i campi sono vuoti e se non devono esserlo
				if($P[$k]==""){$err="1";}
			return $err;
		}	
	}



	function _specialDati($k,$_POST,$P,$campi)
	{
	$value=$P[$k];
	return $value;
	}












### private, in genere è meglio non modificare queste funzioni dalla classe valiDate_TABELLA





	function dati($P,$t)
	{
	$campi=campiTab($t,1);
		$P2=array();
		foreach($campi as $k=>$v)
		{
		//echo $k."=>".$v."<br/>";
			//escludo ID ed auto_icrement FIELDS
			if(strtolower($v['Field'])!='id' && strtolower($v['Extra'])!='auto_increment'){


$P[$k]=$this->datiAddFunction($k,$_POST,$P,$campi);

##################################### NOME_URI
//$P[$k]=$this->slug($k,$_POST,$P,$campi);
##################################### DATA
//$P[$k]=$this->campoData($k,$_POST,$P,$campi);
##################################### SPECIAL
//$P[$k]=$this->_specialDati($k,$_POST,$P,$campi);



		$P2[$k]=$P[$k];
			}
		}
		return $P2;
	}


	function valid($P,$t)
	{
	$err='';
	$campi=campiTab($t,1);
		foreach($campi as $k=>$v)
		{
		//echo $k."=>".$v."<br/>";
#####			
$errV=$this->vData($k,$_POST,$P,$campi);
	if($errV=="1"){$err="1";}

		}
	//dati
		
		if($err=='1')
		{
		return false;
		} 
		else 
		{
		return true;
		}
	}
	

function datiAddFunction($k,$_POST,$P,$campi)
{
##################################### NOME_URI
$P[$k]=$this->slug($k,$_POST,$P,$campi);
##################################### DATA
$P[$k]=$this->campoData($k,$_POST,$P,$campi);
##################################### SPECIAL
$P[$k]=$this->_specialDati($k,$_POST,$P,$campi);
return $P[$k];
}












	function slug($k,$_POST,$P,$campi)
	{
		### speciale campi nome_uri
		if($k=="nome_uri")
		{
			if($P['nome_uri']=="")
			{
			$P['nome_uri']=slug($P['nome']);
			}
			else
			{
			$P['nome_uri']=slug($P['nome_uri']);
			}
		$value=$P['nome_uri'];
		}
		else
		{
		$value=$P[$k];
		}
	return $value;
	}







	function campoData($k,$_POST,$P,$campi)
	{
############################################################################################
### speciale campi DATA

if(substr($k,0,4)=="data")
{



//echo $k.'<br/>';
//pr($_POST);
//è un campo data allora verifico se i valori sono separati e se sono corretti!!!
$dd=$_POST[$k."dd"];
$mm=$_POST[$k."mm"];
$yyyy=$_POST[$k."yyyy"];

$hh=$_POST[$k."hh"];
$ii=$_POST[$k."ii"];
$ss=$_POST[$k."ss"];

	if(empty($hh))$hh=date("h");
	if(empty($ii))$ii=date("i");
	if(empty($ss))$ss=date("s");

	$data=$yyyy."-".$mm."-".$dd." ".$hh.":".$ii.":".$ss;
//echo "<p>".$data."</p>";
$timestamp=strtotime($data);
//echo "time. ".$timestamp;

	//controllo si tratti di una data valida
	if(checkdate(date("m",$timestamp), date("d",$timestamp), date("Y",$timestamp) ))
	{
		//il campo + un timestamp o un date?
		if(substr($campi[$k]['Type'],0,3)=='int')
		{
		//si tratta di un campo TimeStamp
		//valorizzo il dato
		$value=$timestamp;
		//$P[$k]=$timestamp;
		}
		else
		{
		$value=$data;
		//$P[$k]=$data;
		}
	}
	//echo $k.'';
	//return $P[$k];
	//return $value;


	//VERIFICO Se LA DATA PASSATA è GIà un timestamp in tal caso salvo il risultato cosi com'è
	echo "".$P[$k]."";
	if(is_time($P[$k]) && !empty($P[$k]))
	{
	$value=$P[$k];
	}

}
else
{
$value=$P[$k];
}

############################################################################################
	return $value;	
	}
}
?>
