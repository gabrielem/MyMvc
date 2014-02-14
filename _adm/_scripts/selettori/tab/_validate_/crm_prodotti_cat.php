<?php
class valiDate_crm_prodotti_cat extends valiDate
{


	function vData($k,$_POST,$P,$campi)
	{
		//evito i controlli sul Campo ID
		if($k!="id" && $k!="descrizione")
		{
		//per prima coso controllo che tutti i campi siano presenti nell'ARRAY $_POST
			if(!isset($P[$k])){$err="1";}
			
			//poi verifico se i campi sono vuoti e se non devono esserlo
				//if($P[$k]==""){$err="1";echo "".$k;}
				
			return $err;
		}	
	}


}
?>
