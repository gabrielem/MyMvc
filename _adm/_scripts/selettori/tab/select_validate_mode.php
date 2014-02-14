<?php
###
//VERIFICO SE ESISTE UNA CLASSE DI VALIDAZIONE SPECIALE PER LA TAB
$validazioneDatiTAB="valiDate_".ucfirst(strtolower($tab));
$validazioneDatiDEFAULT="valiDate";
//echo '<h1>'.$validazioneDatiTAB.'</h1>';

$fileValidate=$rootAssoluta.$dirADMIN."_scripts/selettori/tab/_validate_/".strtolower($tab).".php"; 

	if (class_exists($validazioneDatiTAB)) 
	{//echo'1';
	$validazioneDati=$validazioneDatiTAB;
	}
	else if(file_exists($fileValidate))
	{//echo'2';
	include($fileValidate);
	$validazioneDati=$validazioneDatiTAB;
	} 
	else 
	{//echo'3';
	$validazioneDati=$validazioneDatiDEFAULT;
	}
###
?>
