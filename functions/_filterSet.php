<?php
class FILTER_SET
{
/************************************************************************************************
*************************************************************************************************

This class: FILTER_SET is included on: rootCore.loadSubModels.php
as different pourpose:
    
    //SET es: setS_id_utrenti=1;
    
1. Setting a COOKIE, SESSION or GET from a set{x}_id_{table_name} var
2. Recovering all set function and put in $a['FILTER_SET'] (f: getAllInitFilter()  )

*************************************************************************************************
************************************************************************************************/    
    
    function set($a,$settings=null)
    {
        /*
        BLOCK THE EXECUTION OF ALL THE FUNCTION IF(empty($a['USE_TAB'])) 
        */
        if(empty($a['USE_TAB'])) return $a;
        
    global $RELATIONS_DB_ARRAY;
    $tabRel=$RELATIONS_DB_ARRAY[$a['USE_TAB']];
    //pr($a);
    //pr($a[getAllowed]);
    //pr($a[ACTUAL_getAllowed]);
    //pr($tabRel);
        for($i=0;$i<count($tabRel);$i++)
        {
                
            $TAB_REL=$tabRel[$i]['tab'];
            $nome_varC="setC_id_".$TAB_REL; //For COOKIE SET
            $nome_varG="setG_id_".$TAB_REL; //For GET SET
            $nome_varS="setS_id_".$TAB_REL; //For SESSION SET
            
            /*
            Look in COOKIE, SESSION & GET FOR Initialized FILTER
            and Set it on var FILTER_SET used by filterCheck
            becouse filterSet is called from loadSubModels.php
            */
            //pr($tabRel[$i]);
            $a['FILTER_SET']=FILTER_SET::getAllInitFilter($a,$tabRel[$i]);
            
            
            $set_this=false;
                
                //echo'<p>cerco: '.$nome_varC.'</p>';
            # 
            # TRY TO FIND A SET VALUE FOR INITIALIZE
            # THE FILTER or in GET or in POST   
            # Now look on the 3 var in GET && POST so 6 try!
            #
            #___GET____________            
            if(!empty($a['GET_DATA'][$nome_varC])){$set_this=$nome_varC;$type="GET_DATA";$arrayRelDB=$tabRel[$i];break;}
            elseif(!empty($a['GET_DATA'][$nome_varS])){$set_this=$nome_varS;$type="GET_DATA";$arrayRelDB=$tabRel[$i];break;}
            elseif(!empty($a['GET_DATA'][$nome_varG])){$set_this=$nome_varG;$type="GET_DATA";$arrayRelDB=$tabRel[$i];break;}
            #___POST___________
            elseif(!empty($a['POST_DATA'][$nome_varC])){$set_this=$nome_varC;$type="POST_DATA";$arrayRelDB=$tabRel[$i];break;}
            elseif(!empty($a['POST_DATA'][$nome_varS])){$set_this=$nome_varS;$type="POST_DATA";$arrayRelDB=$tabRel[$i];break;}
            elseif(!empty($a['POST_DATA'][$nome_varG])){$set_this=$nome_varG;$type="POST_DATA";$arrayRelDB=$tabRel[$i];break;}
                
        } //CLOSE LOOP $tabRel
        
        //pr($arrayRelDB);
        
        if($set_this)
        {
        $TYPE_VAR_TO_SET=FILTER_SET::giveMeVarSetType($set_this);
        $VALUE_TO_SET=$a[$type][$set_this];
        $KEY_TO_SET="id_".$arrayRelDB[tab];
        //echo '<p>TYPE_VAR_TO_SET: '.$TYPE_VAR_TO_SET.'</p>';
        
            if($TYPE_VAR_TO_SET=="COOKIE")
            {
            echo'SETTING COOKIE DISABLED NOW!';exit;
            }
            elseif($TYPE_VAR_TO_SET=="SESSION")
            {
                if($VALUE_TO_SET=="0" || $VALUE_TO_SET=="clear")
                {
                unset($_SESSION['FILTERS'][$a['USE_TAB']][$arrayRelDB[tab]]);
                } else {
                $_SESSION['FILTERS'][$a['USE_TAB']][$arrayRelDB[tab]]=array('key'=>$KEY_TO_SET,'value'=>$VALUE_TO_SET,'rel'=>$arrayRelDB[rel],'type'=>$TYPE_VAR_TO_SET);
                }
            header("location: ".$a['url_mod']);exit;
            }
            elseif($TYPE_VAR_TO_SET=="GET")
            {
            echo'SETTING GET DISABLED NOW!';exit;
            }
            else
            {
            echo'';exit;
            }
        }

    
    return $a;
    }


    function getAllInitFilter($a,$tabRel)
    {
    /*****************************************************
    * This function is called inside a loop of $tabRel
    *
    *****************************************************/
    //$a['FILTER_SET']
    //pr($_SESSION['FILTERS']);
        if(isset($_SESSION['FILTERS'][$a['USE_TAB']][$tabRel['tab']]))
        {
            //pr($_SESSION['FILTERS'][$a['USE_TAB']][$tabRel['tab']]);
            $a['FILTER_SET'][$a['USE_TAB']][$tabRel['tab']]=$_SESSION['FILTERS'][$a['USE_TAB']][$tabRel['tab']];
        }
                
        
    return $a['FILTER_SET'];
    }


    function giveMeVarSetType($var)
    {
        if(substr($var,0,4)=="setC"){$type="COOKIE";}
        elseif(substr($var,0,4)=="setG"){$type="GET";}
        elseif(substr($var,0,4)=="setS"){$type="SESSION";}
        else return false;
        
        return $type;
    }
}