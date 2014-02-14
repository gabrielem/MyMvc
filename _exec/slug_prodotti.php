<?php
/*
session_start();ob_start();
$PathDOC="/var/www/libraio/_new/";$DO_EXEC=true;
require($PathDOC."_config/main.php");include(rootDOC."tables.php");require(rootCore."init.php");
*/

//FALSE
//true


$DO_IT=FALSE;if(!$DO_IT){echo'<p><b>DISATTIVATO</b></p>';}

$TAB1=$TAB_prodotti;
$where=" WHERE slug='' ";
$limit=" LIMIT 0,5000";
$limit=" LIMIT 0,5000";
//$limit=" LIMIT 0,5";
$DEMO=FALSE;
$LOOP_ECHO='0';
$UPD_ECHO="0";
$ALLOW_UPD=FALSE;

$make_slug_from="titolo";
    
    
    
//$exists=tableFiledExists($TAB1,"slug"); if(!$exists) pr('SLUG MUST BE');


//$loop=dbAction::_loop(array('tab'=>$TAB1,'where'=>$where,'orderby'=>"ORDER BY id",'limit'=>$limit,'echo'=>$LOOP_ECHO));

$loop=_loop($TAB1, $where, "ORDER BY id ".$limit, "", "");


if($DO_IT)
{
    $count=0;
for($i=0;$i<count($loop);$i++)
{
    $id=$loop[$i]['id'];
    
    $data['titolo']=trim($loop[$i]['titolo']);
    
    $data['slug']=slug($data['titolo']);
    
    
    //$aa=array('make_slug_from'=>$make_slug_from,'tab'=>$TAB1,'id'=>$id,'data'=>$data,'only_this_fileds'=>array('titolo','slug'),'where'=>'','echo'=>$UPD_ECHO,'DEMO'=>$DEMO);
    //dbAction::_update($aa);
    $Q="UPDATE ".$TAB1." SET titolo='".pulisciDati($data['titolo'])."', slug='".$data['slug']."' WHERE id='".$id."'";
    dbAction::_exec(array('sql'=>$Q));
    
    if($count=="500")
    {
    $count="0";
    sleep(1);
    }
    $count++;
}
    //pr($Q);
    

}