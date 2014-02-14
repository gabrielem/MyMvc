<?php
/*
session_start();ob_start();$DO_EXEC=true;
$PathDOC="/var/www/libraio/_new/";
require($PathDOC."_config/main.php");include(rootDOC."tables.php");require(rootCore."init.php");
*/

//true
//FALSE

$DO_IT=true;if(!$DO_IT){echo'<p><b>DISATTIVATO</b></p>';}

$ID_INSIEMI='1';
$THIS_DO_ECHO=true;
//$THIS_DO_ECHO=FALSE;

$TAB1=$TAB_autori;
$TAB2=$TAB_prodotti;

$ID_TAB1="id_".$TAB1;
$ID_TAB2="id_".$TAB2;

//$limit=" LIMIT 5980,5000";
$limit1=" LIMIT 0,5000";
$limit2=" LIMIT 0,21000";
/*
$limit1=" LIMIT 0,1";
$limit2=" LIMIT 0,5";
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
$where2="WHERE id_insiemi='".$ID_INSIEMI."' AND idAutore='".$ID_TAB1_VALUE."'";
//$where2="WHERE sot='".$ID_TAB1_VALUE."' OR sot1='".$ID_TAB1_VALUE."' OR sot2='".$ID_TAB1_VALUE."' ";
//if($THIS_DO_ECHO)pr("WHERE2:".$where2);
//if($THIS_DO_ECHO)pr("<b>SOT</b>: ".$loop[$i]['titolo']);

$loop2=dbAction::_loop(array('tab'=>$TAB2,'where'=>$where2,'orderby'=>$orderby,'limit'=>$limit2,'echo'=>'0'));
    //if($THIS_DO_ECHO)echo '<p style="color:red;">id: '.$ID_TAB1_VALUE.' | SOT: '.$loop[$i]['titolo'].' | WHERE:'.$where2.'</p>';
    //pr($loop2);
    
    
    $MEM_I="";$V="";
    for($i2=0;$i2<count($loop2);$i2++)
    {
        
        $ID_TAB2_VALUE=$loop2[$i2]['id'];
        
        if($THIS_DO_ECHO)echo '<p>id: '.$ID_TAB2_VALUE.' '.$loop2[$i2]['titolo'].'</p>';
        $exists=_record($TAB2."_".$TAB1,$ID_TAB1,$loop[$i]['id']," AND ".$ID_TAB2."='".$loop2[$i2]['id']."'","1");
        if(!$exists && !empty($ID_TAB2_VALUE))
        {
            //if($THIS_DO_ECHO)pr(' - - - INSERT INTO '.$TAB2."_".$TAB1.' array('.$ID_TAB2.'=>'.$ID_TAB2_VALUE.','.$ID_TAB1.'=>'.$loop[$i]['id'].')');
            
            $MEM_I.=$V.'('.$loop2[$i2]['id'].','.$loop[$i]['id'].')';
            $V=",";
            
            //_insert($TAB2."_".$TAB1,array($ID_TAB2=>$ID_TAB2_VALUE,$ID_TAB1=>$loop[$i]['id']));
        }
            
            
            
    }
    $MEM_I="INSERT INTO ".$TAB2."_".$TAB1." (".$ID_TAB2.",".$ID_TAB1.") VALUES ".$MEM_I;
    //pr($MEM_I);
    
    dbAction::_exec(array('sql'=>$MEM_I));
    //sleep();
    
}
}
?>