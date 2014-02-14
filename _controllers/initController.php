<?php
//_controllers/initController.php
class initController
{
var $includeCoreComponents=array();
var $includeComponents=array(); 
var $perPage="3";
var $getAllowed=array(
    'country'=>array('validation'=>'is_only_set','child'=>array(
        '*'=>array('action'=>'getPaese','table'=>'TAB_paesi','field'=>'nome','child'=>array(
                '*'=>array('action'=>'getCasa','table'=>'TAB_case','field'=>'nome','child'=>array(
                        'pag'=>array('validation'=>'is_natural_number'),
                        ),                        
                    ),
                ),    
            ),
        ),    
    ),


'*'=>array(
    'table'=>'TAB_paesi',
    'field'=>'nome',
    'add_where'=>null,
    'login'=>'0',//default
    'login_set'=>'0',//default
            
        ### IS A CHILD 
        'child'=>array(
        '*'=>array(
            'table'=>'TAB_case',
            'field'=>'nome',
            'add_where'=>null,
            'login'=>'0',//default
            'login_set'=>'0',//default
            ),
        ),    
    
    ),

'new'=>array(
    'validation'=>'is_only_set',
    'values_allow'=>null,
    'values_not_allow'=>array('0'),
    'login'=>'0',//default
    'login_set'=>'0',//default
    ),
'upd'=>array(
    'validation'=>'is_natural_number',
    'values_allow'=>null,
    'values_not_allow'=>array('0'),
    ),
'del'=>array(
    'validation'=>'is_natural_number',
    ),


'upd2'=>array(
    'validation'=>'is_natural_number',
    'values_allow'=>null,
    'values_not_allow'=>array('0'),
    ),
'upd3'=>array(
    'validation'=>'is_natural_number',
    'values_allow'=>null,
    'values_not_allow'=>array('0'),
    ),


);



    
    function _beforeInit($a)
    {
        return $a;
    }

    function init($a)
    {
        return $a;
    }
    
    function _afterInit($a)
    {
        if(empty($a['VIEW'])) $a['VIEW']=rootDOC.'_views/'.$a['route']['model'].".php";
        return $a;
    }

    function index($a)
    {
        //do loop of current table (From Model)
        
        $a['CURRENT_MODEL']=New $a['CURRENT_MODEL']();
        $a=$a['CURRENT_MODEL']->_loop($a);
            
        $a['VIEW']=rootDOC.'_views/'.$a['route']['model']."/index.php";
        return $a;
    }
        
        
    function _new($a)
    {
                /*
            Calling the method _insert in CURRENT MODEL
            $settings is an array where add some extra
            Setting, can be empty, and means:
            TAB:$a['USE_TAB']
            ACTION: NEW
            
            It can contain an array with many specifications
            And so one model can insert in many tables
            ex: array(
                    array('action'=>'NEW','tab'=>$a['USE_TAB']),
                    array('action'=>'NEW_TABXXX','tab'=>$TAB_XXX)
                    //etc...
                    ); 
        */
        //Default Settings: 
        //$settings=array(array('action'=>'NEW','tab'=>$a['USE_TAB']));
        $a['CURRENT_MODEL']=New $a['CURRENT_MODEL']();
        $a=$a['CURRENT_MODEL']->_insert($a,$settings); 
        
        $a['VIEW']=rootDOC.'_views/'.$a['route']['model']."/new.php";
        return $a;
        
    } //End f _new()
        
        
        
    function upd($a)
    {
        
        //echo'AAA';
        //do _record of current table (From Model)
        $a['CURRENT_MODEL']=New $a['CURRENT_MODEL']();
        $a=$a['CURRENT_MODEL']->_record($a);
        
        //pr($a);exit;
        
        /*
            Calling the method _update in CURRENT MODEL
            $settings is an array where add some extra
            Setting, can be empty, and means:
            TAB:$a['USE_TAB']
            ACTION: UPD
            
            It can contain an array with many specifications
            And so one model can update many tables
            ex: array(
                    array('action'=>'UPD','tab'=>$a['USE_TAB']),
                    array('action'=>'UPD_TABXXX','tab'=>$TAB_XXX)
                    //etc...
                    ); 
        */
        //Default Settings: 
        //$settings=array(array('action'=>'UPD','tab'=>$a['USE_TAB']));
        $a['CURRENT_MODEL']=New $a['CURRENT_MODEL']();
        $a=$a['CURRENT_MODEL']->_update($a,$settings); 
        
        //pr($a['R'][$a['USE_TAB']]);
        $a['VIEW']=rootDOC.'_views/'.$a['route']['model']."/upd.php";
        
        return $a;
    } //End f upd 
        
        
        
        
    function print_record($a)
    {
        $MODEL=New $a['CURRENT_MODEL']();
        $settings['ID']=$a['GET_DATA']['print'];
        //$settings['echo']='1';
        $a=$MODEL->_record($a,$settings);
        //pr($a);
        $a['VIEW']=rootDOC.'_views/'.$a['route']['model']."/print.php";
            
        return $a;
    }



    function del($a)
    {
        $a['CURRENT_MODEL']=New $a['CURRENT_MODEL']();
        $a=$a['CURRENT_MODEL']->_delete($a);
            
        /*
            View is disabled    
            $a['VIEW']=rootDOC.'_views/'.$a['route']['model']."/del.php";
        */
            
        return $a;
    } //End f del 
        
        
    function rootModel($a)
    {
        return $a;
    }
}
?>