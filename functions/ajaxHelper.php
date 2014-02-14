<?php
class ajaxHelper
{
    /*
        note: MAGIC COSTANT: print __FUNCTION__." in ".__FILE__." at ".__LINE__."\n";
        
        SOME REQUIREMENT 
        1. This class better if is called from a model or a controller
        becaouse it can provide automaticaly the JS file in the head
        
        
        
    */
    
    
    
        
    /**************************************************************
    *
    *
    *   autocomplete_search
    *   
    *
    *
    ***************************************************************/
        
    function autocomplete_search($a,$settings)
    {
        //$settings=array('store_in'=>VAR',source'=>URL,'form_id'=>'search','field_q'=>'q','field_t'=>'t');
        
        /*
            
            Setting deault vars
            
        */
        if(empty($settings['store_in']))$settings['store_in']=__FUNCTION__;
            
        if(empty($settings['field_q']))$settings['field_q']="q";
        if(empty($settings['field_t']))$settings['field_t']="t";
        if(empty($settings['field_id_record']))$settings['field_id_record']="id_record";
            
        if(empty($settings['form_id']))$settings['form_id']="search";
            
        /*
            
            Required vars
            
        */
        if(empty($settings['source'])){echo'<p>ERROR: var <b>settings[source]</b> is required<br /><b>'.__FUNCTION__.'</b> in <b>'.__FILE__.'</b> at <b>'.__LINE__."</b>\n".'</p>';}
            
            
        //<link href="'.rootWWW.'js/jquery-ui-1.8.21/css/smoothness/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css"/>
            
        $JS='
        <script src="'.rootWWW.'js/jquery-ui-1.8.21/js/jquery-1.7.2.min.js"></script>
        <script src="'.rootWWW.'js/jquery-ui-1.8.21/js/jquery-ui-1.8.21.custom.min.js"></script>
        ';
            
        $html=$this->__getHTML(__FUNCTION__);
            
        $settings=array_merge($settings,array('JS'=>$JS,'html'=>$html));
            
            
            
        $a=$this->__init($a,$settings);
        //pr($a);
        return $a; 
    }
        
        
        
        
        
        
        
        
        
    /**************************************************************
    *
    *
    *   autocomplete_input_manyToMany
    *   
    *
    *
    ***************************************************************/
        
    function autocomplete_input_manyToMany($a,$settings)
    {
        //$settings=array('store_in'=>VAR',source'=>URL,'form_id'=>'search','field_q'=>'q','field_t'=>'t');
        
        /*
            
            Setting deault vars
            
        */
        if(empty($settings['store_in']))$settings['store_in']=__FUNCTION__;
            
        if(empty($settings['field_q']))$settings['field_q']="q";
        if(empty($settings['field_t']))$settings['field_t']="t";
        if(empty($settings['field_id_record']))$settings['field_id_record']="id_record";
            
        if(empty($settings['form_id']))$settings['form_id']="search";
          
        /*
            
            Required vars
            
        */
        if(empty($settings['source'])){echo'<p>ERROR: var <b>settings[source]</b> is required<br /><b>'.__FUNCTION__.'</b> in <b>'.__FILE__.'</b> at <b>'.__LINE__."</b>\n".'</p>';}
            
            
        //<link href="'.rootWWW.'js/jquery-ui-1.8.21/css/smoothness/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css"/>    
        $JS='
        <script src="'.rootWWW.'js/jquery-ui-1.8.21/js/jquery-1.7.2.min.js"></script>
        <script src="'.rootWWW.'js/jquery-ui-1.8.21/js/jquery-ui-1.8.21.custom.min.js"></script>
        ';
            
        $html=$this->__getHTML(__FUNCTION__);
            
        $settings=array_merge($settings,array('JS'=>$JS,'html'=>$html));
            
            
            
        $a=$this->__init($a,$settings);
        //pr($a);
        return $a; 
    }
        
        
        
        
        
        
        
    function __init($a,$settings)
    {
            
        /*
            $a['a'] corrispond to "global" array a
        */
        //if(empty($a)){echo'<p>ERROR: array <b>a</b> is required<br /><b>'.__FUNCTION__.'</b> in <b>'.__FILE__.'</b> at <b>'.__LINE__."</b>\n".'</p>';}
            
            
        /*
            
            If place is model or controller ()
            so $a['_MCV_POSITION_']=="M" || =="C"
            
        */
            
        if($a['_MCV_POSITION_']=="M" || $a['_MCV_POSITION_']=="C")
        {
            //Init JS data
            //and ADD to pre-existent data ... 
            $a['JS']=$a['JS'].=$settings['JS'];
        }
            
        /*
            
            Setting the output of html in
            a the var AJAX[store_in]
            1. str_replace all settings for var to init  
        */
                
            $HTML=$settings['html'];
                
            foreach($settings AS $k=>$v)
            {
                ### <%=VAR%>
                $HTML=str_replace("<%=".$k."%>",$v,$HTML);
                
            }
            
        $a['AJAX'][$settings['store_in']]=$HTML;
            
            
        return $a;
    }
    function __getHTML($f)
    {
        
        $fileDOC=rootDOC."_views/_ajax_elements/".$f.".php";
        $fileCore=rootCore."_views/_ajax_elements/".$f.".php";
        /*
            
            Setting the file
            if is in DOC use it
            else take it from core.
            
        */
        $file=$fileCore;
        if(file_exists($fileDOC))
        {
            $file=$fileDOC; 
        }
            
            
        $file=file_get_contents($file);
        return $file;
    }
}