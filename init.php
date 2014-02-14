<?php
header('Content-type: text/html;charset=utf-8');
//ini_set("memory_limit","200M");


include(rootCore."tables.php");
include(rootDOC."tables.php");

### Set Var
define("rootCoreFunction",$rootCore."functions/");
define("rootCoreFunctionDb",$rootCore."functions/db/");
define("rootCoreModels",$rootCore."_models/");
define("rootCoreControllesrs",$rootCore."_controllesrs/");

$DB_RELTIONS_TYPE=array("one-to-many","many-to-one","many-to-many","one-to-one");
$fileRELAZIONI_DB=rootDOC."_config/dbRelations.php"; 
include($fileRELAZIONI_DB);

### Load Congfig Files
include(rootDOC."_config/auth.php");
include(rootDOC."_config/routes.php");
include(rootDOC."_config/template.php");


### Load All Function DB & others
include(rootCore."loadFunctions.php");

### Load congif model ALL
include(rootDOC."_config/_models/_all.php");


### Load url&routes function (urlAnalysis, Models ecc)
/*
- Define Costant IS_HOME 
*/

$a=_CORE::urlAnalysis($_GET['url']);

/*
_MCV_POSITION_ Give a position in the MCV process,
means if the process is in Model, COntroller or Views.
*/
$a['_MCV_POSITION_']="M";


###
### SUPERADMIN
###

include(rootCore."___requirements.php");


// var $ALLOW_EXEC normaly is in /_config/main.php
if($ALLOW_EXEC){$a['ALERT']='<b style="color:red;">IMPORTANT!</b> DISABLED $ALLOW_EXEC FOR SECUIRITY REASON file: <b>'.__FILE__.'</b> on line: <b>'.__LINE__.'</b>';}
//if($DO_EXEC && $ALLOW_EXEC)
if($a['firstPath']=="_exec" && $ALLOW_EXEC)
{
    ini_set('max_execution_time', 15000); //300 seconds = 5 minutes 
    
    //Incllude include(".all_functions.php");
    include(rootCore."_exec/.all_functions.php");
    
    $EXEC_F=rootCore."_exec/".$a['secondPath'];
    if(file_exists($EXEC_F) && !empty($a['secondPath']))
    {
        pr($a['secondPath']);
        //echo'EXISTS';
        include($EXEC_F);
    }
}
elseif($a['SUPERADMIN']) // SET on urlAnalysis();
{
$pathArray=$a['_pathArray_'];
include(rootCore."_adm/index.php");
}
else
{
    ###
    ### ROOUTING... 
    ###
    /*
    - loadModels.php Load Models: CORE, DOC & {ModelName} include COMPONENTS{CORE & DOC}
    - loadControllers.php Load Controllers: CORE, DOC & {ControllersName} include COMPONENTS{CORE & DOC}
    (f)pathValidate() Analize $_GET['url'] & compareit on $getAllowed Array();
    
    DEFINING SubModels & SubControllers 
    ---------------------------------------------------------------------------------------------------
    ### SubModels & SubControllers are defined from a $a['SUB_MODEL'] var in the getAllowed ARRAY    
    - loadSubModels.php Initialize the Model class, Normal or SubClass if Exists
    - loadSubControllers.php Initialize the Model class, Normal or SubClass if Exists
    
    - loadAction.php Set the right $a['ACTION']; If error trow an $a['ALERT'];
    */
        
    include(rootCore."loadModels.php");
    include(rootCore."loadControllers.php");    
    $a=ROUTING::pathValidate($a);
    ### Recovering $_GET & $_POST data 
    $a=_CORE::Set_GET_DATA($a);
    $a=_CORE::Set_POST_DATA($a);
        
        
    ### checkLogin.php -> Check For Login //pr($a);
    /*
    - Look if loogin is required
    - Set a metodh for check login for any tipe of user
    - Set a logout function
    */ include(rootCore."checkLogin_INIT.php");     
        
        
        
    include(rootCore."loadSubModels.php");
    //NOW _MCV_POSITION_ is C=> Controller ! we are in the controller section ! 
    $a['_MCV_POSITION_']="C"; 
        
    include(rootCore."loadSubControllersAndBehaviors.php");
        
    include(rootCore."loadAction.php");
    ###
        
        
if(!empty($a['_LANG_FILE_']))
{
    include($a['_LANG_FILE_']);
}


    //NOW _MCV_POSITION_ is V=> View ! we are in the view section ! 
    $a['_MCV_POSITION_']="V"; 
        
    ### viewCheck() -> check the view
    /*
    Check if the View exists
    - if not, include a 404view.php
    - and register Missing View at $a['VIEW_MISSING']
    */ $a=_CORE::viewCheck($a);
        
        
    ### statusView() -> get statusView
    /*
    Insert a "STATUS" View
    !!! now is set only for 404.php view
        
    So if STATUS is 404 this function insert a 404.php view
    Other case do nothing...
    */ $a=_CORE::statusView($a);
        
        
        
    /*
        Here check if
        there is a request of AUTH
        and if so, put 401 view
    */
    include(rootCore."checkLogin.php");  
        
        
        
    //LOAD THE HEADER from status number 
    _CORE::HTTPStatus($a['STATUS']);
    $a=_CORE::HTTPStatus_TITLE($a);
    
    
    ### templateSelect()
    /*
    Set different template, from Models & Controllers
    - Auto select different template
    - Set "TEMPLATE_DIR" if $a['TEMPLATE_DIR'] is called
    
    !!! It output $a['TEMPLATE_DIR'];
    */ $a=_CORE::templateSelect($a);
    
    
    ### Show Info && Alert if(DEBUG) at Top of the page
    /*
        Better to move it into template!
        
    $a=_CORE::printAlert($a);
    $a=_CORE::showInfo($a);
    */  
    
    ### LOAD TEMPLATE
    //pr($a);
    
    //pr($_COOKIE);
    //pr($_POST);
    
    if(!$DISABLED_TEMPLATE)include(rootCore."loadTemplate.php");
}
?>
