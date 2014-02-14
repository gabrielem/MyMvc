<?php
class getPost
{
	function ascolta($P,$c)
	{
	if(isset($P[$c])){return true;}
	else{return false;}
	}
	
	function cercaVar($P,$cA)
	{
	//pr($P);
	//pr($cA);
		$trovato=false;
		if($P)
		{
			for($i=0;$i<count($cA);$i++)
			{
			//echo $cA[$i]."<br/>";
			//if(in_array($cA[$i],$P)){$trovato=true;}
			if(isset($P[$cA[$i]])){$trovato=true;}
			}
		}
		return $trovato;
	}
	
}


?>
