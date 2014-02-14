<?php
class FILTER_CHECK
{
    function setWhere($a,$settings=null)
    {
        
        $LOOP_TAB=$a['USE_TAB'];
        ###########################
	### CHECK RELATIONS
	global $RELATIONS_DB_ARRAY;
	$dbRel=$RELATIONS_DB_ARRAY[$LOOP_TAB];
	    
	if(isset($dbRel))
	{
	    //echo '<h2>REL:</h2>';
	    //pr($dbRel);
	    foreach($dbRel as $k=>$v)
	    {
            //Name of Function
            $rel_type=explode("-",$v[rel]);
            $function=$rel_type[0].ucfirst($rel_type[1]).ucfirst($rel_type[2]);
                    
                $settings=array('tab'=>$v[tab],'rel'=>$v[rel]);
                    
                //Setting the function to retrive value for query
		$a=FILTER_CHECK::$function($a,$settings);
		//echo "<p>".$v[rel]."</p>";
                //pr($a['FILTER_SET']);
                
                
                
	    }
	}
	###########################
	
        
    return $a;
        
    }
    

    function manyToMany($a,$settings=null)
    {
	//echo "...".$settings[tab]."...";
	if($a['FILTER_SET'][$a['USE_TAB']][$settings[tab]])
        {
	    $TAB_REL=$a['USE_TAB']."_".$settings[tab];
        //pr($a['FILTER_SET'][$a['USE_TAB']]);
	$A=$a['FILTER_SET'][$a['USE_TAB']][$settings[tab]];
            //$A[key];$A[value];$A[type];$A[rel];
            //echo'A';$TAB2=getArrayKey($a['FILTER_SET'][$a['USE_TAB']]);
	$a['TAB2'][$a['USE_TAB']]=$TAB_REL;
	    $ID_TAB1="id_".$a['USE_TAB'];
		
		//Make the WHERE
		
	    $W =" AND ".$TAB_REL.".".$A[key]."='".$A[value]."' ";
	    $W.=" AND ".$a['USE_TAB'].".id=".$TAB_REL.".".$ID_TAB1;
        //echo "<p><b>".$W."</b></p>";
	$a['WHERE'][$a['USE_TAB']][]=$W;
	}
	
	return $a;
    }
    
    function manyToOne($a,$settings=null)
    {
        //pr($settings);
        //pr($a['FILTER_SET'][$a['USE_TAB']]);
        //pr($a['FILTER_SET'][$a['USE_TAB']][$settings[tab]]);
        if($a['FILTER_SET'][$a['USE_TAB']][$settings[tab]])
        {
            $A=$a['FILTER_SET'][$a['USE_TAB']][$settings[tab]];
            //$A[key];$A[value];$A[type];$A[rel];
            //echo'A';
            $a['WHERE'][$a['USE_TAB']][]=" AND ".$a['USE_TAB'].".".$A[key]."='".$A[value]."' ";
            
        }
        return $a;
    }
    
}