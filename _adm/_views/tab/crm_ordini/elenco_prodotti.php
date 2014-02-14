<?php 
$MEM_elenco_prodotti='
<h2>Elenco dei prodotti</h2>

<div style="margin-top:5px;">
	<span>
	<img src="'.$rootBase.'_adm/_template/_grafica/add.png" onclick="showContent(this);" width="21" align="left" style="cursor:pointer;" />
	Aggiungi un Prodotto</span>
	<div style="display:none;margin:5px;margin-top:15px;background:#ffffcc;">';

	$creaFormNew = new generaForm(); 

	$MEM_elenco_prodotti.=$creaFormNew->_formTag('new','nuovoItem2','','1');
	$MEM_elenco_prodotti.='
	<input type="hidden" name="redirect" value="'.$selettoreDati['selettore']."/".$selettoreDati['id_s']."/upd/".$id_record.'">
	<input type="hidden" name="tab" value="'.$TAB_crm_prodotti.'">
	<input type="hidden" name="id_crm_ditte" value="'.$r['id_crm_ditte'].'">

	nome:<br />
	<input type="text" value="" name="nome" style="width:100%;" />  
	<br />
	codice:<br />
	<input type="text" value="" name="codice" style="width:100%;" />  
	<br />
	descrizione:<br />
	<input type="text" value="" name="descrizione" style="width:100%;" />  
	<br />
	
	Tipo di prodotto:<br />
';

//echo $MEM_elenco_prodotti;






//$tipiPro=_loop($TAB_crm_prodotti_tipi,"","ORDER BY nome");
$tipiPro=$datiComportamento['loop_tipi_prodotto'];



for($i=0;$i<count($tipiPro);$i++){$aCampi_TipiPro[]=$tipiPro[$i]["id"];$aCampi_name_TipiPro[]=$tipiPro[$i]['nome'];}
$name_Sel_TipiPro="id_crm_prodotti_tipi";$id_TipiPro=$name_Sel_TipiPro;

 $MEM_elenco_prodotti.= $htmlHelper->_select($aCampi_TipiPro,$name_Sel_TipiPro,$value_selected_TipiPro,$aCampi_name_TipiPro,$id_TipiPro,' style="width:100%;" '); 
	 $MEM_elenco_prodotti.='<br />'; 


	 $MEM_elenco_prodotti.='Categoria di prodotto:<br />'; 

//$catPro=_loop($TAB_crm_prodotti_cat,"","ORDER BY nome");
$catPro=$datiComportamento['loop_cat_prodotto'];

for($i=0;$i<count($catPro);$i++){$aCampi_CatPro[]=$catPro[$i]["id"];$aCampi_name_CatPro[]=$catPro[$i]['nome'];}
$name_Sel_CatPro="id_crm_prodotti_cat";$id_CatPro=$name_Sel_CatPro;

 
$MEM_elenco_prodotti.= 
$htmlHelper->_select($aCampi_CatPro,$name_Sel_CatPro,$value_selected_CatPro,$aCampi_name_CatPro,$id_CatPro,' style="width:100%;" '); 

	 $MEM_elenco_prodotti.='<br />'; 

 $MEM_elenco_prodotti.= _formSubmit("Salva",' style="width:100%;" '); 
 $MEM_elenco_prodotti.='</form>'; 



 $MEM_elenco_prodotti.='

	</div>
</div>
';

$creaFormNew = new generaForm(); 
$MEM_elenco_prodotti.=$creaFormNew->_formTag('new','nuovoItem','','1');

$MEM_elenco_prodotti.='
<input type="hidden" name="tab" value="'.$tab3[2].'">
<input type="hidden" name="id_crm_ordini" value="'.$id_record.'">
<input type="hidden" name="id_crm_valute" value="'.$r['id_crm_valute'].'">
<input type="hidden" name="redirect" value="'.$selettoreDati['selettore']."/".$selettoreDati['id_s']."/upd/".$id_record.'">

<br/>';



//ARRAY PRODOTTI CAMPIONE [$TAB_crm_prodotti]
//$prodottiCampione=_loop($TAB_crm_prodotti," WHERE id_crm_ditte='".$r['id_crm_ditte']."' ");
$prodottiCampione=$datiComportamento['loop_prodotti_campione'];

//pr($prodottiCampione);

	for($i=0;$i<count($prodottiCampione);$i++)
	{ 
	$aCampi_SelPro[]=$prodottiCampione[$i]['id'];
	$aCampi_name_SelPro[]=$prodottiCampione[$i]['nome'];
	}
	$name_SelPro="id_crm_prodotti";
	$id_SelPro="id_crm_prodotti";
	$value_selected_SelPro="";

$nomeValuta=_record($TAB_crm_valute,"id",$r['id_crm_valute']); 	




 
$MEM_elenco_prodotti.='
<div style="float:left;width:225px;margin:0px;background:#ffffcc;height:60px;">
Seleziona il prodotto:<br />
';

$MEM_elenco_prodotti.=
$htmlHelper->_select($aCampi_SelPro,$name_SelPro,$value_selected_SelPro,$aCampi_name_SelPro,$id_SelPro,' style="width:220px;" ');

$MEM_elenco_prodotti.='
</div>

<div style="float:left;width:40px;margin:0px;background:#ffffcc;height:60px;">
QTA:<br />
<input type="text" value="1" name="qta" style="width:35px;"></div>

<div style="float:left;width:110px;margin:0px;background:#ffffcc;height:60px;">
[<i>'.$nomeValuta['nome'].'</i>]<br />
<input type="text" value="0.00" name="costo" size="3">  
</div>
<div style="float:left;width:40px;margin:0px;background:#ffffcc;height:60px;">
&nbsp;<br />'._formSubmit("+",' style="width:35px;" ').'</div>
<div style="clear:both;"></div>
</form>
';





 //$r2=_loop($tab3[2]," WHERE id_crm_ordini='".$id_record."' ");
 $r2=$datiComportamento['loop_prodotti'];

 if($r2){ 


$MEM_elenco_prodotti.='
<table width="99%" border="0" cellpadding="3" cellspacing="1" align="center">

<tr style="background-color:#afafaf;color:#ffffff;">
<td align="center"><img src="'.$rootBase.'_adm/_template/_grafica/valute/money.png" border="0" alt="" width="21" /></td>
<td>nome</td>
<td>WS</td>
<td>tot</td>


<td>RT</td>
<td><nobr>-iva</nobr></td>

<td></td>
<td></td>
</tr>
';


	 for($i=0;$i<count($r2);$i++){ 

//recupero dati prodotto
//$datiPro=_record($TAB_crm_prodotti,"id",$r2[$i]['id_crm_prodotti']); 	
$datiPro=$r2[$i]['datiPro'];

//ARRAY valuta
$valuta=$r2[$i]['valuta'];
$costoWO_scrivi='&euro;'.$r2[$i]['costoWO'].'<br />'.'<span style="font-size:8px;">'.$r2[$i]['costo'].'</span>';
$costoWO_SPESE_scrivi='<br />
<nobr style="color:#606060;">&euro;'.$r2[$i]['costoConSpese'].'</nobr><br />'.'<span style="font-size:8px;">'.$r2[$i]['costoConSpeseInValuta'].'</span>';


$costoRT='
<form action="http://www.namung.com/admin/tab/crm_ordini_prodotti/upd/'.$r2[$i]['id'].'" method="post" enctype="multipart/form-data" name="upd" id="upd">
<input type="hidden" name="upd" value="1">
<input type="hidden" value="tab/crm_ordini/upd/'.$r['id'].'/" name="redirect">

<input type="hidden" name="qta" value="'.$r2[$i]['qta'].'">
<input type="hidden" name="costo" value="'.$r2[$i]['costo'].'">
<input type="hidden" name="id_crm_valute" value="'.$r2[$i]['id_crm_valute'].'">
<input type="hidden" name="id_crm_prodotti" value="'.$r2[$i]['id_crm_prodotti'].'">
<input type="hidden" name="id_crm_ordini" value="'.$r2[$i]['id_crm_ordini'].'">
<nobr>
<input type="text" name="costort" value="'.$r2[$i]['costort'].'" style="padding:0px;font-size:10px;width:60px;" />
<input type="submit" value="#" style="padding:0px;font-size:10px;color:blue;" />
</nobr>
<br />

<tt style="font-size:10px;color:#000000;padding-left:1px;">
<nobr>'.$r2[$i]['costort_consigliato'].' &euro;</nobr><br />
<nobr>'.$r2[$i]['costort_in_valuta'].'<img src="'.$rootBase.'_adm/_template/_grafica/valute/'.$nomeValuta['id'].'.png" border="0" alt="" height="9" title="'.$nomeValuta['nome'].'" />
</nobr>
</tt>


</form>
';












$MEM_elenco_prodotti.='
<tr style="background-color:#ffffcc;color:#909090;font-size:11px;">

<td align="center" valign="top"><img src="'.$rootBase.'_adm/_template/_grafica/valute/'.$nomeValuta['id'].'.png" border="0" alt="" width="21" title="'.$nomeValuta['nome'].'" /> </td>

<td valign="top" style="font-size:10px;"><b style="font-size:10px;background-color:#ffffff;">'.$datiPro['codice'].'</b><br />
'.$datiPro['nome'].'</td>

<td valign="top">'.$costoWO_scrivi.''.$costoWO_SPESE_scrivi.' </td>
';

##########
### SOMMA
##############################
$MEM_elenco_prodotti.='
<td valign="top" style="text-align:right;">
<nobr><tt style="font-size:10px;">

<b style="font-size:15px;color:#303030">'.$r2[$i]['qta'].'</b> X<br />
'.$r2[$i]['costo'].' =<br />
<nobr>'.$r2[$i]['costoTotRecord'].' &nbsp;</nobr><br />
<nobr style="color:#303030">&euro;.'.$r2[$i]['costort_per_qta'].' &nbsp;</nobr>


</tt></nobr>
</td>
';


$MEM_elenco_prodotti.='
<td valign="top">'.$costoRT.' </td>
<td valign="top">'.$r2[$i]['costort_noiva'].' </td>



<td valign="top">
<!-- a href="'.urlMenuAdmin(array('selettore'=>'tab','id_s'=>$tab3[2])).'upd/'.$r['id'].'/mod/'.$r2[$i]['id'].'" -->
<!-- 
<a href="'.urlMenuAdmin(array('selettore'=>'tab','id_s'=>$tab3[2])).'upd/'.$r2[$i]['id'].'">
'.$lang['linkModificaRecord_SHORT'].'</a> -->
<input type="button" value="'.$lang['linkModificaRecord_SHORT'].'" style="height:21px;padding:0px;color:blue;width:35px;font-size:10px;"
onclick="javascript:location=\''.urlMenuAdmin(array('selettore'=>'tab','id_s'=>$tab3[2])).'upd/'.$r2[$i]['id'].'\'">

</td>	


<td valign="top">
<!-- 
<a href="'.urlMenuAdmin(array('selettore'=>'tab','id_s'=>$tab3[2])).'del/'.$r2[$i]['id'].'">
'.$lang['linkCancellaRecord_SHORT'].'</a> -->
<input type="button" value="'.$lang['linkCancellaRecord_SHORT'].'" style="height:21px;padding:0px;color:red;width:35px;font-size:10px;"
onclick="javascript:location=\''.urlMenuAdmin(array('selettore'=>'tab','id_s'=>$tab3[2])).'del/'.$r2[$i]['id'].'\'">

</td>
	
</tr>
';



 


	 } 


$MEM_elenco_prodotti.='
</table>';


 } else { 
 $MEM_elenco_prodotti.="nessun prodotto inserito"; 
 } 


$MEM_elenco_prodotti.='
<br /><br />
&nbsp; QTA Totale: '.$datiComportamento['r']['qta']."<br />"; 

//$MEM_elenco_prodotti.='&nbsp; Totale: '.$datiComportamento['totale_ordine']." (in valuta)<br />";
$MEM_elenco_prodotti.='&nbsp; Totale: '.$datiComportamento['costo_totale_euro']." euro<br />";


//$MEM_elenco_prodotti.='&nbsp; Totale: '.$datiComportamento['totale_ordine_con_spese']." (in valuta)<br />";
$MEM_elenco_prodotti.='&nbsp; Totale: '.$datiComportamento['costo_totale_euro_con_spese']." euro<br />";




?>
