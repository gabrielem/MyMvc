<?php
exit;
$TAB1=$TAB_prodotti;
$where=" WHERE id_categorie='0'";
$limit="LIMIT 0,5000";
$limit="LIMIT 0,9";
$loop=dbAction::_loop(array('tab'=>$TAB1,'where'=>$where,'orderby'=>"",'limit'=>$limit,'echo'=>'0'));
if($loop)
{
    for($i=0;$i<count($loop);$i++){
        $id=$loop[$i]['id'];
        $DEMO=false;
        $make_slug_from="titolo";
        
        $data['titolo']=$loop[$i]['titolo'];
        
        //$aa=array('make_slug_from'=>$make_slug_from,'tab'=>$TAB1,'id'=>$id,'data'=>$data,'only_this_fileds'=>array('titolo','slug'),'where'=>'','echo'=>'1','DEMO'=>$DEMO);
        //echo '<p>'.$loop[$i]['titolo'].' - '.$loop[$i]['sot'].'</p>';
        
        $lS=_loop("prodotti_sottocategorie","WHERE id_prodotti='".$loop[$i]['id']."'");
        //pr($lS);
        if($lS)
        {
            //foreach($lS as $lS_K=>$lS_V){
                //pr($lS_V);
                $rC=_record("sottocategorie_categorie","id_sottocategorie",$lS[0]['id_sottocategorie']);
                //pr($rC);
                //pr($rC['id_categorie']);
            //}
            if($rC)
            {
                $data['id_categorie']=$rC['id_categorie'];
                $aa=array('tab'=>$TAB1,'id'=>$id,'data'=>$data,'only_this_fileds'=>array('id_categorie'),'where'=>'','echo'=>'1','DEMO'=>$DEMO);
                pr('MAKE UPDATE:');
                pr($aa);
                //dbAction::_update($aa); 
            }
        }
        //$rS['id_cat'];
        
        
    }
}
else
{
    echo'no records';
}