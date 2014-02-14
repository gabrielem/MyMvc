<?php
//loadSubModels.php
/*
### SubModels
##############################################################################################
HOW TO DEFINE: SubModels are defined from a $a['SUB_MODEL'] var in the getAllowed ARRAY
##############################################################################################

SubModelsare loaded in the directory of the models 
for exemple, one SubModels named "test" for ADMIN controller will be
in the directory: rootDOC."_models/admin/test.php"

If it not exists generate an $à['alert']

******************************
   BEHAVIOR
******************************

A Behavior is an extention of the model
it is called directly from a controller or form model
by the use of the var $a['BEHAVIOR']

If it not exists generate an $à['alert']

*/
//pr($a);

if(empty($a['SUB_MODEL']))
{
//$a=$modelCass::_beforeInit($a);
//$a=$modelCass::init($a);
//$a=$modelCass::_afterInit($a);

$modelClassToInit=$modelCass;
//Init Current model
$a['CURRENT_MODEL']=$modelCass;

}
else
{
    $model=$a['route']['model'];
    //check if SubModel Exists
    
    $subModelsClass=rootDOC."_models/".$model."/".$a['SUB_MODEL'].".php";
    if(file_exists($subModelsClass))
    {
        include($subModelsClass);
        $subModelCass="mod_".$a['SUB_MODEL'];
        $a['SUB_MODEL_CLASS']=$subModelCass;
        //$a=$subModelCass::_beforeInit($a);
        //$a=$subModelCass::init($a);
        //$a=$subModelCass::_afterInit($a);
        
        $modelClassToInit=$subModelCass;        
       //Init Current model
        $a['CURRENT_MODEL']=$subModelCass;
        
    }else{
    $a['ALERT']='SUB_MODEL: '.$a['SUB_MODEL_CLASS'].' not exixts<br />';
    }
}






$modelClassToInit=New $modelClassToInit();
$a=$modelClassToInit->_beforeInit($a);

// Filter Set: build on $RELATIONS_DB_ARRAY set vars if present
//ONLY IF THERE IS A TABLE!
$a=FILTER_SET::set($a); 

$a=$modelClassToInit->init($a);

/*
    This
    now it will be initialized in the loadAction
    so can have action after loop and other action!
    _update, _insert ecc...
*/
//$a=$modelClassToInit->_afterInit($a);
