<style>

td {font-size:11px;text-align:center;padding:0px;margin:0px;height:21px;background:#ffffff;padding-bottom:7px;border-bottom:1px solid;}
#main{padding:0px;margin:0px;}
.codice{font-size:8px;}
</style>

<script LANGUAGE="javascript">
function inizio()
{
//document.parentWindow.focus();
//setTimeout("stampa()",1000);
//addEvent(window,'load',stampa());


}

</script>

<script Language="Javascript">
window.onload = stampa();
function stampa() 
{
window.print() ; 
} 
</script>

<?php
//echo $_GET['id'];




//_record($TAB_RECORD,$ID_RECORD_CAMPO,$ID_RECORD,$ADD_WHERE_RECORD="",);
//$r=_record($TAB_crm_consegne,'id',$_GET['id']);
$l=_loop($TAB_crm_consegne_prodotti, " WHERE id_crm_consegne='".$_GET['id']."' ", $LOOP_ORDERBY, $tab2);
//pr($l);

$count='0';
for($i=0;$i<count($l);$i++)
{
$qtaTot=$l[$i]['qta']-$l[$i]['guasti'];

	for($i2=0;$i2<$qtaTot;$i2++)
	{
	$lNew[$count]['id']=$l[$i]['id'];
	$lNew[$count]['id_crm_consegne']=$l[$i]['id_crm_consegne'];
	$lNew[$count]['id_crm_ordini_prodotti']=$l[$i]['id_crm_ordini_prodotti'];
	$lNew[$count]['id_crm_ordini']=$l[$i]['id_crm_ordini'];
	$lNew[$count]['qta']=$l[$i]['qta'];
	$lNew[$count]['guasti']=$l[$i]['guasti'];
	$count++;
	}
}


//pr($lNew);
$l=$lNew;





echo '<table width="595" cellspacing="0" cellpadding="0" border="0" >';


//echo'<tr><td>&nbsp;<br /><span class="codice">&nbsp;</span></td></tr>';



$totTD="7";$c="1";$wTd="14%";
for($i=0;$i<count($l);$i++)
{
//trovo i dati del prodotto
//prima del record dell'ordine per avere id prodotto
$rPro=_record($TAB_crm_ordini_prodotti,'id',$l[$i]['id_crm_ordini_prodotti']);

//poi del prodotto vero e proprio
$rProOrigine=_record($TAB_crm_prodotti,'id',$rPro['id_crm_prodotti']);



//$apri='<td width="'.$wTd.'"><div style="text-align:left;background:#ffffff;border:1px #afafaf solid;font-size:9px;">';
//$chiudi='</div></td>';
$apri='<td width="'.$wTd.'">';
$chiudi='</td>';

	if($c=='1')
	{
	echo '<tr>';
	}
echo $apri.'';
//echo''.$costort.'<br />';

$costort=$rPro['costort'];
//$costort=str_replace(".00","",$rPro['costort']);

echo '&euro; '.$costort.'<br />';
echo '<span class="codice">'.$rProOrigine['codice'].'</span>';

echo ''.$chiudi;
	
	if($totTD==$c)
	{
	echo'</tr>';
	$c="0";
	}
	$c++;

}
	$differenza=$totTD-$c+1;
	for($i2=0;$i2<$differenza;$i2++)
	{
	echo $apri.'&nbsp;'.$i2.$chiudi;
	}


echo '</table>';
	//echo $differenza;
//
?>
