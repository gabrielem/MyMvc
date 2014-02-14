<?php
function _delete($tab,$id,$where=null)
{
global $lang;
$mysql_access = connect();


	if(!empty($where))
	{
$delete=" DELETE FROM $tab ".$where.""; 
	}
	else
	{
$delete=" DELETE FROM $tab WHERE id='".$id."'"; 
	}

$res=mysql_query($delete,$mysql_access); 
//echo $delete;
	if($res)
	{
	$risposta=true;
	}
	else
	{
	$risposta=false;
//echo "<p style='color:red;'>".$delete."<br/>".mysql_error()."</p>";
	}

return $risposta;
}
?>
