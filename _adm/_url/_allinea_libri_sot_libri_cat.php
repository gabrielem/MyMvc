Con questo script si crea popola la tab libri_libri_sot
<br /><br />_allinea_libri_libri_sot.php


<?php
//echo '<h1>SCRIPT STOPPATO!</h1> Riattivare tramite script';


/**/

$THIS_DO_ECHO=false;
$THIS_DO_ECHO=true;

$TAB1=$TAB_libri_cat;
$TAB2=$TAB_libri_sot;

$ID_TAB1="id_".$TAB1;
$ID_TAB2="id_".$TAB2;

//$limit=" LIMIT 5980,5000";
$limit=" LIMIT 0,1000";
$where="WHERE 1=1"; 
$loop=dbAction::_loop(array('tab'=>$TAB1,'where'=>$where,'orderby'=>"ORDER BY id",'limit'=>$limit,'echo'=>'0'));

for($i=0;$i<count($loop);$i++)
{
    //
$where2="WHERE id_cat='".$loop[$i][id]."' OR id_cat1='".$loop[$i][id]."' OR id_cat2='".$loop[$i][id]."'";

$loop2=dbAction::_loop(array('tab'=>$TAB2,'where'=>$where2,'orderby'=>$orderby,'limit'=>$limit,'echo'=>'0'));
    if($THIS_DO_ECHO)echo '<p style="color:red;">id: '.$loop[$i]['id'].' | nome: '.$loop[$i]['nome'].' | nome2: '.$loop[$i]['nome2'].' | cog: '.$loop[$i]['cognome'].' WHERE:'.$where2.'</p>';
    //pr($loop2);
    for($i2=0;$i2<count($loop2);$i2++)
    {
        if($THIS_DO_ECHO)echo '<p>id: '.$loop2[$i2]['id'].' '.$loop2[$i2]['titolo'].'</p>';
        $exists=_record($TAB2."_".$TAB1,$ID_TAB1,$loop[$i]['id']," AND ".$ID_TAB2."='".$loop2[$i2]['id']."'","0");
        if(!$exists)
        {
            //_insert($TAB2."_".$TAB1,array($ID_TAB2=>$loop2[$i2]['id'],$ID_TAB1=>$loop[$i]['id']));
        }
            
    }
}

//pr($loop);

/*
*/

?>