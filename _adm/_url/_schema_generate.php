<?php
//function _schema(){

//include(rootDOC."_config/main.php");

//include("../config_r.php");
//
$result=updSchema();
if($result)
{
echo $lang['aggiornamentoSchemaRiuscito'];
}else{
echo $lang['aggiornamentoSchemaNonRiuscito'];
}
?>
