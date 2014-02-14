<?php
$TAB1=$TAB_prodotti;

$where=" WHERE slug='' ";
$limit=" LIMIT 0,1";

$exists=tableFiledExists($TAB1,"slug");
if(!$exists)
{
    $SQL="ALTER TABLE  ".$TAB1." ADD  slug VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL";
    dbAction::_shell_query(array('SQL'=>$SQL));
    sleep(1);
    
    //SCHEMA UPDATE
    //$result=updSchema();
    sleep(1);
_CORE::redirect(array('location'=>rootWWW."a/url/_allinea_slug_libri/"));
}

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