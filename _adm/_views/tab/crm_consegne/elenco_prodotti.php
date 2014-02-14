<?php


$r2=$datiComportamento['loop_prodotti'];
//pr($r2);

echo '
<table width="99%" border="0" cellpadding="3" cellspacing="1" align="center">';

echo '<tr style="font-size:11px;">';
echo'
<td></td>
<td></td>
<td>QTA_Ordinata</td>
<td>QTA_Arrivata</td>
<td>QTA_Guasti</td>
';
echo '</tr>';


for($i=0;$i<count($r2);$i++)
{

$datiPro=$r2[$i]['datiPro'];
$datiProConsegna=$r2[$i]['datiProConsegna'];


echo'
<tr style="background:#ffffff;">';

$imgDati=$IMG->_img($TAB_crm_prodotti."/".$datiPro['nome_uri'].$SET_IMG[2]);

if($imgDati) {$img='<img src="'.$imgDati['url'].'" width="50" border="0" alt="" />';}
else {$img='';}


if($datiProConsegna){
echo '
<form action="'.$rootBaseAdmin.'tab/crm_consegne_prodotti/upd/'.$datiProConsegna['id'].'" method="post" enctype="multipart/form-data"';
echo ' name="cp'.$r2[$i]['id'].'_f" id="upd">
<input type="hidden" name="upd" value="1">
<input type="hidden" value="tab/crm_consegne/upd/'.$r['id'].'/" name="redirect">
<input type="hidden" name="tab" value="'.$TAB_crm_consegne_prodotti.'">
<input type="hidden" name="id_crm_consegne" value="'.$r['id'].'">
<input type="hidden" name="id_crm_ordini_prodotti" value="'.$r2[$i]['id'].'">
<input type="hidden" name="id_crm_ordini" value="'.$r['id_crm_ordini'].'">
';
}
else
{
echo '
<form action="'.$rootBaseAdmin.'tab/crm_consegne_prodotti/new/" method="post" enctype="multipart/form-data" ';
echo ' name="cp'.$r2[$i]['id'].'_f" id="new">
<input type="hidden" name="new" value="1">
<input type="hidden" value="tab/crm_consegne/upd/'.$r['id'].'/" name="redirect">
<input type="hidden" name="tab" value="'.$TAB_crm_consegne_prodotti.'">
<input type="hidden" name="id_crm_consegne" value="'.$r['id'].'">
<input type="hidden" name="id_crm_ordini_prodotti" value="'.$r2[$i]['id'].'">
<input type="hidden" name="id_crm_ordini" value="'.$r['id_crm_ordini'].'">


';
}



/*
    [nome] => EDT 40 ML FLEURS ORANGER
    [nome_uri] => edt-40-ml-fleurs-oranger
    [id_crm_prodotti_tipi] => 2
    [id_crm_prodotti_cat] => 14
    [descrizione] => eau de toilette
    [codice] => 0101016.2
    [id_crm_ditte] => 3
    [TAB_NAME] => crm_prodotti


[id] => 10
    [qta] => 24
    [costo] => 70.00
    [id_crm_valute] => 7
    [id_crm_prodotti] => 3
    [id_crm_ordini] => 5
    [costort] => 24.03
    [qta_arrivata_precedente] => 0
    [datiPro] => Array
        (
            [id] => 3
            [nome] => EDT 40 ML FLEURS ORANGER
            [nome_uri] =>
*/

echo '
<td>'.$img.'</td>
<td style="font-size:10px;">
<b>'.$datiPro['codice'].'</b><br />'.$datiPro['nome'].'<br />
valuta: '.$r2[$i]['costo'].' - 
euro: '.$r2[$i]['costort'].' (RT)
</td>
<td align="center" style="font-size:10px;">'.$r2[$i]['qta'].' </td>';

unset($aCampi);$aCampi=array();
for($i2=$r2[$i]['qta_arrivata_precedente'];$i2<=$r2[$i]['qta'];$i2++){$aCampi[]=$i2;}
$styleANDscript=' style="margin:0px;padding:0px;height:21px;font-size:10px;background:#ffffff;border:1px #efefef solid;" ';
$styleANDscript.=' onChange=" document.cp'.$r2[$i]['id'].'_f.submit()" ';
$qtaArrivata=select($aCampi,"qta",$datiProConsegna['qta'],"",$id,$styleANDscript);




unset($aCampi2);$aCampi2=array();
$qtaGuasti="---";
if($datiProConsegna['qta']>"0")
{
for($i2=0;$i2<=$datiProConsegna['qta'];$i2++){$aCampi2[]=$i2;}
$styleANDscript2=' style="margin:0px;padding:0px;height:21px;font-size:10px;background:#ffffff;border:1px #efefef solid;" ';
$styleANDscript2.=' onChange=" document.cp'.$r2[$i]['id'].'_f.submit()" ';
$qtaGuasti=select($aCampi2,"guasti",$datiProConsegna['guasti'],"",$id,$styleANDscript2);
}

echo '<td align="center" style="font-size:10px;">'.$qtaArrivata.'</td>';
echo '<td align="center" style="font-size:10px;">'.$qtaGuasti.'</td>';

echo'
</form>
</tr>';

}
echo'</table>';
?>
