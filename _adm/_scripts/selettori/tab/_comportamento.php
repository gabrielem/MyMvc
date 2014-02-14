<?php
####################################################################################
####################################################################################
### COMPORTAMENTO
####################################################################################
####################################################################################

//IMPORTO SE C'E' COMPORTAMENTO PERSONALE DELLA TABELLA
############################
$fileCompTAB=$rootAssoluta.$dirADMIN."_scripts/selettori/tab/_comportamento_/".$tab.".php";
if(file_exists($fileCompTAB)) include($fileCompTAB);
############################
$nomeClasseComp="comportamento_".$tab;
if(class_exists($nomeClasseComp))
{
$comportamentoTab=new $nomeClasseComp();

$dati_elabora['DATI']=$dati;
$dati_elabora['tab']=$tab;
$dati_elabora['tab']=$tab;
$dati_elabora['tab2']=$tab2;
$dati_elabora['tab3']=$tab3;
$dati_elabora['azione']=$azione;



$datiComportamento=$comportamentoTab->_elabora($dati_elabora);

	if($datiComportamento['sovrascrivi_dati']!="")
	{
	$dati=$datiComportamento['sovrascrivi_dati'];
	}
//pr($datiComportamento);
} 

?>