<?php 
$rootAssoluta=rootCore;
$rootBase=rootWWW."";

$dirADMIN="_adm/";

$rootBaseAdmin=$rootBase."a/";

if(!is_array($CONTENT_TAB))$CONTENT_TAB=array();

$language="en";

$DIR_template=$dirADMIN.'_template/';
define("DIR_template",$DIR_template);
$rootCkeditor=$rootBase.$dirADMIN."ckeditor/"; 
$rootCkfinder="/_siti/yantrayoga.org/".$dirADMIN."ckfinder/";
$directory_CKFinder="";


if($pathArray[0]=="a") 
{
$_GET['ADMIN']=""; 
	if(!empty($pathArray[1]))
	{
	//selettore
	$_GET['selettore']=$pathArray[1];
	$_GET['id_s']=$pathArray[2];

		// se non c'è ID_SELETTORE ALLORA MANDO UN 404
		if(empty($_GET['id_s']))
		{
		$_GET['status']='404';
		}
		
		if($pathArray[3]!='')
		{
		$_GET[$pathArray[3]]=$pathArray[4];
			if(empty($pathArray[4])) $_GET[$pathArray[3]]="";
		}
	}
}


include("_motore_admin.php");
?>