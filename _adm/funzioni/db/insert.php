<?php
function _insert($tab,$dati,$getlastID=null,$sql=null)
{
global $lang;

$campi=campiTab($tab,1);
$mysql_access = connect();

//echo "".$tab."";

//$risposta=array();

//pr($dati);exit;


	//$CAMPI="(";

if(empty($sql))
{
	foreach($campi as $k=>$v){
		if(strtolower($v['Field'])!='id' && strtolower($v['Extra'])!='auto_increment'){
			//echo " a - ".$v['Field'].'<br />';
			$CAMPI_ALL.=$separatore1b."".$v['Field'].""; 
			$separatore1b=",";

			if(isset($dati[$v['Field']]))
			{
			$CAMPI.=$separatore1."".$v['Field'].""; 
			$separatore1=",";
			
			$VALUES.=$separatore2."'".pulisciDati($dati[$v['Field']])."'"; 
			$separatore2=",";
			}
			
			
		}
	}
}

	//$CAMPI.=")";

//echo $VALUES;
//pr($dati);
//pr($campi);

	//$VALUES="(";

if(empty($VALUES) && empty($sql)){

############ !!! IMPORTANTE !!! 
/*
## se vuoto allora sto passando l'array numerico 
## solo in ordine con tutti i cami
*/
	foreach($dati as $k=>$v){
		$VALUES.=$separatore2."'".pulisciDati($v)."'"; 
		$separatore2=",";
	}
	//$VALUES.=")";

//INOLTRE RECUPERO ANCHE I CAMPI CHE IN QUESTO CASO SONO VUOTI
$CAMPI=$CAMPI_ALL;


}



mysql_query("SET character_set_client=utf8", $mysql_access);
mysql_query("SET character_set_connection=utf8", $mysql_access);

	if(!empty($sql))
	{
	//sto passando una query già pronta non devo manipolarla
	$insert=$sql; 		
	}
	else
	{
	$insert=" INSERT INTO $tab (".$CAMPI.") VALUES (".$VALUES.")"; 
	}
if(DEBUG_ON)
{
echo '<p style="font-size:10px;">@@@ '.$insert.'</p>';
}

$res=mysql_query($insert,$mysql_access); 
### recupero ultimo ID
$query = "SELECT LAST_INSERT_ID()";
$result = mysql_query($query,$mysql_access);
 if ($result) {
 $nrows = mysql_num_rows($result);
 $row = mysql_fetch_row($result);
 $lastID = $row[0];
 }
 else
 {
	echo mysql_error();
 }



	if($res)
	{
	$risposta=true;
	//$risposta['msg']=$lang['MSG_record_inserito'];
	}
	else
	{
	$risposta=false;
if(DEBUG_ON)
{
echo "<p style='color:red;'><b>WARNING</b>:".$insert." - ".mysql_error()."</p>";
}

	//$risposta['msg']=$lang['MSG_record_non_inserito'];
	}






	if(!empty($getlastID))
	{
	$risposta=$lastID;
	}



return $risposta;
}
?>
