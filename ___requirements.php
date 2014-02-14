<?php

$aR=array('tab'=>$TAB_routes,'value'=>'1','echo'=>'0','_ERR_NUM_'=>true);
$rC=dbAction::_record($aR);
    if(!is_array($rC) && $rC=="1146")
    {
            
        $DB_DATA=connect(array('bu'=>true));
        $BU_file=rootCore."sql/a_core.sql";
            
        $C="mysql ".$DB_DATA['n']." -h ".$DB_DATA['h']." -u ".$DB_DATA['u']." -p".$DB_DATA['p']." < ".$BU_file."";
        pr($C);
        system($C,$output);
        pr($output);
        
        
        
        
        echo'
        <div align="center" style="text-align:center;">
        <div style="background-color:#ffffcc;border:1px #afafaf solid;width:500px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;padding:9px;margin:0 auto;margin-top:50px;">
           
           DataBase tables required<br />
           now are been created!
           
        </div>
        </div>
        ';
        exit;
    }
