<?php
$TAB1=$TAB_libri_sot;

$loop=dbAction::_loop(array('tab'=>$TAB1,'where'=>$where,'orderby'=>"ORDER BY id",'limit'=>$limit,'echo'=>'0'));

for($i=0;$i<count($loop);$i++){
    $id=$loop[$i]['id'];
    $DEMO=false;
    $make_slug_from="titolo";
    
    $data['titolo']=$loop[$i]['titolo'];
    
    $aa=array('make_slug_from'=>$make_slug_from,'tab'=>$TAB1,'id'=>$id,'data'=>$data,'only_this_fileds'=>array('titolo','slug'),'where'=>'','echo'=>'1','DEMO'=>$DEMO);
    dbAction::_update($aa);
    
}

?>