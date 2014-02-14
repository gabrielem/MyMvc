<?php
//class comportamento_crm_ordini extends valiDate
class comportamento_a_utenti 
{

	function _elabora($a)
	{
	global $TAB_a_utenti;

	//echo '<p>azione: '.$dati['azione'].'</p>';
	$id_record=$_GET[$a['azione']];
	
	$tab=$a['tab'];
	$tab2=$a['tab2'];
	$tab3=$a['tab3'];
	
	$_POST['password']=md5($_POST['password']);
	//pr($_POST);
	//exit;
	}




	
}
?>
