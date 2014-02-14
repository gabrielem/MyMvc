<?php
include(rootCore."_models/initModel.php");
include(rootDOC."_models/_all.php");

    $modelCass="modAll";
    if(!empty($a['route']['model']))
    {
    $model=rootDOC."_models/".$a['route']['model']."/class.php";
    $modelConfig=rootDOC."_config/_models/".$a['route']['model']."_config.php";        
        
        /*
        $modelConfig;
        
        If is present i will include() the config file for the models
        Has to be inside the rootDOC/_config/_models/ directory
        and has to be named like the models: {modelsName}.php
        */
        if(file_exists($modelConfig))
        {
            include($modelConfig);
        }    
        
        
        /*
        Include Model class if Exists
        */
        if(file_exists($model))
        {
        include($model);
        $modelCass="mod_".$a['route']['model'];
        }
        else
        {
        if(!IS_HOME) $a['ALERT'].="<p>Missing Model: ".$model.'</p>';
         
            if(!IS_HOME)
            {
                $a['STATUS']="404";
                if(DEBUG){
                $a['VIEW']=rootCore."_views/model404.php";
                }
            }
        }
    }

$a['MODEL_CLASS']=$modelCass;
/*
This i will do in loadSubModels.php if(empty($a['SUB_MODEL']))
$a=$modelCass::_beforeInit($a);
$a=$modelCass::init($a);
$a=$modelCass::_afterInit($a);
*/


//Include Components of the models
$a['includeCoreComponents']=_CORE::getVarClass($modelCass,"includeCoreComponents");
foreach($a['includeCoreComponents'] as $file){include(rootCore."components/".$file);}
$a['includeComponents']=_CORE::getVarClass($modelCass,"includeComponents");
foreach($a['includeComponents'] as $file){include(rootDOC."components/".$file);}
?>