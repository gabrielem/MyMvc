<?php
//loadSubControllers.php
/*
### SubControllers
##############################################################################################
HOW TO DEFINE: SubControllers are defined from a $a['SUB_MODEL'] var in the getAllowed ARRAY
##############################################################################################

SubControllers are loaded in the directory of the controllers under a directory named with
respective main controller, for exemple, one SubControllers named "test" for ADMIN controller will be
in the directory: rootDOC."_controllers/admin/test.php"

!!! It will not have getAllowed definition

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
    
$controllerCass_TO_INIT=$controllerCass;

/*
$controllerCass=New $controllerCass();
$a=$controllerCass->_beforeInit($a);
$a=$controllerCass->init($a);
$a=$controllerCass->_afterInit($a);
*/

}
else
{
    
    $model=$a['route']['model'];
    //check if SubModel Exists
    $subControllersClass=rootDOC."_controllers/".$model."/".$a['SUB_MODEL'].".php";
    //echo $subControllersClass;
    if(file_exists($subControllersClass))
    {
        include($subControllersClass);
        $subControllerCass="c_".$a['SUB_MODEL'];
        $a['SUB_CONTROLLER_CLASS']=$subControllerCass;
            
        $controllerCass_TO_INIT=$subControllerCass;
        /*
        $subControllerCass=nEW $subControllerCass();
        $a=$subControllerCass->_beforeInit($a);
        $a=$subControllerCass->init($a);
        $a=$subControllerCass->_afterInit($a);
        */
    }
    else
    {
        if(!IS_HOME) $a['ALERT'].="<p>Missing Controller: ".$controller.'</p>';
    }
}



/*
$controllerCLASS=New $controllerCass_TO_INIT();
$a=$controllerCLASS->_beforeInit($a);
$a=$controllerCLASS->init($a);
$a=$controllerCLASS->_afterInit($a);
*/





 
 ###############################
#       Behaviors           ###
###############################
if(!empty($a['BEHAVIOR']))
{
    $behavior=rootDOC."_behaviors/".$a['BEHAVIOR'].".php";
    if(file_exists($behavior))
    {
    include($behavior);
    $behavior_class="behavior_".$a['BEHAVIOR'];
    $a['BEHAVIOR_CLASS']=$behavior_class;
    $controllerCass_TO_INIT=$behavior_class;        
    }
    else
    {
    $a['ALERT']='BEHAVIOR: <b>'.$a['BEHAVIOR'].'</b> not exixts<br />';    
    }
}



//pr($controllerCass_TO_INIT);

$controllerCLASS=New $controllerCass_TO_INIT();
$a=$controllerCLASS->_beforeInit($a);
$a=$controllerCLASS->init($a);
$a=$controllerCLASS->_afterInit($a);

