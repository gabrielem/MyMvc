<?php
$generaForm=new generaForm();
echo _formStart('new','new','new');
?>
<input type="hidden" value="GO_2_UPDATE" name="redirect">

<div>data (int(11))<br/>
<?php $settings=array('name'=>data,'value'=>time(),'type'=>$value['Type']);
echo $htmlHelper->_inputData($settings,$value); ?>
</div>



Ordine: <br />
<?php 
//$array_valori_nome=array("data_consegna","qta","costo_totale","id_crm_ditte");
//echo $htmlHelper->filtroRelazione($tab,$tab2[0],'molti-a-uno','id_crm_ordini',$r['id_crm_ordini'],false,false,false); 

$aOrdini=_loop($TAB_crm_ordini," WHERE consegna_ultimata='0' ");

for($i=0;$i<count($aOrdini);$i++)
{
	$nomeDitta=_record($TAB_crm_ditte,'id',$aOrdini[$i]['id_crm_ditte']);

$aCampi_ORDINI[]=$aOrdini[$i]['id'];
$aCampi_name_ORDINI[]="
".$aOrdini[$i]['id']."]
data: ".date("d-m-Y",$aOrdini[$i]['data'])." - qta: ".$aOrdini[$i]['qta']." - totale: ".$aOrdini[$i]['costo_totale']."
 - ditta: ".$nomeDitta['nome']."
";
}

echo select($aCampi_ORDINI,"id_crm_ordini",$value_selected,$aCampi_name_ORDINI)

?>
<input type="submit" value="invia">
</form>
