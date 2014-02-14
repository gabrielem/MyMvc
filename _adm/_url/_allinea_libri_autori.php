Con questo script si crea popola la tab libri_autori
<br /><br />


<?php
//echo '<h1>SCRIPT STOPPATO!</h1> Riattivare tramite script';


/**/

$TAB1=$TAB_autori;
$TAB2=$TAB_libri;

$ID_TAB1="id_".$TAB1;
$ID_TAB2="id_".$TAB2;

//$limit=" LIMIT 5980,5000";
$limit=" LIMIT 0,100";
$where="WHERE 1=1 ";
$loop=dbAction::_loop(array('tab'=>$TAB1,'where'=>$where,'orderby'=>"ORDER BY id",'limit'=>$limit,'echo'=>'0'));

for($i=0;$i<count($loop);$i++)
{
    //
$where2="WHERE idAutore='".$loop[$i][id]."'";

$loop2=dbAction::_loop(array('tab'=>$TAB2,'where'=>$where2,'orderby'=>$orderby,'limit'=>$limit,'echo'=>'0'));
    echo '<p style="color:red;">id: '.$loop[$i]['id'].' | nome: '.$loop[$i]['nome'].' | nome2: '.$loop[$i]['nome2'].' | cog: '.$loop[$i]['cognome'].' WHERE:'.$where2.'</p>';
    //pr($loop2);
    for($i2=0;$i2<count($loop2);$i2++)
    {
        echo '<p>id: '.$loop2[$i2]['id'].' '.$loop2[$i2]['titolo'].'</p>';
        $exists=_record($TAB2."_".$TAB1,$ID_TAB1,$loop[$i]['id']," AND ".$ID_TAB2."='".$loop2[$i2]['id']."'","1");
        if(!$exists)
        {
            //_insert($TAB2."_".$TAB1,array('id_libri'=>$loop2[$i2]['id'],'id_autori'=>$loop[$i]['id']));
        }
            
    }
}

//pr($loop);

/*
*/

?>