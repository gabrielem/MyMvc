<?php
function _update($tab,$dati,$id,$SOLO_CAMPO=null,$echo=null)
{
global $lang;
$mysql_access = connect();


//pr($dati);
if(empty($SOLO_CAMPO))
{
$campi=campiTab($tab,1);

	foreach($campi as $k=>$v){
		if(strtolower($v['Field'])!='id' && strtolower($v['Extra'])!='auto_increment'){
			if(isset($dati[$v['Field']]))
			{
			$DATI.=$separatore1."".$v['Field']."='".pulisciDati($dati[$v['Field']])."'"; 
			$separatore1=",";
			}
		}
	}
} 
else
{
$DATI=$SOLO_CAMPO."='".pulisciDati($dati)."'";
}

//pr($DATI);

mysql_query("SET character_set_client=utf8", $mysql_access);
mysql_query("SET character_set_connection=utf8", $mysql_access);

$update=" UPDATE $tab SET ".$DATI." WHERE id='".$id."'"; 
$res=mysql_query($update,$mysql_access); 
	if($echo)
	{
echo "<p>".$update."</p>";
	}

	if($res)
	{
	$risposta=true;
	//$risposta['msg']=$lang['MSG_record_aggiornato'];
	}
	else
	{
	$risposta=false;
		if($echo)
		{
		echo "<p style='color:red;'>".$update.mysql_error()."</p>";
		}



	//$risposta['msg']=$lang['MSG_record_non_aggiornato'];
	}

return $risposta;
}
?>
