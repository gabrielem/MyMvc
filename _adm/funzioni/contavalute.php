<?php
function contavalute($valore,$arrayValute,$report="euro")
{
	if($report=="euro")
	{
	//$valore,$arrayValute
	//echo '<p>questo: '.$valore.'</p>';
	$result=number_format($valore*$arrayValute['euro'], 2, '.', '');
	//echo $result;
	//pr($arrayValute);
	}
	else
	{
	//echo $arrayValute['euro'];
	//$result=number_format($valore/$arrayValute['euro'], 2, '.', '');
	$result="metodo non supportato";
	}
	return $result;
}

?>
