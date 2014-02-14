<?php
class valiDate_sezioni extends valiDate
{


	function vData($k,$_POST,$P,$campi)
	{
	
		//evito i controlli sul Campo ID
		if(
		$k!="id"
		&& $k!="voce_menu"
		&& $k!="menu_up"
		&& $k!="testo"
		&& $k!="testo2"
		)
		{
		//per prima coso controllo che tutti i campi siano presenti nell'ARRAY $_POST
			if(!isset($P[$k])){$err="1";}
			
			//poi verifico se i campi sono vuoti e se non devono esserlo
				if($P[$k]==""){$err="1";
				echo $k."<br />";
				}

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
