<?php
/*
session_start();ob_start();$DO_EXEC=true;
$PathDOC="/var/www/libraio/_new/";
require($PathDOC."_config/main.php");include(rootDOC."tables.php");require(rootCore."init.php");
*/

//FALSE
//true


$DO_IT=FALSE;if(!$DO_IT){echo'<p><b>DISATTIVATO</b></p>';}

$ID_INSIEMI='1';
//$THIS_DO_ECHO=true;
$THIS_DO_ECHO=FALSE;

$TAB1=$TAB_editori;
$TAB2=$TAB_prodotti;

$ID_TAB1="id_".$TAB1;
$ID_TAB2="id_".$TAB2;

//$limit=" LIMIT 5980,5000";
$limit1=" LIMIT 0,210000";
$limit2=" LIMIT 0,210000";
/*
$limit1=" LIMIT 0,1";
$limit2=" LIMIT 0,1";
*/

//$where1="WHERE id_insiemi='".$ID_INSIEMI."'";

$loop=dbAction::_loop(array('tab'=>$TAB1,'where'=>$where1,'orderby'=>"ORDER BY id",'limit'=>$limit1,'echo'=>'0'));



if($DO_IT)
{
for($i=0;$i<count($loop);$i++)
{
    $ID_TAB1_VALUE=$loop[$i]['id_oldfg'];
    $ID_INSIEMI=$loop[$i]['id_insiemi'];
    //

//$where2="WHERE id_insiemi='".$ID_INSIEMI."' AND ( sot='".$ID_TAB1_VALUE."' OR sot1='".$ID_TAB1_VALUE."' OR sot2='".$ID_TAB1_VALUE."' ) ";

$where2="WHERE id_insiemi='".$ID_INSIEMI."' AND idEditore='".$ID_TAB1_VALUE."' AND id_editori='0' ";

//if($THIS_DO_ECHO)pr("WHERE2:".$where2);
if($THIS_DO_ECHO)pr("<b>SOT</b>: ".$loop[$i]['nome']);

$loop2=dbAction::_loop(array('tab'=>$TAB2,'where'=>$where2,'orderby'=>$orderby,'limit'=>$limit2,'echo'=>'0'));
    //if($THIS_DO_ECHO)echo '<p style="color:red;">id: '.$ID_TAB1_VALUE.' | SOT: '.$loop[$i]['nome'].' | WHERE:'.$where2.'</p>';
    //pr($loop2);
        
    $setW="WHERE id='0' ";
        
    for($i2=0;$i2<count($loop2);$i2++)
    {
            
        $ID_TAB2_VALUE=$loop2[$i2]['id'];
        //if($THIS_DO_ECHO)echo '<p>id: '.$ID_TAB2_VALUE.' '.$loop2[$i2]['titolo'].'</p>';
            
            //if($loop2[$i2]['id_editori_new']=='0')
            $setW.=" OR id='".$ID_TAB2_VALUE."' ";
            
            
    }
        
    $Q="UPDATE ".$TAB2." SET id_editori='".$loop[$i]['id']."' ".$setW;
    dbAction::_exec(array('sql'=>$Q));
    //echo '<p style="font-size:12px;">'.$Q.'</p>';
    $setW='';
}
}


?>