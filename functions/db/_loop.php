<?php
function _loop($LOOP_TAB, $LOOP_WHERE=null, $LOOP_ORDERBY=null, $tab2=null, $echo=null){

	if(!empty($echo)) pr($LOOP_TAB);

global $TAB_slug;

$LOOP_CAMPI=campiTab($LOOP_TAB);
//pr($LOOP_CAMPI);
	//$LOOP_ORDERBY DEFAULT
	if(empty($LOOP_ORDERBY) && in_array("posizione", $LOOP_CAMPI))
	{
	$LOOP_ORDERBY=" ORDER BY posizione ";
	}

		
	
if(!$LOOP_CAMPI){return false;}

$mysql_access = connect();
if($LOOP_TAB!="") {


mysql_query("SET character_set_client=utf8", $mysql_access);
mysql_query("SET character_set_connection=utf8", $mysql_access);
mysql_query('set names utf8', $mysql_access);

$sel="SELECT * FROM ".$LOOP_TAB." ".$LOOP_WHERE." ".$LOOP_ORDERBY;
	if(!empty($echo)) echo $sel;

$res=mysql_query($sel,$mysql_access);
	if(!$res && DEBUG){echo '<p style="color:red;">'.mysql_error().'<br/><tt>'.$sel.'</tt></p>';}
	if(mysql_num_rows($res)) {
$loop=array();	
$c=0;
$conto="1";

		while($row=mysql_fetch_array($res)){
		$NOME_ARRAY_CAMPI="CAMPI_".$TAB_RECORD;
		$arrayCAMPI=$LOOP_CAMPI;

			for($i=0;$i<count($arrayCAMPI);$i++){
				$virgola=',';
			$loop[$c][$arrayCAMPI[$i]]=$row[$arrayCAMPI[$i]];
			}
			if(!empty($tab2)){
				//un ArrAy delle tab relazionats
				//!empty($loop[$c]['id_'.$tab2])				
				
				for($i=0;$i<count($tab2);$i++)
				{
				$loop[$c]['id_'.$tab2[$i].'_dati']=_record($tab2[$i],'id',$loop[$c]['id_'.$tab2[$i]]);
				}
				//alla fine aggiungo anche l'array delle tab relazionate
				$loop[$c]['TAB_2_LIST']=$tab2;
			}


			//ed aggiungo anche un eventuale slug se c'è
			$slug=_record($TAB_slug,'id2',$loop[$c]['id']," AND tab='".$LOOP_TAB."' ");
			if($slug)
			{
			//
			$loop[$c]['SLUG']=array();
				$SLUG_CAMPI=campiTab($TAB_slug);
			
				for($i_Slug=0;$i_Slug<count($SLUG_CAMPI);$i_Slug++)
				{
					$campoTabSlug=$SLUG_CAMPI[$i_Slug];
				$loop[$c]['SLUG'][$campoTabSlug]=$slug[$campoTabSlug];
				}

			}
			
			//aggiungo un campo per la classe delle righe alterne
			
			if($conto=="1")
			{
			$tr_class="uno";
			}
			else
			{
			$tr_class="due";
			$conto="0";
			}
			$conto++;
			$loop[$c]['tr_class']=$tr_class;





		$c++;
		}
	return $loop;
	} else {
	
	return false;
	}

}

}

?>
