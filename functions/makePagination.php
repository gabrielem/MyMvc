<?php
class makePagination
{


	//function _init($pagination_data,$url,$pagSuff=null)
	function _init($pagination_data)
	{
		//pr($pagination_data);
	/*
		This function is called from the loop
		set all the data for paginatoion
	*/
		$DS_first="/";
		$DS="/";
		/*
			This if the pagSuff has ?
		*/
		if(substr($pagination_data['pagSuff'],0,1)=="?")
		{
		$DS_first="=";
		$DS="&";
		}
		
	$query_recover=$pagination_data['query_recover_pagination'];
	$url=$pagination_data['url_pagination'];
	$pagSuff=$pagination_data['pagSuff'];
		
	$settings=$pagination_data;
	$pagSuffDEFAULT="p";
	//pr($pagination_data);
			
			/*
			//$query_recover
			Loop of thr array
			set only if the $_GET isset
			and fill in the $query_recover_write VAR
			
			*/
			//pr("".$query_recover);
			if(!empty($query_recover))
			{
				$query_recover_write=$query_recover;
				if(is_array($query_recover))
				{
				$query_recover_write=array();
				foreach($query_recover as $k=>$v)
				{
					if(isset($_GET[$v]))
					{
					$query_recover_write.=$CONCAT.$v."=".$_GET[$v];
					$CONCAT="&";
					}
				}
				}
				if(!empty($query_recover_write))
				{
				if($DS_first!="=" && substr($query_recover_write,0,1)!="?")$query_recover_write="?".$query_recover_write;
				elseif(substr($query_recover_write,0,1)!="&")$query_recover_write="&".$query_recover_write;
				$settings['query_recover_write']=$query_recover_write;
				}
					
			}
				
			
			
		if(empty($pagSuff)){$pagSuff=$pagSuffDEFAULT;}
			
			
		//echo "AAA".$settings['current_page'];
		if(!isset($settings['prev']) && $settings['current_page']!="1" && $settings['current_page']!="")
		{
			$settings['prev']=$settings['current_page']-1;
		}
		if(!isset($settings['next']) && $settings['current_page']!=$settings['tot_pages'])
		{
			$settings['next']=$settings['current_page']+1;
		}
			
			
			
	$settings['url']=$url;
	$settings['pagSuff']=$pagSuff;
	//pr($query_recover_write);
		if($settings['current_page']=="2")
		{
		$settings['url_prev']=$settings['url'].$query_recover_write;
		}
		else
		{
		$settings['url_prev']=$settings['url'].$settings['pagSuff'].$DS_first.$settings['prev'].$DS.$query_recover_write;
		}
	$settings['url_next']=$settings['url'].$settings['pagSuff'].$DS_first.$settings['next'].$DS.$query_recover_write;
		
	//Set last page url
	$settings['url_last']=$settings['url'].$settings['pagSuff'].$DS_first.$settings['tot_pages'].$DS.$query_recover_write;
		
	//pr($settings);
	//$settings=array_merge($pagination_data,array('url'=>$url,'pagSuff'=>$pagSuff));
	//$settings=array_merge($pagination_data,$settings);
		
		
		$settings['DS_first']=$DS_first;
		$settings['DS']=$DS;
		
	return $settings;
	}


	function Prev($ANCHOR,$settings)
	{ 
	//pr($settings);
		if($settings['prev'])
		{
			if($settings['prev']=="1")
			{
			$url=$settings['url'].$settings['query_recover_write'];
			}
			else
			{
			$url=$settings['url_prev'];
			}
		$html='<a href="'.$url.'" class="prev">'.$ANCHOR.'</a>';
		
		return $html;
		}
	}
	function Next($ANCHOR,$settings)
	{
	//pr($settings);
		if($settings['next'])
		{
			$url=$settings['url_next'];

		$html='<a href="'.$url.'" class="next">'.$ANCHOR.'</a>';

		return $html;
		}
	
	}
	
	function Numbers($settings,$html_output=null) 
	{
		
		$DS_first=$settings['DS_first'];
		$DS=$settings['DS'];
		
	//pr($settings);
	//pr($settings['query_recover_write']);
		for($i=1;$i<=$settings['tot_pages'];$i++){
			if($i=="1")
			{
			$url=$settings['url'].$settings['query_recover_write'];
			}
			else
			{
			$url=$settings['url'].$settings['pagSuff'].$DS_first.$i.$DS.$settings['query_recover_write'];
			}
				$number_to_take=3;
					
				$start_N=$settings['current_page']-$number_to_take;
					$diff=$number_to_take-$start_N;
						if($start_N>1)
						{
						$number_to_take_FOREND=$number_to_take;
						} else {
							$toAdd=($start_N*-1)+1;
						//if($i==1)echo''.$r;
						$number_to_take_FOREND=$number_to_take+$toAdd;
						}
					//echo ;
					//if(())
				$end_N=$settings['current_page']+$number_to_take_FOREND;
					
				//if($i==1)echo'<p>start: '.$start_N.' - end: '.$end_N.' number_to_take:'.$number_to_take.' diff:'.$diff.'</p>';
					
			if($i>=$start_N && $i<=$end_N  )
			{
				if($i==$settings['current_page'])
				{
				$numbers_array[]=array('n'=>$i,'url'=>$url,'class'=>'sel');
				$html.=" ".$i." ";
				}
				else
				{
				$numbers_array[]=array('n'=>$i,'url'=>$url,'class'=>'');
				$html.=" <a href=\"".$url."\">".$i."</a> ";
				}
			}
		}
			
			if($html_output)
			{
				return $html;
			}
			return $numbers_array;
	}

}