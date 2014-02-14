<?php
class ROUTING
{

function pathValidate($a)
{
//echo '<h1 style="color:blue;">SERVE UN TOOL per la creazione di Models, Controllers & Views</h1>';
//echo '<h3><b style="color:red;">NOTA3</b>: Il modello stabilisce la TAB, o LE Tab con un array!<br /><br />';
//echo '<b style="color:red;">NOTA2</b>: meglio sistemare 3 or more cosi: LOOP SOLO NESTED con child intendo proprio come *,*,* ... perche altrimenti si possono ottenere <b style="color:red;">URL DUPLICATE</b> mischiando l ordine dei get...';
//echo '<p><tt><b>!!! ATTENZIONE:</b>: rivedere <b>allow</b> e <b>not allow</b> in tutti i casi qui elencati... <br />Ed anche: $_GET, ACTION e altro... dare una bella riguardata a tutto!<br />()/_core/function/_routing.php - Riga: 55</tt></p>';
    //pr($a['getAllowed']);
    
    
    
foreach($a['getAllowed'] as $k=>$v)
{
    //pr($v);
    $name_of_getAllowed[]=$k;
}
    //pr($name_of_getAllowed);
    
    
    //Check getAllowed
    $PATH=$a['PATH'];
    
    //echo $a['totPath'];
    //pr($a['getAllowed']);

	//$startIndex=$a['startPath']+1;
	//pr($PATH);
	//for($i=$a['startPath'];$i<=$a['totPath'];$i++)
	//{
	$i=$a['startPath'];
	if(!empty($PATH[$i]))
	{
		//echo '<p>'.$i.') '.$PATH[$i].'</p>';
			
			$nextIndex=$i+1;
			
			
		//Find type of the first key	
		if($i==$a['startPath'])
		{
		$a['ACTION']=$PATH[$i];
			
			
			
		$a=ROUTING::isONLYSET($a,$PATH[$i]);
			if($a['STATUS']=="201")
			{//echo'isONLYSET';
			$k=$PATH[$i];$_GET[$PATH[$i]]="";
			}
			else
			{
			$a=ROUTING::isKEY($a,$PATH[$i],$PATH[$nextIndex],$PATH[$i]);
				if($a['STATUS']=="201")
				{//echo 'is_KEY';
				$k=$PATH[$i];$_GET[$PATH[$i]]=$PATH[$nextIndex];$i++; //Jump
				}
				else
				{
				$a=ROUTING::isDinamicKEY($a); 
					if($a['STATUS']=="201")
					{//echo 'isDinamicKEY';
					$k='*';$_GET[$PATH[$i]]="";
					}
					else
					{
					//echo 'FirstKey NotFound: '.$PATH[$i];
					$a['STATUS']=="404";
					}
				}
			}
		}	
		
		
		//Now we know the kind:
		
		//Let's check if there are child on this KEY
		
		//echo "<p>k: ".$k."</p>";
                //pr($a['getAllowed'][$k]);echo '<h1>1</h1>';
                //pr($a['getAllowed'][$k]);
			
		/*Check for cild presence!*/
		$child=ROUTING::takeChild($a['getAllowed'][$k]);
			
		/*Check for multi child presence*/
                $multi_child=ROUTING::takeMultiChild($a['getAllowed'][$k]);
			
		//pr($multi_child);
		//pr($child);		
	}
		
		
		
		
		//echo $i;
		$nextIndex=$i+1;
		//echo $nextIndex;
		//echo '<p>NEXT KEY: '.$PATH[$nextIndex].' N:('.$nextIndex.') on totPath: '.$a['totPath'].'</p>';
		if(!$child && isset($PATH[$nextIndex]) && !is_array($multi_child))
		{
		$a['STATUS']="404";
		}
		else if($child || is_array($multi_child))
		{
			//echo'IS: child OR multi_child';
				
				
			if($child) {$type="single";$child_ARR=$child;}
			elseif($multi_child) {$type="multi";$child_ARR=$multi_child;}
			else{$type=false;}
			if($type)
			{
				$a=ROUTING::child_AND_multic($a,$type,$child_ARR,$PATH,$nextIndex);
			}	
				
				
			
		}
	//}
		
		
		
	/*
	Check if remain some get not explored...
	*/
	//echo '<p>Remain: '.$a['totPath'].'</p>'; 
	//echo'<p>'.$nextIndex.'</p>';
	
	if($a['totPath']>$nextIndex)
	{
		//Something is wrong here
		//$a['STATUS']="404";
		//$a['ALERT'].="<p>To mucht GET int path</p>";
	}
	
	
return $a;
}

















function child_AND_multic($a,$type,$child_ARRAY,$PATH,$nextIndex)
    {
	//pr($child_ARRAY);
	if($type=="single")
	{
	    $child=$child_ARRAY;
	}
	elseif($type=="multi")
	{
	    $multi_child=$child_ARRAY;
	}
	
			if($child)
			{
				//echo '<p>Is a child!!</p>';
				
				$A_child=ROUTING::collectAllChild($a,$child);
				
				//pr($A_child);
				
				
				//Loop of the rest of the path
				
				$ii=0;
				//echo '<p>Remain: '.$a['totPath'].'</p>'; 
				//echo'<p>'.$nextIndex.'</p>';
				for($i=$nextIndex;$i<=$a['totPath'];$i++)
				{
					if(!isset($PATH[$i])){break;}
				$a=ROUTING::setChildStatus($a,$A_child,$PATH,$i,$ii);
                                    //echo'<p>'.$a['STATUS'].'</p>';
                                    if($a['STATUS']=="201")  break;
				//setChildStatus($a,$A_child,$PATH,$i,$ii)	
				$ii++;
				}
			}
			else
			{
			//IS A $multi_child !
			//echo'<p>Is a multi_child</p>';
				//pr($multi_child);
				
				for($I=0;$I<count($multi_child);$I++)
				{
					$ii=0;
					for($i=$nextIndex;$i<=$a['totPath'];$i++)
					{
					//$multi_child
					$k=getArrayKey($multi_child[$I]);
					//echo'<p>Check for MultiChild: '.$k.' is '.$PATH[$i].'</p>';
					
					$a=ROUTING::isDinamicKEY($a,$PATH[$i],$multi_child[$I][$k]);
					//echo '<p>'.$a['STATUS'].'</p>';
					//($a,$k,$v,$array=null)
					$k_name=$PATH[$i];
					$i++;
					$a=ROUTING::isKEY($a,$k,$PATH[$i],$k_name,$multi_child[$I][$k]);
					//echo '<p>'.$a['STATUS'].'</p>';
						
						if($a['STATUS']=="201")
						{
						break;
						}
					$ii++;
					}
					if($a['STATUS']=="201")
					{
					break;
					}
				}
			}
    return $a;
    } //End f. child_AND_multic













function setChildStatus($a,$A_child,$PATH,$i,$ii)
{
	if(isset($A_child[$ii]))
	{
	$child_k=getArrayKey($A_child[$ii]);
	//$child_k=$child_k[0];
	}
	//echo '<p>'.$i.') Compare: '.$PATH[$i].' To '.$child_k.'</p>';
	
	
	if($child_k=="*")
	{
		//echo '<p>*</p>';
		$a=ROUTING::isDinamicKEY($a,$PATH[$i],$A_child[$ii][$child_k]);
		
	}
		elseif($PATH[$i]==$child_k)
	{
		$k_name=$PATH[$i];
		$i++;$a['STATUS']="404";
		$a=ROUTING::isKEY($a,$child_k,$PATH[$i],$k_name,$A_child[$ii][$child_k]);
			}
	else
	{
		$a['STATUS']="404";
	}
	
	return $a;
}





function setLoginInfo($a,$array)
{
	if(isset($array['login']))
	{
	$a['route']['login']=$array['login'];
		//Modify login set only if login isset
		if(isset($array['login_set']))
		{
		$a['route']['login_set']=$array['login_set'];
		}
	}
	
//pr($array);
$a['ACTUAL_getAllowed']=$array;

	
return $a;
}

function isONLYSET($a,$k,$array=null)
{
	if(empty($array)) $array=$a['getAllowed'][$k];
	$a['STATUS']="404";
	$validation=$array['validation'];
	if($validation && $validation=="is_only_set")
	{
	//DEFINING A SUB MODEL
	if(!empty($array['SUB_MODEL'])) $a['SUB_MODEL']=$array['SUB_MODEL'];
	
	if(!empty($array['action'])) $a['ACTION']=$array['action'];
	if(!empty($array['action_tab'])) $a['ACTION_TAB']=$array['action_tab'];

	$a['STATUS']="201";
	}

$a['__SET_GET'][]=array($k=>'');

$a=ROUTING::setLoginInfo($a,$array);
return $a;
}


function isKEY($a,$k,$v,$k_name,$array=null)
{
	if(empty($array)) $array=$a['getAllowed'][$k];
	//echo "<p>".$k."</p>";
	//echo "<p>".$v."</p>";
	$a['STATUS']="404";
	
	//If Name & Key are not the same
	//Stop & Return 404
	//echo'<p>k:'.$k.', v:'.$v.', k_name:'.$k_name.'</p>';
	if($k_name!=$k) return $a;
	
	
	$validation=$array['validation'];
		if(!$validation) $validation="is_not_empty";
			
		if($validation=="is_in_array")
		{
			global $$array['array']; 
			//pr($array);
			if(!isset($array['array']))
			{
			//...
			$a['STATUS']="404";
			}
			else
			{
				
				if(in_array($v,$$array['array']))
				{
				$a['STATUS']="201";	
				}
				elseif(is_array($a[$array['array']]) && in_array($v,$a[$array['array']]))
				{
				$a['STATUS']="201";	
				}
				
			}
		
		}
		else
		{
			//echo $v;pr($array);
			if(isset($array) && $validation($v))
			{
			$a['STATUS']="201";	
			}
		}
		
	###
		
	//If STATUS 201 Activate Action & Action Tab if not empty!
	if($a['STATUS']=="201")
	{//pr($array);
	//echo'<p>'.$v.'</p>';
	
	//DEFINING A SUB MODEL
	if(!empty($array['SUB_MODEL'])) $a['SUB_MODEL']=$array['SUB_MODEL'];
	
	if(!empty($array['action'])) $a['ACTION']=$array['action'];
	if(!empty($array['action_tab'])) $a['ACTION_TAB']=$array['action_tab'];

	}

$a['__SET_GET'][]=array($k=>$v);
    
//$_GET[$PATH[$i]]
$a=ROUTING::setLoginInfo($a,$array);
return $a;	
}


function isDinamicKEY($a,$value=null,$array=null)
{

	//pr($a);	
	//pr($a['PATH']);
//pr($a['getAllowed']);
if(empty($value))$value=$a['firstPath'];
if(empty($array))$array=$a['getAllowed']['*'];
//echo $value;
//pr($array);
//echo $array['table'];

$table=$array['table'];
global $$table; $table=$$table;

$field=$array['field'];
$add_w=$array['add_where'];

	if(empty($table) || empty($value) || empty($field) )
	{
	$a['STATUS']="404";
	return $a;
	}

//There is a whildcard to check
$record=dbAction::_record(array(
//'echo'=>1,
'tab'=>$table,'field'=>$field,'value'=>$value,'add_w'=>$add_w));

    if(!$record)
    {
    $a['STATUS']="404";
    }
    else
    {
	//DEFINING A SUB MODEL
	if(!empty($array['SUB_MODEL'])) $a['SUB_MODEL']=$array['SUB_MODEL'];

    $_GET[$value]="";
    $a['__SET_GET'][]=array($value=>'');
    $a['ACTION']="oneRecord_".$table;
    if(!empty($array['action'])) $a['ACTION']=$array['action'];
    
    $a['ACTION_TAB']=$table;
    $a['R'][$table]=$record;
    $a['STATUS']="201";
    }

$a=ROUTING::setLoginInfo($a,$array);    
return $a;
}

function takeMultiChild($a)
{
    if(isset($a['multi_child']))
    {
    return $a['multi_child'];
    }
    return false;
}


function takeChild($a)
{
    if(isset($a['child']))
    {
    return $a['child'];
    }
    return false;
}





function collectAllChild($a,$child)
{
	//First made an array of all child	
	//Make an infinite loop, i will break if find a new child!
	for($i=0;$i>-1;$i++)
	{
		if($i=="0")
		{
		$getChild=$child;
		}
		else
		{
		$child_k=array_keys($getChild);
		$k=$child_k[0];
		$getChild=ROUTING::takeChild($getChild[$k]);
		}						
	//echo '<p>'.$i.'</p>';
	//pr($getChild);
		if(!empty($getChild) && is_array($getChild))
		{
		$A_child[]=$getChild;
		}
		if(!$getChild) {break;}
	}
	
return 	$A_child;
}


}
?>