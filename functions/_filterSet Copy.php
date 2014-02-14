<?php
class FILTER_SET
{
    function set($a,$settings=null)
    {
    //pr($a);
    //pr($a[getAllowed]);
    //pr($a[ACTUAL_getAllowed]);
    
    
        if(empty($a['USE_TAB'])) {
            $a['ALERT']="<p>No Table is set</p>";
        } else {
            
            global $RELATIONS_DB_ARRAY;
            if(isset($RELATIONS_DB_ARRAY[$a['USE_TAB']]))
            {
                
            } else { $a['ALERT']="<p>Not Exists Relations for this Table</p>"; }
            
            //pr($RELATIONS_DB_ARRAY[$a['USE_TAB']]);
            
            /*
            Is on the base of the array: $RELATIONS_DB_ARRAY[$a['USE_TAB']]
            that I will looking for some GET or POST to set for the FILTER
            
            The name of the VAR (Get or Post) MUST be id_{table_name}
            For multiple var too!
            es: id_{table_name}=array();
            
            So, lets do a loop from this array: 
            */
            foreach($RELATIONS_DB_ARRAY[$a['USE_TAB']] AS $k=>$v)
            {
                $idNameTable="id_".$v[tab];
                $set_this=null;
                if(isset($a['GET_DATA'][$idNameTable]))
                {
                    $set_this=$a['GET_DATA'][$idNameTable];
                    $set_this_MODE="GET";
                }
                elseif(isset($a['POST_DATA'][$idNameTable]))
                {
                    $set_this=$a['POST_DATA'][$idNameTable];
                    $set_this_MODE="SESSION";
                }
                
                $relDB[]=array('tab'=>$v[tab],'rel'=>$v[rel],'set'=>array('key'=>$idNameTable,'value'=>$set_this),'mode'=>$set_this_MODE);
                
            }
            
            
            //pr($relDB);
            
            
            # 1.  
            //Make a serach in ACTUAL_getAllowed
            //To know if there is a setting for this filter!
            //pr($a['ACTUAL_getAllowed']);
                
                //Init the CHILD ARRAY from child or multichild
                $CHILD=null;if(isset($a['ACTUAL_getAllowed']['child'])){$CHILD=$a['ACTUAL_getAllowed']['child'];}
                elseif(isset($a['ACTUAL_getAllowed']['multi_child'])){$CHILD=$a['ACTUAL_getAllowed']['multi_child'];}
                
            if(is_array($CHILD))
            {
            //If is_array() we have some child... so Do the loop && check
                //pr($CHILD);
                foreach($CHILD as $k=>$v)
                {
                    $k=getArrayKey($v);
                    //echo'<p><b>CHILD</b>:'.$v.'</p>';
                    
                    //pr($relDB);
                    //foreach($relDB as $k2=>$v2)
                    for($i=0;$i<count($relDB );$i++)
                    {
                        //pr($v2);
                        
                        //Find a GET Allowed, so do it in GET!
                        //&& In this case have to do nothing
                        //The set is olready there!
                        //Becouse is a get var!
                        //... stil remain case of ?id_{name_table}
                        //link in the test for this script...
                        //
                        
                        //If $relDB[KEY] is not empty GET is find
                        //if(isset($v2[$k]) && !empty($v2[$k]))
                        
                        //echo'<p>check: '.$relDB[$i][set][key].' - '.$k.'</p>';
                        
                        if($relDB[$i][set][key]==$k)
                        {
                        //Setting the array of FILTER SET for TAB->tabRel 
                        
                        $relDB[$i]['mode']="GET";
                        break;
                        }
                    }
                }
            }
            
            
            /*
            Here know if the filter is in a request of getAllowed fileds
            And now redirect for filter.
            */
            
            
            /* LOOP OF ALL $relDB && Set !empty() one...
            *************************************************
            *                                               *
            * BY GET ONLY ONE VALUE PER TIME ON FILTER MODE *
            *                                               *
            *************************************************
            */
            
            for($i=0;$i<count($relDB);$i++)
            {
                $relDB_TAB=$relDB[$i]['tab'];
                $relDB_REL=$relDB[$i]['rel'];
                $relDB_SET=$relDB[$i]['set'];
                $relDB_MODE=$relDB[$i]['mode'];
                $k=$relDB_SET['key'];
                $v=$relDB_SET['value'];
                
                if(!empty($v))
                {
                $a['FILTER_SET'][$a['USE_TAB']][$relDB_TAB]=array('key'=>$k,'value'=>$v,'mode'=>$relDB_MODE,'rel'=>$relDB_REL);
                }
            }
            
            
            
            
            
            
            
            //$a['FILTER_SET'][$a['USE_TAB']][$v2['tab']]=array('key'=>$k,'value'=>$v2[$k],'mode'=>'GET','rel'=>$v2[rel]);
                        
        }
    pr($relDB);
    //pr($a['FILTER_SET']);
    //echo'<p>FILTER_SET</p>';
    return $a;
    }






}