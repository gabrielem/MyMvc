<?php
class FILTER
{
    function write($a,$settings)
    {
        $tab=$settings['tab'];
        //Error if tba fields are empty
        if(empty($a['USE_TAB']) || empty($tab)) {
            if(DEBUG) _CORE::doAlert('FILTER manyToOne'."\\n".'For tab:'.$tab.' on '.$a['USE_TAB'].''."\\n".'ERR: USE_TAB or REL_TAB not set');
            return false;
        }

        //Analyze relations and chose function
        global $RELATIONS_DB_ARRAY;
        $a[$a['USE_TAB']]['dbRelations']=$RELATIONS_DB_ARRAY[$a['USE_TAB']];
        
        
        //pr($a[$a['USE_TAB']]['dbRelations']);
        foreach($a[$a['USE_TAB']]['dbRelations'] as $k=>$v)
        {
            if($v[tab]==$tab)
            {
                $rel_type=$v[rel];
                break;
            }
        }
        if(!isset($rel_type))
        {
            //Relations not  exists!
            if(DEBUG) _CORE::doAlert('FILTER manyToOne'."\\n".'For tab:'.$tab.' on '.$a['USE_TAB'].''."\\n".'ERR: Relation not exists');
            
        } else {
            //echo $rel_type;
            $rel_type=explode("-",$rel_type);
            $function=$rel_type[0].ucfirst($rel_type[1]).ucfirst($rel_type[2]);
                
            return FILTER::$function($a,$settings);
        }
        
    }
    
    
    
    
    
    function manyToOne($a,$settings)
    {
        $tab=$settings['tab'];
        $type=$settings['type'];
        $field_value=$settings['field_value'];
        $field_name=$settings['field_name'];
        $field_anchor=$settings['field_anchor'];
        $selected_value=$settings['selected_value'];
        $allow_zero=$settings['allow_zero']; //Must be the name to display is need only to be set
        $where=$settings['where'];
        
        
        
        
        
        //Set Default Var
        if(empty($type))$type="option";
        if(empty($field_value))$field_value="id";
        if(empty($field_anchor))$field_anchor="id";
            
            
$SELECTED_VALUE=FILTER::setSelectValue($a,$tab,$selected_value,$settings);
                
                
            //Do loop of all Tab item:
            //echo $tab;
            $loop=dbAction::_loop(array('tab'=>$tab,'where'=>$where,'orderby'=>$settings['orderby']));
            
        if($type=="option")
        {
            //echo "".$id_relation;
            //pr($a['R'][$a['USE_TAB']]);
            if($loop)
            {
                foreach($loop as $k=>$v)
                {
                    //Looking for id_"TABLE-REL-NAME" field
                    $selected="";
                    if($SELECTED_VALUE==$v[$field_value])
                    {
                        $selected=" selected";
                    }
                    if(is_array($field_anchor))
                    {
                        $SET_field_anchor="";
                        foreach($field_anchor as $iFA=>$vFA)
                        {
                            if(substr($vFA,0,1)=="#")
                            {
                                $vFA=str_replace("#","",$vFA);
                            $SET_field_anchor.=$v[$vFA]."";
                            }
                            else
                            {
                                $SET_field_anchor.=$vFA."";
                            }
                            
                        }
                    }
                    else
                    {
                        $SET_field_anchor=$v[$field_anchor];
                    }
                    $filter.='<option value="'.$v[$field_value].'"'.$selected.'>'.$SET_field_anchor.'</option>';
                }
            }
        }
        
        
        
            if(!empty($allow_zero))
            {
                
                $filter='<option value="0">'.$allow_zero.'</option>'.$filter;
            }
        
        return $filter;
    }












    /*
    many-to-many
    */
    function manyToMany($a,$settings)
    {
        //pr($a);
        $tab=$settings['tab'];
        $type=$settings['type'];
        $field_value=$settings['field_value'];
        $field_anchor=$settings['field_anchor'];
        $selected_value=$settings['selected_value'];
        
        $id_main_tab=$settings['id_main_tab'];
        
        $tabRelToTab=$a['USE_TAB']."_".$tab;
        //pr($tabRelToTab);
        $field_id_tab1="id_".$a['USE_TAB'];
        $field_id_tab2="id_".$tab;
        
        $id_tab1=$a['R'][$a['USE_TAB']]['id'];
        
        $orderby=$settings['orderby'];
        
        //pr($settings);
        /*
        If $selected_value is not set
        take the value from id of the record if there is!
        
        */
            $w="WHERE ".$field_id_tab1."='".$id_tab1."'";
            //echo $w;
            //pr("SELECT * FROM ".$tabRelToTab." ".$w);
            $loop_sel_val=dbAction::_loop(array('tab'=>$tabRelToTab,'where'=>$w,'echo'=>'0'));
            //pr($loop_sel_val);
            
            for($i=0;$i<count($loop_sel_val);$i++)
            {
                $selected_value_BASE[]=$loop_sel_val[$i][$field_id_tab2];
            }
            
            $settings['selected_value_BASE']=$selected_value_BASE;
            
        if(empty($selected_value) && !empty($id_tab1) )
        {
            $selected_value=$selected_value_BASE;
        }
        elseif(!empty($selected_value) && !is_array($selected_value))
        {
            $selected_value=array($selected_value);
        }
        //pr($selected_value);
        
        
        
        //Set Default Var
        if(empty($type))$type="option-multiple";
        if(empty($field_value))$field_value="id";
        if(empty($field_anchor))$field_anchor="id";
            
            
            
            //Do loop of all Tab item:
            //echo $tab;
            //$limit=" LIMIT 0,100000";
            //echo'<p>'.$tab.'</p>';
            //pr($selected_value_BASE);
                if(isset($settings['only_selected_value']) && isset($settings['take_selected_value_from_relations']) )
                {
                    //pr($settings);
                    //pr($selected_value_BASE);
                    $where=" WHERE ";
                    foreach($selected_value_BASE AS $indexOf => $id_sel_base)
                    {
                        $where.=$andd." id='".$id_sel_base."' ";
                        $andd=" OR ";
                    }
                    //echo $where;
                    $loop=dbAction::_loop(array('tab'=>$tab,'where'=>$where,'orderby'=>$orderby,'limit'=>$limit,'echo'=>'0'));
                }
                else
                {
                    //pr($settings);
                    if(!isset($settings['no_loop']))
                    {
                        $where=$settings['where'];
                        $loop=dbAction::_loop(array('tab'=>$tab,'where'=>$where,'orderby'=>$orderby,'limit'=>$limit));
                    }
                }
                
            //pr($loop);
            //echo $type;
            
        /*************************************************************
        *
        *
        *
        *   $type=="checkbox" 
        *
        *
        *
        *************************************************************/
        //
        if($type=="checkbox")
        {
            //echo "".$id_relation;
            //pr($a['R'][$a['USE_TAB']]);
            //pr($loop);
            //pr($settings);
            if($loop)
            {
                foreach($loop as $k=>$v)
                {
                    if(is_array($field_anchor))
                    {
                        $VAR_field_anchor="";
                        for($iI=0;$iI<count($field_anchor);$iI++)
                        {
                        $VAR_field_anchor.=$v[$field_anchor[$iI]]." - ";
                        }
                    }
                    else
                    {
                    $VAR_field_anchor=$v[$field_anchor];
                    }
                    //Looking for id_"TABLE-REL-NAME" field
                    $selected="";
                    //pr($selected_value);
                    if(is_array($selected_value) && in_array($v[$field_value],$selected_value))
                    {//pr("A");
                        $selected=" checked";       
                    $filter1.='<input type="checkbox" name="'.$settings['name_f'].'" value="'.$v[$field_value].'"'.$selected.' id="'.$field_value.$v[$field_value].'">
                    <label class="sel" for="'.$field_value.$v[$field_value].'">'.$VAR_field_anchor.'</label><br />';
                    }
                    else
                    {//pr("AAA");
                    $filter2.='<input type="checkbox" name="'.$settings['name_f'].'" value="'.$v[$field_value].'"'.$selected.'id="'.$field_value.$v[$field_value].'">
                    <label for="'.$field_value.$v[$field_value].'">'.$VAR_field_anchor.'</label><br />';
                    }
                }
            $filter.=$filter1;
            $filter.=$filter2;
            } else {
            //NO RECORD...
                $filter="no record";
                if($settings['no_record_MSG'])
                {
                    $filter=$settings['no_record_MSG'];
                }
            }
            
            //echo 'a';
            
        }
            
            
            
            
        /*************************************************************
        *
        *
        *
        *   $type=="option-multiple" 
        *
        *
        *
        *************************************************************/
        elseif($type=="option-multiple")
        { 
            //echo "".$id_relation;
            //pr($a['R'][$a['USE_TAB']]);
            foreach($loop as $k=>$v)
            {
                if(is_array($field_anchor))
                {
                    $VAR_field_anchor="";
                    for($iI=0;$iI<count($field_anchor);$iI++)
                    {
                    $VAR_field_anchor.=$v[$field_anchor[$iI]]." - ";
                    }
                }
                else
                {
                $VAR_field_anchor=$v[$field_anchor];
                }
                //Looking for id_"TABLE-REL-NAME" field
                $selected="";
                //pr($selected_value);
                if(is_array($selected_value) && in_array($v[$field_value],$selected_value))
                {//pr("A");
                    $selected=" selected";
                $filter1.='<option value="'.$v[$field_value].'"'.$selected.'>'.$VAR_field_anchor.'</option>';
                }
                else
                {//pr("AAA");
                $filter2.='<option value="'.$v[$field_value].'"'.$selected.'>'.$VAR_field_anchor.'</option>';
                }
            }
            $filter ='<optgroup label="Selected Value">';
            $filter.=$filter1;
            $filter.='</optgroup>';
            $filter.='<optgroup label="Not Selected Value">';
            $filter.=$filter2;
            $filter.='</optgroup>';
            
            //echo 'a';
        }
            
            
        /*************************************************************
        *
        *
        *
        *   $type=="option" 
        *
        *
        *
        *************************************************************/
            
            
        elseif($type=="option")
        {
            //$SELECTED_VALUE=$selected_value;
            $SELECTED_VALUE=FILTER::setSelectValue($a,$tab,$selected_value,$settings);
            
            //echo "".$id_relation;
            //pr($a['R'][$a['USE_TAB']]);
            if($loop)
            {
                foreach($loop as $k=>$v)
                {
                    //Looking for id_"TABLE-REL-NAME" field
                    $selected="";
                    if($SELECTED_VALUE==$v[$field_value])
                    {
                        $selected=" selected";
                    }
                    $filter.='<option value="'.$v[$field_value].'"'.$selected.'>'.$v[$field_anchor].'</option>';
                }
            }
        }
            
            
            
        /*************************************************************
        *
        *
        *
        *   $type=="autocomplete" 
        *
        *
        *
        *************************************************************/
            
            
        elseif($type=="autocomplete")
        {
        $ajaxHelper=New ajaxHelper();
        $a=$ajaxHelper->autocomplete_input_manyToMany($a,$settings);
            //pr($a['AJAX']);
            $filter="".$a['AJAX']['autocomplete_input_manyToMany'];
            
        }
        
        
        
        
        
            
            
            
        /*************************************************************
        *
        *
        *
        *   $type=="checkbox" 
        *
        *
        *
        *************************************************************/
            
            
        elseif($type=="checkbox")
        {
            
            $SELECTED_VALUE=FILTER::setSelectValue($a,$tab,$selected_value,$settings);
            //pr($SELECTED_VALUE);
            //echo "".$id_relation;
            //pr($a['R'][$a['USE_TAB']]);
            //pr($loop);
            
                //pr($field_anchor);
                
                
            if($loop)
            {
                //pr($loop);
                $count='0';
                foreach($loop as $k=>$v)
                {
                    if(is_array($field_anchor))
                    {
                        $VAR_field_anchor="";
                        for($iI=0;$iI<count($field_anchor);$iI++)
                        {
                        $VAR_field_anchor.=$v[$field_anchor[$iI]]." - ";
                        }
                    }
                    else
                    {
                    $VAR_field_anchor=$v[$field_anchor];
                    }
                        
                        
                    //Looking for id_"TABLE-REL-NAME" field
                    $selected="";
                    if(in_array($v[$field_value],$SELECTED_VALUE))
                    {
                        $selected=" checked";
                    }
                    $filter.='<input type="checkbox" id="'.$count.$settings['name_f'].'" name="'.$settings['name_f'].'" value="'.$v[$field_value].'"'.$selected.'>';
                    $filter.='<label for="'.$count.$settings['name_f'].'">'.$VAR_field_anchor.'</label><br />';
                        
                    
                $count++;
                    
                }
            }
            
            
        }
        
        return $filter;
    }














    function setSelectValue($a,$tab,$selected_value=null,$settings=null)
    {
        //echo'AAA';
            if($settings['take_selected_value_from_relations'])
            {
                //echo 'AA';
                
                //pr($settings['selected_value_BASE']);
                return $settings['selected_value_BASE'];
            }
                
                
                    //Set ID FOR RELATIONS
            $id_relation="id_".$tab;
            
                //$SELECTED_VALUE Set the value selected for the <SELECT>
                //$id_relation=$a['R'][$a['USE_TAB']][$id_relation];
                if(!empty($selected_value)){
                    //If $settings[selected_value] is SET!
                    //This as priority on other vars.
                    //Set it:
                    $SELECTED_VALUE=$selected_value;
                }
                elseif(isset($a['R'][$a['USE_TAB']][$id_relation]))
                {
                    //Else, can be set directly on the R: record data
                    //If it is Set it:
                    $SELECTED_VALUE=$a['R'][$a['USE_TAB']][$id_relation];
                }
                elseif(isset($a['FILTER_SET'][$a['USE_TAB']][$tab]))
                {
                    //In this case try to recover $a['FILTER_SET']
                    // If there is a combination of TAB & TAB_REL:
                    
                    $SELECTED_VALUE=$a['FILTER_SET'][$a['USE_TAB']][$tab]['value'];
                    
                }
                
                return $SELECTED_VALUE;
        
    }
}