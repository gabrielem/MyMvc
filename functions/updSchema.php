<?php

function updSchema()
{
    global $db;
//echo "a".$db;


$t=showTab($db);
//pr($t);
	$tF=showFields($t);
	//pr($tF);


$mem='<?php
function campiTab($tab,$completo=null){
	switch ($tab) {
';

	$arrayTABELLE='array('."\n";
foreach ($tF as $key => $value) {
		###
		//memorizzo array tab da stampare nella funzione elencoTAB in fondo
		$arrayTABELLE.=$virgola_arrayTABELLE."'".$key."'";$virgola_arrayTABELLE=',';
		###
	$mem.="\n";
	$mem.="/*TABELLA: ".strtoupper($key)."*/";
	$mem.="\n";
	$mem.='	case \''.$key.'\':'."\n";
		//$value


		$separator="";
		$valueArraySTART="array(";
		$valueArrayCompletoSTART="array(";
		//svuoto dai valori precedenti
		$valueArray="";
		$valueArrayCompleto="";
	for($i=0;$i<count($value);$i++)	
	{
		$valueArray.=$separator."'".$value[$i]['Field']."'";
		$valueArrayCompleto.="";
		$valueArrayCompleto.=$separator."\n	";
		$valueArrayCompleto.="'".$value[$i]['Field']."'=>array(";
		$valueArrayCompleto.="'Field' => '".$value[$i]['Field']."',";
		$valueArrayCompleto.="'Type' => '".str_replace("'","\'",$value[$i]['Type'])."',";
		$valueArrayCompleto.="'Null' => '".$value[$i]['Null']."',";
		$valueArrayCompleto.="'Key' => '".$value[$i]['Key']."',";
		$valueArrayCompleto.="'Default' => '".$value[$i]['Default']."',"."";
		$valueArrayCompleto.="'Extra' => '".$value[$i]['Extra']."')";
		
		$separator=",";
	}
		$valueArrayCompletoEND="\n	);";
		$valueArrayEND=");";

	//memorizzo i valori
	$mem.="\n";
	$mem.='	$array='.$valueArraySTART.$valueArray.$valueArrayEND.''."\n";
	$mem.="\n";
	$mem.='	$arrayCompleto='.$valueArrayCompletoSTART.$valueArrayCompleto.$valueArrayCompletoEND.''."\n";
	
	$mem.='	break;'."\n";
	$mem.="\n";	
}



$mem.="\n";
$mem.='
	default:
	$notFound="1";
	}
';

$mem.="\n";	
$mem.="\n";	
$mem.="\n";	

$mem.='
	if($notFound=="1")
	{
	return false;
	}
	else if(empty($completo))
	{
	return $array;
	} 
	else 
	{
	return $arrayCompleto;
	}
';


$mem.='
}

';


$mem."\n\n";
$mem.='
function elencoTAB(){
$a='.$arrayTABELLE.');
return $a;
}
';


$mem.='
?>';





//echo "<pre>".$mem."</pre>";

	//SCRIVO IL FILE	
	if(write(fileSCHEMA,$mem)){
	return true;
        } else {
        return false;
	}

}