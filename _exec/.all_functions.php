<?php
function addTable($t)
{
$SQL="DROP TABLE ".$t;
dbAction::_shell_query(array('SQL'=>$SQL,'echo'=>'1'));sleep(1);
$SQL_FILE=rootDOC."_files/".$t.".sql";
dbAction::_shell_query(array('SQL_FILE'=>$SQL_FILE,'echo'=>'1'));sleep(1);
}


function exec_SqlArray($SQL,$settings=null)
{
    //--skip-triggers --compact --no-create-info
    for($i=0;$i<count($SQL);$i++)
    {
    $SETTINGS=array('SQL'=>$SQL[$i],'echo'=>'1');
        if(is_array($settings))
        {
           $SETTINGS=array_merge($SETTINGS,$settings);
        }
    dbAction::_shell_query($SETTINGS);
    //sleep(1);
    }
}



function importTabFG($settings)
{
    $DATA_ONLY=$settings['DATA_ONLY'];
    $TAB_NEW=$settings['TAB_NEW'];  
    $TAB_OLD=$settings['TAB_OLD'];  
    $DB_CONFIG_FG=$settings['DB_CONFIG_FG'];    
        
        $TABLE=$TAB_OLD;//This is optional
        
    $tF=showFields(array($TABLE),array('DB_CONFIG'=>$DB_CONFIG_FG));
    //pr($tF);exit;
        $Q="SELECT ";
        for($i=0;$i<count($tF[$TABLE]);$i++)
        {
            $campo=$tF[$TABLE][$i]['Field'];
            if(!in_array($campo,$settings['FILEDS_TO_EXCLUDE']))
            {
                if(isset($settings['TO_DO_AS'][$campo]))
                {
                    //$settings['TO_DO_AS'][$campo]
                    $Q.=$V.$TABLE.".".$campo." AS ".$settings['TO_DO_AS'][$campo]."";$V=", ";
                }
                else
                {
                    $Q.=$V.$TABLE.".".$campo;$V=", ";
                }
            }
        }
        $Q.="";
        if($settings['echo']) pr($Q);
        //pr($Q);EXIT;
            
        $SQL_FILE=rootDOC."_files/".time()."_".$TABLE.".sql";
            
    //DUMP
    //'DATA_ONLY'=>true
        
    $SETTINGS=array('SQL_FILE'=>$SQL_FILE,'QUERY'=>$Q,'DB_CONFIG'=>$DB_CONFIG_FG,'DUMP'=>true,'TABLE'=>$TABLE,'echo'=>'1');
    if($DATA_ONLY) {$SETTINGS['DATA_ONLY']=true;}
    //pr($SETTINGS);exit;
    dbAction::_shell_query($SETTINGS);
    //sleep(1);
    
    dbAction::_shell_query(array('SQL_FILE'=>$SQL_FILE,'echo'=>'1'));
    //sleep(1);
    unlink($SQL_FILE);

}