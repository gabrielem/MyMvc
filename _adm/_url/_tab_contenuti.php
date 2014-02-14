<?php
$elencoTAB=elencoTAB();
//pr($_POST);



if($_POST['MOV']=="1")
{
$add=$_POST['t1'];
$del=$_POST['t2'];
if(empty($del)){$del=array();}

pr($del);

//$CONTENT_TAB
$mem ='<?php '."\n";
$mem.='$CONTENT_TAB=array();'."\n";
$ARRAY_TO_ADD=array_merge($CONTENT_TAB,$add);
$ARRAY_TO_ADD=array_unique($ARRAY_TO_ADD);
	for($ii=0;$ii<count($ARRAY_TO_ADD);$ii++)
	{
		if(!in_array($ARRAY_TO_ADD[$ii],$del))
		{
		$mem.='$CONTENT_TAB[]="'.$ARRAY_TO_ADD[$ii].'";'."\n";
		}
	}	
$mem.='?>';

write($fileCONTENT_TAB,$mem);
$htmlHelper->setFlash("msg", $lang['MSG_datiSalvati']);
Header("location: ".$selettoreUrl);
}






echo _formStart("MOV","mov");

echo '<table width="700">';
echo '<tr>';

echo '<td width="50%" valign="top">';
echo $lang['TIT_ElencoTabDisponibili'].'<br/>';
echo '<select multiple name="t1[]" style="width:100%" onDblclick="document.mov.submit();">';
for($i=0;$i<count($elencoTAB);$i++)
{

	if(!in_array($elencoTAB[$i],$PRIVATE_TAB) && !in_array($elencoTAB[$i],$CONTENT_TAB))
	{
	echo '<option value="'.$elencoTAB[$i].'">TAB: '.$elencoTAB[$i].'</option>';
	}
}
echo '</select>';
echo '</td>';

echo '<td>';
echo '<input type="submit" value="&gt;&gt;">';
echo '</td>';


echo '<td width="50%" valign="top">';
echo $lang['TIT_ElencoTabContenuti'].'<br/>';
echo '<select multiple name="t2[]" style="width:100%" onDblclick="document.mov.submit();">';
for($i=0;$i<count($CONTENT_TAB);$i++)
{

	if(!in_array($CONTENT_TAB[$i],$PRIVATE_TAB))
	{
	echo '<option value="'.$CONTENT_TAB[$i].'">TAB: '.$CONTENT_TAB[$i].'</option>';
	}
}
echo '</select>';
echo '</td>';





echo '</tr>';
echo '</table>';

?>
