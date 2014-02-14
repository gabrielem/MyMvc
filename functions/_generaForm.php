<?php
//echo $language;
	function _formStart($azione,$name=null,$id=null,$action=null)
	{		
	global $lang;
		if(empty($name)){$nameForm=$azione;}else{$nameForm=$name;}
		if(empty($id)){$idForm=$azione;}else{$idForm=$id;}
	$form.='<form action="'.$action.'" method="post" enctype="multipart/form-data" name="'.$nameForm.'" id="'.$idForm.'">';
	$form.='<input type="hidden" name="'.$azione.'" value="1">';
	return $form;
	}

	function _formSubmit($value,$addScript=null)
	{
	global $lang;
	$form.='<input type="submit" value="'.$value.'" '.$addScript.'>';
	return $form;
	}

	function _formText($name,$value,$addScript=null)
	{
	global $lang;
	$form.='<input type="text" name="'.$name.'" value="'.$value.'" '.$addScript.'>';
	return $form;
	}

	
	function _formButton($value,$addScript=null)
	{
	global $lang;
	$form.='<input type="button" value="'.$value.'" '.$addScript.'>';
	return $form;
	}


class generaForm {

	function _checkBox($name,$value,$id=null,$checked=null)
	{
		if(!empty($checked)){$checked=" checked";}
		if(empty($id)){$id=$name;}
	$html='<input type="checkbox" name="'.$name.'" id="'.$id.'" value="'.$value.'" '.$checked.'>';
	return $html;
	}





	/*
	function includeTXT($file){
	parent::includeTXT($file); 
	} 
	*/
	function _formTag($azione,$name=null,$id=null,$noecho=null){
		if(!empty($noecho))
		{
		return _formStart($azione,$name,$id);
		}
		else
		{
		echo _formStart($azione,$name,$id);
		}
	}

	function _upd($tab,$id)
	{
	global $lang;
	global $TIPI_CAMPO_TESTO;
	global $TAB_slug;

	$htmlHelper=new htmlHelper;

		$r=_record($tab,'id',$id);
		if(!$r && $id!="NEW")
		{echo '';
		//NESSUN RECORD TROVATO	
		echo 'error: impossible data recovering';
		return false;
		}
		else 
		{
			if($id=="NEW")
			{
			$azioneForm="new";
			}
			else
			{
			$azioneForm="upd";
			}
				
		$campi=campiTab($tab,1);
		$form="";
		$form.=_formStart($azioneForm);
		//pr($campi);
	


global $A_MODELLI;
global $A_COMPORTAMENTI;
global $CONTENT_TAB;
if(in_array($tab,$CONTENT_TAB))
{

### 
### dati SLUG
 if($azioneForm=="upd") 
 {
 $rSlug=_record($TAB_slug,"id2",$id," AND tab='".$tab."' ");
 } 
//pr($rSlug);
### MODELLO 
$form.=select(array_merge(array(''),$A_MODELLI),"MOD_VAR",$rSlug['modello']);

### COMPORTAMENTO
$form.=select(array_merge(array(''),$A_COMPORTAMENTI),"COMP_VAR",$rSlug['comportamento']);
}


	
		//for($i=0;$i<count($campi);$i++)
			foreach($campi as $key => $value)
			{		
				if(strtolower($value['Field'])=='id' || strtolower($value['Extra'])=='auto_increment')
				{
				
				} 
				else if(strtolower($value['Field'])=='id2')
				{
			### verifico la presenza di un ID2 per tab relazionata
				global $tab2;
				global $tipoRelazioneDB;
				$html=$htmlHelper->filtroRelazione($tab,$tab2,$tipoRelazioneDB,'id2',$r[$value['Field']],false,false);
				$form.=$html;
				}
			### campi data
				else if(substr($value['Field'],0,4)=="data")
				{
				//echo '<p>?'.$r[$value['Field']]."</p>";
				$form.='<div>'.$key.' ('.$value['Type'].')<br/>';
					//se $r[$value['Field']] è vuoto metto time()
						if(empty($r[$value['Field']]))
						{
						//echo "<p>type: <b>[".substr($value['Type'],0,3)."]</b></p>";
							if(substr($value['Type'],0,3)=="int")
							{
							$r[$value['Field']]=time();
							}
							else
							{
							$r[$value['Field']]=date("Y-m-d H:i:s");
							}
						}
					//creo array settings
					$settings=array(
					'name'=>$value['Field'],
					'value'=>$r[$value['Field']],
					'type'=>$value['Type']
					);
				//$form.='<p>value='.date("Y-m-d H:i:s",$settings['value']).'</p>';
				$form.=$html=$htmlHelper->_inputData($settings,$value);
				$form.='</div>';
				} 
				else if(in_array($value['Type'],$TIPI_CAMPO_TESTO))
				{
			### tipi di campi testo
				$form.='<div>'.$key.' ('.$value['Type'].')<br/>';
				$form.='<textarea name="'.$value['Field'].'">'.$r[$value['Field']].'</textarea></div>';
				} 
				else 
				{
				$form.='<div>'.$key.' ('.$value['Type'].')<br/>';
				$form.='<input type="text" value="'.$r[$value['Field']].'" name="'.$value['Field'].'"></div>';
				}
			}

			global $dirImg;
			if($azioneForm=="upd" && !empty($dirImg))
			{
				if(!empty($r['nome_uri']))
				{
				$generaForm=new generaForm();
				$form.=$generaForm->_hidden("nome_uri_save",$r['nome_uri']);
				$form.=$generaForm->_hidden("campoImgUpload",'img'); //deve essere uguale al nome del FormImg
				$form.=$generaForm->_img('img',$r);
				}
				else
				{
				$form.="<p class=\"red\">".$lang['MSG_MancaCampoNomeUriPerImg']."</p>";
				}
			
			}


			$form.='<input type="submit" value="'.$lang['tasto_invia_nuovo'].'">';
			$form.='</form>';
			return $form;
		}
	}




	function _new($tab)
	{
	$generaForm=new generaForm();
	$generaForm->_upd($tab,"NEW");
	return $generaForm->_upd($tab,"NEW");
	}








	
	function _img($name=null,$r=null)
	{
		if(empty($name)){$name="img";}
	$html.='<input type="file" name="'.$name.'">';

		if(!empty($r))
		{
		$generaForm=new generaForm();
		$html.=$generaForm->mostraImg($r);
		}
	
	return $html;
	}

	function _hidden($n,$v)
	{
	$html.='<input type="hidden" name="'.$n.'" value="'.$v.'">';
	return $html;
	}


	function mostraImg($r,$classID=null)
	{
	global $dirImg;
	global $SET_IMG;
	$IMG=new IMG();
	$img_name=$r['TAB_NAME']."/".$r['nome_uri'].$SET_IMG[0];
	//echo $img_name;
	$img=$IMG->_img($img_name);
		if($img)
		{
			if(empty($classID))$classID="displayImg";
		//$html.=$img['url'];
		$html.=$this->_hidden("URL_IMG",$img['url']);
		$html.='<div id="'.$classID.'">';
		//$img
		$html.='<img src="'.$img['url'].'" border="0" alt="">';
		$html.='</div>';
		}
	return $html;
	}




	






}
?>
