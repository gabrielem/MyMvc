_allinea_img_per_MwCalendar

<?php
$TAB1=$TAB_utenti;
$id_corsi_set='1';
$where=" ";
$limit="LIMIT 0,10000"; 
$loop=dbAction::_loop(array('tab'=>$TAB1,'where'=>$where,'orderby'=>"",'limit'=>$limit,'echo'=>'0'));


if($loop)
{
    for($i=0;$i<count($loop);$i++){
        
        $IMG_OLD=rootDOC."_files/utenti/".$loop[$i]['id'];
        $IMG_OLD_save=$IMG_OLD."_save.jpg";
        $IMG_OLD_big=$IMG_OLD."_big.jpg";
        $IMG_OLD_min=$IMG_OLD."_min.jpg";
            
        $IMG_NEW=rootDOC."_files/img/users/";
        $IMG_NEW_save=$IMG_NEW.$loop[$i]['id'].".jpg";
        $IMG_NEW_big=$IMG_NEW."big/".$loop[$i]['id'].".jpg";
        $IMG_NEW_min=$IMG_NEW."min/".$loop[$i]['id'].".jpg";
        
        
        echo'<p>
        <b>'.$loop[$i]['nome'].' '.$loop[$i]['cognome'].'</b>';
        
        if(file_exists($IMG_OLD_save))
        {
            echo'<p><tt>SAVE EXS: '.$IMG_OLD_save.'</tt></p>';
            copy($IMG_OLD_save,$IMG_NEW_save);
            echo'<p><tt>-BIG EXS: '.$IMG_OLD_big.'</tt></p>';
            echo'<p><tt>-MIN EXS: '.$IMG_OLD_min.'</tt></p>';
        }
        
        echo '</p>';
        
        
        
        
    }
}
?>