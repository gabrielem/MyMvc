_allinea_corsi_per_MwCalendar
<br /><br />

<?php
$TAB1=$TAB_danza_corsi;
$id_corsi_set='1';
$where=" ";
$limit="LIMIT 0,10000"; 
$loop=dbAction::_loop(array('tab'=>$TAB1,'where'=>$where,'orderby'=>"",'limit'=>$limit,'echo'=>'0'));
if($loop)
{
    for($i=0;$i<count($loop);$i++){
        echo'<p>
        <b>'.$loop[$i]['id_utenti'].'</b>
        <i>'.$loop[$i]['more_teacher'].'</i>
        </p>';
        
        
        $A_more_teacher=explode(",",$loop[$i]['more_teacher']);
        $loop[$i]['id_corsi_set']=$id_corsi_set;
        
        $loop[$i]['id_utenti']=array_merge(array($loop[$i]['id_utenti']),$A_more_teacher);
        
        
        $set=array('tab'=>$TAB_corsi,'tab2'=>$TAB_corsi_utenti,'data'=>$loop[$i],'echo'=>'1'); 
        //dbAction::_insert($set);
        
    }
}
?>