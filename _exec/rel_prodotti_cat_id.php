<?php
$DO_IT=FALSE;if(!$DO_IT){echo'<p><b>DISATTIVATO</b><br />crea dei campi ID_CATEGORIA per i prodotti</p>';}
        
if($DO_IT){
        
        
        
        
$TAB1=$TAB_prodotti;
$where=" WHERE id_categorie='0' OR  id_categorie=''";
$TOT_PER_TIME="3000";
$limit="LIMIT 0,".$TOT_PER_TIME;
        
    $s="SELECT COUNT(*) FROM ".$TAB1." ".$where." ";
    //$count=mysql_query($s,$mysql_access);
    $count=dbAction::_exec(array('return_result'=>true,'sql'=>$s));
    $tot_records="0";
    if($count){
    $tot_records=mysql_fetch_assoc($count);
    $tot_records=$tot_records['COUNT(*)'];
    }
        
    echo'<p><b>tot_records:'.$tot_records.' running: '.$TOT_PER_TIME.' per time</b></p>';    
        
$loop=dbAction::_loop(array('tab'=>$TAB1,'where'=>$where,'orderby'=>"",'limit'=>$limit,'echo'=>'0'));
        
        
if($loop)
{
    for($i=0;$i<count($loop);$i++){
        $id=$loop[$i]['id'];
        $DEMO=false;
        $make_slug_from="titolo";
        
        //$data['titolo']=$loop[$i]['titolo'];
        
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
                $aa=array('tab'=>$TAB1,'id'=>$id,'data'=>$data,'only_this_fileds'=>array('id_categorie'),'where'=>'','echo'=>'0','DEMO'=>$DEMO);
                //pr('MAKE UPDATE:');
                //pr($aa);
                dbAction::_update($aa); 
            }
        }
        //$rS['id_cat'];
        
        
    }
}
else
{
    echo'no records';
}





}//DOIT