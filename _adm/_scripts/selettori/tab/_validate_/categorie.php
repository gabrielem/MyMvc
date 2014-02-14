<?php
class valiDate_categorie extends valiDate
{


	function vData($k,$_POST,$P,$campi)
	{
	
		//evito i controlli sul Campo ID
		if(
		$k!="id"
		&& $k!="nome_uri"
		)
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

}
?>
