<?php
if(!function_exists(campiTab))
{
    function campiTab($tab,$completo=null)
    {
        $arrayCompleto=showFields(array($tab));
	//pr($arrayCompleto);
            for($i=0;$i<count($arrayCompleto[$tab]);$i++)
            {
            $array[$i]=$arrayCompleto[$tab][$i]['Field'];
            }
	    
	    for($i=0;$i<count($arrayCompleto[$tab]);$i++)
            {
            $arrayCompleto_NEW[$arrayCompleto[$tab][$i]['Field']]=$arrayCompleto[$tab][$i];
            }
	    
	    
            
            //pr($array);
        if(empty($completo))
	{
	return $array;
	} 
	else 
	{
	return $arrayCompleto_NEW;
	}
    }
}

if(!function_exists(elencoTAB))
{

    function elencoTAB()
    {
        $db="libraio";
        //echo "A".$db;
        $a=showTab($db);
        //pr($a);
        return $a;
    }

}
?>