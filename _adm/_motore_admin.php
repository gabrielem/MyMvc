<?php 
//ADMIN


#############
### previusly in motore.php
if(isset($_POST)){$getPost = new getPost(); }



//echo '<p>contenuto_pagina'.$contenuto_pagina.'</p>';

$DIR_template='_template/';

$urlCorrente="http://".$_SERVER['HTTP_HOST'];
$urlCorrente.="".$_SERVER['REQUEST_URI'];
//echo $urlCorrente;
#######################################################
#######################################################
#######################################################





$fileLanguageAdmin=$rootAssoluta.$dirADMIN."_lang/".$language.".php";
include($fileLanguageAdmin);

include($rootAssoluta.$dirADMIN."config_r.php");
include($rootAssoluta.$dirADMIN."_scripts/funzioni.php");


$directoryViewsStatus=$dirADMIN."_views/";





$htmlHelper=new htmlHelper();

include($rootAssoluta.$dirADMIN."_scripts/admin_check.php");



	if(!isset($_SESSION['admin'])){
	### presenta login
	$contenuto_pagina=$dirADMIN."_views/login.php";
	} else {

	//echo "<p><b>selettore: ".$_GET['selettore']."</b></p>";
	//echo "<p><b>id_s: ".$_GET['id_s']."</b></p>";
        if($_GET['selettore']=="tab")
        {
        $tab=$_GET['id_s'];
        }
        
        
		if(isset($_GET['selettore']))
		{
		//a questo punto il valore $_GET['selettore']: tipo determina il tipo di "azione richeista"
		//$_GET['id'] è il valore che detrmina il "record"
		//e $_GET['p'] è il numero di pagina se c'è...
		

		// PER PRIMA COSA CREO UN ARRAY DEL SELETTORE E DEL ID SELETTORE IN USO

		$selettoreDati=array('selettore'=>$_GET['selettore'],'id_s'=>$_GET['id_s']);
		$selettoreUrl=$rootBaseAdmin.$selettoreDati['selettore']."/".$selettoreDati['id_s']."/";


		### quindi includo il tipo di selettore per le azioni ADMIN
			$fileSelettore=$rootAssoluta.$dirADMIN."_scripts/selettori/".$_GET['selettore']."/_root.php";

			//echo "<p>fileSelettore: ".$fileSelettore."</p>";
			
			if(file_exists($fileSelettore)){
                            
			include($fileSelettore);
			} else {
			$_GET['status']="404";
			$notFound='1';
			}
		}
		else 
		{
		$contenuto_pagina=$dirADMIN."_index.php";
		}
	} 	




##########################################################################################
##########################################################################################
##########################################################################################
##########################################################################################
##########################################################################################
##########################################################################################
##########################################################################################
##########################################################################################
##########################################################################################
###
### da qui in poi, PRIMA STAVA IN motore.php ...
### 
##########################################################################################
##########################################################################################

$title = $_GET['TITLE']; 


### ALL HEADER AT: http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
if(empty($_GET['status'])){$_GET['status']="200";}
$statusHeader=_CORE::HTTPStatus($_GET['status']);
$statusHeaderTitle=str_replace("HTTP/1.1 ","",$statusHeader);


if($_GET['status']!="200")
{

	if($_GET['status']=="203")
	{
	//$contenuto_pagina=$directoryViewsStatus.$_GET['status'].".php";
	$scriviMETATAG='<link rel="canonical" href="'.$URL_NOW.'" />'."\n";
	}
	else
	{
	send_err_msg_to_admin("STATUS: ".$_GET['status'],"ERORR:".$_GET['status']);
		if(!empty($pageNotFoundView))
		{
		$contenuto_pagina=$pageNotFoundView;
		}
		else
		{
		$contenuto_pagina=$directoryViewsStatus.$_GET['status'].".php";
		}
	$title = $statusHeaderTitle; 
	//$locazione="NotFound"; 
	$scriviMETATAG.="<META NAME=\"ROBOTS\" CONTENT=\"NOINDEX, NOFOLLOW\">";
	}
header($statusHeader);


}















###
### info di DEBUGGING 
###
if($DEBUG_ON && $SHOW_TOP_INFO){
for($i=0;$i<count($tab2);$i++){$tabA2.=$virgola2.$tab2[$i];$virgola2=", ";}if(empty($tabA2))$tabA2="<i>--- empty ---</i>";
for($i=0;$i<count($tab3);$i++){$tabA3.=$virgola3.$tab3[$i];$virgola3=", ";}if(empty($tabA3))$tabA3="<i>--- empty ---</i>";

for($i=0;$i<count($tab2rev);$i++){$tabA2rev.=$virgola2.$tab2rev[$i];$virgola2rev=", ";}if(empty($tabA2rev))$tabA2rev="<i>--- empty ---</i>";

echo '<pre style="background:#ffffcc;padding:5px;border:1px #efefef solid;">';
echo "STATUS:		<b>".$statusHeader."</b><br>";
echo "URL:		".$_GET['url']."<br>";

echo "VIEW:      	".$views."<br>";
echo "TAB:      	".$tab." - ".$_GET['TABELLA']."<br>";
echo "TAB2: 		".$tabA2."<br>";
echo "TAB3: 		".$tabA3."<br>";
echo "TAB2rev:	".$tabA2rev."<br>";
echo "MODELLO: 	".$_GET['MODELLO']."<br>";
echo "COMP: 	".$_GET['COMPORTAMENTO']."<br>";
echo "ITEM_PAGE: 	".$ITEM_PAGE."<br>";
echo "URL_NOW:	".$URL_NOW."<br>";

echo '</pre>';
}
### info di DEBUGGING - start



//sistemo variabili

if(!empty($dati['_SET_VIEW_'])) {$contenuto_pagina=$dati['_SET_VIEW_'];}
$contenuto_pagina=$rootAssoluta.$contenuto_pagina;


//$aTemplate=_template($dati);
//pr($aTemplate);

$aTemplate=array(
rootDOC.$dirADMIN.'_template/head.php',
rootDOC.$dirADMIN.'_template/body.php',
rootDOC.$dirADMIN.'_template/down.php'
);

include($aTemplate[0]);
include($aTemplate[1]);
include($aTemplate[2]);


//for($i=0;$i<count($aTemplate);$i++)
//{
//include($aTemplate[$i]);
//}


?>
