<?php
class IMG
{
	

	function checkDir($tab)
	{
	global $rootBaseImg;
	global $rootAssolutaImg;
	$dirAssoluta=$rootAssolutaImg.$tab."/";
	$dir=$rootBaseImg.$tab."/";
		if(is_dir($dirAssoluta))
		{
		return $dir;
		}
		return false;
	}



	function _img($img)
	{
	global $rootBaseImg;
	global $rootAssolutaImg;

		$est="";$tipiEst=array('jpg','gif','png');
		for($i=0;$i<count($tipiEst);$i++)
		{
		$imgToC=$rootAssolutaImg.$img.".".$tipiEst[$i];
		//echo "<p>".$imgToC."</p>";
			if(file_exists($imgToC)){$est=$tipiEst[$i];}
		}

		if($est!=""){
		$dati=array();	
		$dati['url']=$rootBaseImg.$img.".".$est;
		$dati['est']=$est;
			//calcolo la dimensione dell'immagine
			$size = getimagesize($dati['url']);
		$dati['width']=$size[0];
		$dati['height']=$size[1];
		
		return $dati;
		} else {
		return false;
		}
	}



	function delAllSet($t,$slug,$estenzione)
	{
	global $SET_IMG;
	global $rootBaseImg;
	global $rootAssolutaImg;
		for($i=0;$i<count($SET_IMG);$i++)
		{
		$imgToDelete=$rootAssolutaImg.$t."/".$slug.$SET_IMG[$i].".".$estenzione;
		//echo '<p>'.$imgToDelete.'</p>';
		@unlink($imgToDelete); 
		}
	return true;
	}


	function riduciAllSet($t,$slug,$estenzione,$qualita)
	{
	global $SET_IMG;
	global $rootBaseImg;
	global $rootAssolutaImg;
	include($rootAssolutaImg.$t."/.dati");
	$img=$rootAssolutaImg.$t."/".$slug.$SET_IMG[0].".".$estenzione;
		for($i=1;$i<count($SET_IMG);$i++)
		{

		$nome_W="w".$SET_IMG[$i]; 
		$nome_H="h".$SET_IMG[$i]; 
		$w=$$nome_W;
		$h=$$nome_H;

		$save=$rootAssolutaImg.$t."/".$slug.$SET_IMG[$i].".".$estenzione;
		//$this->riduciImg($save,$img,$w,$h,$qualita);
		$this->_riduciImg($img,$save,$w,$h,$qualita,"0");
		
		}
	}








	function _riduciImg($imgSorgente, $imgDestinazione, $larghezza=0, $altezza=0, $qualita=0, $output="png", $debug=0) { 



//Name you want to save your file as
//$save = 'img/2.jpg'; 
$save = $imgDestinazione; 


	if($debug=="1") { echo "<p><b style=color:red;>img to save: $save</b></p>"; } 

//$file = 'img/1.jpg'; 
$file = $imgSorgente; 

	if($debug=="1") { echo "<p><b style=color:red;>image source: $file</b></p>"; } 

$size = 0.45;
//header('Content-type: image/jpeg');
list($width, $height) = getimagesize($file) ;

	if($debug=="1") { echo "<p>larghezza: $larghezza - altezza: $altezza</p>"; } 


#############################################################
#############################################################
#############################################################
##
## P U O'  N E C E S S I T A R E  C A M B I A M E N T I
##
//INDIPENDENTEMENTE DAi valoRI resetto 
if($width>$height){$altezza=0;}
elseif($width<$height){$larghezza=0;}
#############################################################
#############################################################





#############################################################
### DETERMINO DIMENZIONI
###
###	$modwidth;
###	$modheight;
###
###

	if($larghezza!="" AND $altezza!="") { 
	if($debug=="1") { echo "<p>caso 1</p>"; } 
	$modwidth=$larghezza; 
	$modheight=$altezza; 
	} else if($larghezza!="0" AND ($altezza=="" || $altezza=="0")) { 
	if($debug=="1") { echo "<p>caso 2</p>"; } 
	
		//calcolo il rapporto in base alla dimensione
		$rapporto = $width/$height; 
		//echo "<p>rapporto: $rapporto</p>"; 

        // con number format formatto il rapporto
        $rapporto_format = number_format($rapporto, 1, '.', ' ');
        $altezza = number_format($larghezza/$rapporto_format,0);

	$modwidth=$larghezza; 
	$modheight=$altezza; 

	} else if(($larghezza=="" OR $larghezza=="0")AND $altezza!="0") { 
	if($debug=="1") { echo "<p>caso 3</p>"; } 
		//calcolo il rapporto in base alla dimensione
		$rapporto = $height/$width; 
		//echo "<p>rapporto: $rapporto</p>"; 

        // con number format formatto il rapporto
        $rapporto_format = number_format($rapporto, 1, '.', ' ');
        $larghezza = number_format($altezza/$rapporto_format,0);

	$modwidth=$larghezza; 
	$modheight=$altezza; 

	} else { 
	if($debug=="1") { echo "<p>caso 4</p>"; } 
	$msg="errore"; 
	
	}
##########################################################################



//$modwidth = $width * $size; 
//$modheight = $height * $size; 

if($debug=="1") { echo "<p>modwidth: $modwidth, modheight: $modheight</p>"; } 

$tn = imagecreatetruecolor($modwidth, $modheight) ;
$image = @imagecreatefromJPEG($file) OR
$image = @imagecreatefromPNG($file) OR
$image = @imagecreatefromGIF($file) OR
$image =false;
	if(!$image) {
	echo '<p>ERROR: image is not JPEG, PNG, or GIF</p>';
	return false;
	}

imagealphablending($tn, false);
imagesavealpha($tn,true);
$transparent = imagecolorallocatealpha($tn, 255, 255, 255, 127);
imagefilledrectangle($tn, 0, 0, $modwidth, $modheight, $transparent);

imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 

// Here we are saving the .jpg, you can make this gif or png if you want 
//the file name is set above, and the quality is set to 100% 
	if($qualita=="" || $qualita=="0") { $qualita="100"; } 

	if($output=="jpg")
	{
		$methodCreationImage="imageJPEG";
	}
	elseif($output=="bmp")
	{
		$methodCreationImage="imageWBMP";
	}
	else
	{
		$methodCreationImage="imagePNG";
	}
	
	
	//if($methodCreationImage($tn, $save, $qualita)) {
	if($methodCreationImage($tn, $save)) {

return true;
	
	
	} else { return false; } 

	$msg="ok";
	return $msg; 
	} 














	function uploadJpg($tab,$nome_uri,$nomeCampoUpload=null)
	{

global $SET_IMG;
global  $_FILES;
global $rootAssolutaImg;

if(empty($nomeCampoUpload))$nomeCampoUpload="img";
$nCU=$nomeCampoUpload;


$fileTemp=$_FILES[$nCU]["tmp_name"];
	$estConPunto=strrchr( $_FILES[$nCU]['name'], '.');
	$estConPunto=strtolower($estConPunto);
	if($estConPunto==".jpeg")$estConPunto=".jpg";
$fileNew=$rootAssolutaImg . $tab . "/" .$nome_uri .$SET_IMG[0].$estConPunto ;

if($fileTemp!=""){
//CANCELLA IMG per cambio, in modo da intercettare il cambio di estenzione
	if(
	/*
	$_FILES[$nCU]["type"]=="image/gif" 
	or $_FILES[$nCU]["type"]=="image/x-png" 
	or $_FILES[$nCU]["type"]=="image/pjpeg" 
	*/
	   $_FILES[$nCU]["type"]=="image/pjpeg" 
	or $_FILES[$nCU]["type"]=="image/jpeg") 

	{
		//controllo dimensione interno al controllo TYPE
		$size = getimagesize($_FILES[$nCU]['tmp_name']);

		//if ($size[0] <= $max_w_mini and $size[1] <= $max_h_mini)
		//{
			//controllo invio del file
			if (move_uploaded_file($fileTemp, $fileNew)) {
			//echo "file inviato";
			return true;
			}
			else
			{
			$err="Immagine non inviata";
			return false;
			}
		//}
		//else
		//{$err="Immagine troppo grande: larghezza=".$size[0].", altezza=".$size[1]."";return false;}
	}
	else
	{
	$err="Formato immagine non valido";
	return false;
	}
}
//echo $err;

	}













	function renameAllSet($t,$slug,$slug_save)
	{
	global $SET_IMG;
	global $rootBaseImg;
	global $rootAssolutaImg;
	global $dirImg;

	

		if(!empty($dirImg) && $slug_save!=$slug) 
		{
		$path_IMG_ASSOLUTA=$rootAssolutaImg.$t."/";
		
		$datiImg=$this->_img($t."/".$slug_save.$SET_IMG[0]);

	 		for($i=0;$i<count($SET_IMG);$i++)
			{
			$oldNameIMG=$path_IMG_ASSOLUTA.$slug_save.$SET_IMG[$i].".".$datiImg['est'];
			$newNameIMG=$path_IMG_ASSOLUTA.$slug.$SET_IMG[$i].".".$datiImg['est'];

		
				if(file_exists($oldNameIMG)){
			//_save $SET_IMG[0] 
			@rename($oldNameIMG,$newNameIMG);
				}
			}			
		
		}
	}

}
?>
