<?php
include(rootCore."_controllers/initController.php");
include(rootDOC."_controllers/_all.php");
    
    $controller=rootDOC."_controllers/".$a['route']['model'].".php";
    $controllerCass="cAll";
    if(!empty($a['route']['model']))
    {
        if(file_exists($controller))
        {
        $controllerCass="c_".$a['route']['model'];
        include($controller);
        }
        else
        {
        if(!IS_HOME) $a['ALERT'].="<p>Missing Controller: ".$controller.'</p>';
        }
    }

//echo $controllerCass;
$a['CONTROLLER_CLASS']=$controllerCass;
/*
This i will do in loadSubControllers.php if(empty($a['SUB_MODEL']))
$a=$controllerCass::_beforeInit($a);
$a=$controllerCass::init($a);
$a=$controllerCass::_afterInit($a);
*/

### Recovering "getAllowed" Values
if(!isset($a['getAllowed'])){$a['getAllowed']=_CORE::getVarClass($controllerCass,"getAllowed");} //pr($v['getAllowed']); 

//Include Components of the Controller
$a['includeCoreComponents']=_CORE::getVarClass($controllerCass,"includeCoreComponents");
foreach($a['includeCoreComponents'] as $file){include(rootCore."components/".$file);}
$a['includeComponents']=_CORE::getVarClass($controllerCass,"includeComponents");
foreach($a['includeComponents'] as $file){include(rootDOC."components/".$file);}
?>