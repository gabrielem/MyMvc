<?php
//class comportamento_crm_ordini extends valiDate
class comportamento_sezioni 
{

	function _elabora($a)
	{
	global $TAB_crm_prodotti_tipi;
	global $TAB_crm_ordini_spese;
	global $TAB_crm_prodotti_cat;
	global $TAB_crm_prodotti;
	global $TAB_crm_valute;

	//echo '<p>azione: '.$dati['azione'].'</p>';
	$id_record=$_GET[$a['azione']];
	
	$tab=$a['tab'];
	$tab2=$a['tab2'];
	$tab3=$a['tab3'];
	
	//pr($a);
		
		### isolo le sotto sezioni
		for($i=0;$i<count($a['DATI']);$i++)
		{
			
			if($a['DATI'][$i]['id_sezioni']!="0")
			{
			$sottosezioni_array[]=$a['DATI'][$i];
			}
		}

//echo "<p>sottosezioni_array</p>";
//pr($sottosezioni_array);

		### salvo le sotto sezioni
		for($i=0;$i<count($a['DATI']);$i++)
		{
			//il record ha sotto-sezioni?
			$ha_sottosezioni=$this->ha_sottosezioni($a['DATI'][$i],$sottosezioni_array);
			if($ha_sottosezioni)
			{
			$a['DATI'][$i]['LOOP_SOTTOSEZIONI']=$ha_sottosezioni;
			}
			
			if(is_array($a['DATI'][$i]['LOOP_SOTTOSEZIONI']))
			{
				for($i2=0;$i2<count($a['DATI'][$i]['LOOP_SOTTOSEZIONI']);$i2++)
				{
					$ha_sottosezioni2=$this->ha_sottosezioni($a['DATI'][$i]['LOOP_SOTTOSEZIONI'][$i2],$sottosezioni_array);
					if($ha_sottosezioni2)
					{
					$a['DATI'][$i]['LOOP_SOTTOSEZIONI'][$i2]['LOOP_3LIV']=$ha_sottosezioni2;
						//$arrat_3liv
						for($i3=0;$i3<count($ha_sottosezioni2);$i3++)
						{
							$arrat_3liv[$ha_sottosezioni2[$i3]['id']]=$ha_sottosezioni2[$i3];
						}
					}				
					
						
				}
			}
			
		}
		//Così adesso ogni voce delle sezioni ha il suo elenco di sotto-sezioni, se ne ha...


		//creo Array LOOP_SEZIONI senza i 3liv, perchè oltre il 3liv non si può andare!
		for($i=0;$i<count($a['DATI']);$i++)
		{
			//if($this->is_3liv($a['DATI'][$i],$arrat_3liv))
			$id=$a['DATI'][$i]['id'];
			if(is_array($arrat_3liv[$id]))
			{
			$a['DATI'][$i]['3liv']=true;
			}
			else
			{
			$a['LOOP_SEZIONI'][]=$a['DATI'][$i];
			}
		}


//pr($arrat_3liv);

//echo "<p>DATI</p>";
//pr($a['DATI']);

		$count=0;
		for($i=0;$i<count($a['DATI']);$i++)
		{
			
			if($a['DATI'][$i]['id_sezioni']=="0")
			{
			$a['DATI_NEW'][$count]=$a['DATI'][$i];
			$count++;
			}
		}
		
		
		
		
		$a['sovrascrivi_dati']=$a['DATI_NEW'];
		$a['arrar_3liv']=$arrat_3liv;






		
		//pr($a['LOOP_SEZIONI']);
		//pr($a);
	return $a;
	}




//SPECIAL FUNCTION
	function ha_sottosezioni($a,$sottosezioni_array)
	{
		for($i=0;$i<count($sottosezioni_array);$i++)
		{
			if($a['id']==$sottosezioni_array[$i]['id_sezioni'])
			{
			$find[]=$sottosezioni_array[$i];
			}
		}
		
		if(is_array($find))
		{
		return $find;
		}
		else
		{
		return false;
		}
	}


	function is_3liv($a,$array_3_liv)
	{
		//pr($array_3_liv);
		for($i=0;$i<count($array_3_liv);$i++)
		{
			if($a['id']==$array_3_liv[$i]['id'])
			{
			$find[]=$array_3_liv[$i];
			}
		}
		
		if(is_array($find))
		{
		//return $find;
		return true;
		}
		else
		{
		return false;
		}
	}




	
}
?>
