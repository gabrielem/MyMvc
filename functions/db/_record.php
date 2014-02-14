<?php
function _record($TAB_RECORD,$ID_RECORD_CAMPO,$ID_RECORD,$ADD_WHERE_RECORD="",$echo=null){
$CAMPI_RECORD=campiTab($TAB_RECORD);
	//if(!empty($echo)) echo $TAB_RECORD;

if(!$CAMPI_RECORD){return false;}
$mysql_access = connect();

mysql_query("SET character_set_client=utf8", $mysql_access);
mysql_query("SET character_set_connection=utf8", $mysql_access);


//Creo il recordSet dei dati e li metto in un arrau $record[]
$selR="SELECT * FROM $TAB_RECORD WHERE ".$ID_RECORD_CAMPO."='".$ID_RECORD."' ".$ADD_WHERE_RECORD;
//echo $selR;
$resR=mysql_query($selR,$mysql_access);
		if(!empty($echo))
		{
		if(!$resR){echo "<p style='color:red;'>".$selR."<br/>".mysql_error()."</p>";}
		else{echo "<p>".$selR."</p>";}
		}
	if(mysql_num_rows($resR)){
$r=array();

	$rowR=mysql_fetch_array($resR);
	$NOME_ARRAY_CAMPI="CAMPI_".$TAB_RECORD;
	//echo $NOME_ARRAY_CAMPI;
	//$arrayCAMPI=$$NOME_ARRAY_CAMPI;
	$arrayCAMPI=$CAMPI_RECORD;
	//echo $arrayCAMPI;
		for($i=0;$i<count($arrayCAMPI);$i++){
		//echo $arrayCAMPI[$i]."=";
		//echo $rowR[$arrayCAMPI[$i]]."<br/>";
		$r[$arrayCAMPI[$i]]=$rowR[$arrayCAMPI[$i]];
		
		}
	
		$r['TAB_NAME']=$TAB_RECORD;
//print_r($r);
return $r;
	} else {
return false;
	}

}
?>
