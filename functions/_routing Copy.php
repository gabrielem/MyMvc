<?php
class ROUTING
{

function pathValidate($a)
{
echo '<h1 style="color:blue;">SERVE UN TOOL per la creazione di Models, Controllers & Views</h1>';

echo '<h3><b style="color:red;">NOTA3</b>: Il modello stabilisce la TAB, o LE Tab con un array!<br /><br />';

echo '<b style="color:red;">NOTA2</b>: meglio sistemare 3 or more cosi: LOOP SOLO NESTED con child intendo proprio come *,*,* ... perche altrimenti si possono ottenere <b style="color:red;">URL DUPLICATE</b> mischiando l ordine dei get...';

echo '<p><tt><b>!!! ATTENZIONE:</b>: rivedere <b>allow</b> e <b>not allow</b> in tutti i casi qui elencati... <br />Ed anche: $_GET, ACTION e altro... dare una bella riguardata a tutto!<br />()/_core/function/_routing.php - Riga: 55</tt></p>';
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
	
	
	
    foreach($name_of_getAllowed as $k)
    {
	    $k2=ROUTING::takeChild($a['getAllowed'][$k]);
            //pr($k2);
	//one
	#####################################
	if($a['totPath']=="1")
	{
	    $validateFunction=$a['getAllowed'][$a['firstPath']]['validation'];
	    
	    //echo'AAA'.$validateFunction." ".$a['firstPath'];
	    if(in_array($a['firstPath'],$name_of_getAllowed) && $validateFunction=='is_only_set')
	    {
		$_GET[$a['firstPath']]="";
		$a['ACTION']=$a['firstPath'];
		$a['STATUS']="202";
		break;
	    }
	    elseif($k=="*")
	    {
		$a=ROUTING::wildCard_recordCheck($a);		
		break;
	    }
	    else
	    {
		$a['STATUS']="404";
	    }
	}
	//two
	#####################################
	elseif($a['totPath']=="2")
	{
	    //two
	    ###
	    ### 1. Case: is a key->value
	    ###
	    $validateFunction=$a['getAllowed'][$a['firstPath']]['validation'];
	    //$values_not_allow=$a['getAllowed'][$a['firstPath']]['values_not_allow'];
	    //$values_allow=$a['getAllowed'][$a['firstPath']]['values_allow'];
	    
	    $_GET[$a['firstPath']]=$a['secondPath'];
            
		//Check if is in getAllowed && if validateF is true
            //echo $a['firstPath'];
            //if($k2)echo 'a';
                if(empty($validateFunction)) $validateFunction=false;
            if(!ROUTING::takeChild($a['getAllowed'][$a['firstPath']]) && in_array($a['firstPath'],$name_of_getAllowed) && $validateFunction && @$validateFunction($a['secondPath']))
	    {
                //echo $k.'AAAAAAAAAAAAAAAAAA';
                $a['ACTION']=$a['firstPath'];
		$a['STATUS']="202";
		break;
	    }
	    
            //two
	    ###
	    ### 2. Case: is a key->*
	    ###
	    else if($k!="*" && isset($k2['*']) && in_array($a['firstPath'],$name_of_getAllowed))
	    {
                //pr($k2);
                $a=ROUTING::wildCard_recordCheck($a,$a['secondPath'],$k2['*']);
                break;
	    }
                
                
                
            //two
	    ###
	    ### 3. Case: is a *->*
	    ###
	    else if($k=="*" && isset($k2['*']))
	    {
                $_GET[$a['firstPath']]="";
                $_GET[$a['secondPath']]="";
                
                //pr($k2);
                $a['STATUS']="404";
                //Check the first *
                $a=ROUTING::wildCard_recordCheck($a);
                    //Check the second *
                    if($a['STATUS']="201")
                    {
                    $a=ROUTING::wildCard_recordCheck($a,$a['secondPath'],$k2['*']);
                    }    
                break;
	    }
            else
	    {
                //echo $a['secondPath'];
                //echo 'no';
		$a['STATUS']="404";
	    }
	    
	    
	}
	//three or more
	#####################################
	elseif($a['totPath']>"2")
	{
            //echo 'A';
	    ###
	    ### 1. List of Key->Value
	    ###     2 case
	    ###     A) start with is_set_only key first MUST BE is_set_only
	    ###     B) only key->value,key->value ecc MUST BE PAIR!
	    ###
	    //echo $k;
            
            //B) only key->value,key->value ecc MUST BE PAIR!
	    //if(in_array($a['firstPath'],$name_of_getAllowed) && !ROUTING::takeChild($a['getAllowed'][$a['firstPath']]) )
            #######
            ####### DISABILIATO!!!
            ####### da rifare integrando il child anche per LOOP di key->value
            #######
            #######
            if($a=="")
            {   //echo 'a';
                //pr($a);
                $indice=$a['startPath'];
                    //echo $a['totPath'];
                for($ii=0;$ii<$a['totPath'];$ii++)
                {
                    //echo "---".$ii;
                    
                    $nextIndex=($indice+1);
                    $validation=$a['getAllowed'][$a['PATH'][$indice]]['validation'];
                        if(empty($validation)) $validation=false;
                    //echo "&".$a['PATH'][$indice]."=";
                    //echo $a['PATH'][$nextIndex];
                    //echo '<p>'.$validation.'</p>';
                        $_GET[$a['PATH'][$indice]]=$a['PATH'][$nextIndex];
                        
                        $ALL_SET_GET[]=$a['PATH'][$indice];
                        
                        if($validation && $validation($a['PATH'][$nextIndex]) && $validation!="is_only_set")
                        {
                            $a['STATUS']="201";
                            //echo 'valid...';
                            $indice++;
                            //echo "<p>indice: ".$indice."</p>";
                            
                            if($indice>=$a['totPath'])
                            {
                                break;
                            }
                        }
                        else
                        {
                            $a['STATUS']="404";
                            break;
                        }
                    $indice++;
                }
                break;
                
            }
            
            
            ###
	    ### 2. List of * wildcard + List of Key...
	    ###     2 case...
	    ###     A) start with is_set_only key
	    ###     B) direct *,*,* ...
	    ###
                
	    //A) start with is_set_only key
	    else if(in_array($a['firstPath'],$name_of_getAllowed) && isset($k2['*']))
            {
                //echo '<p>3 o piu</p>';
                    $number_of_vars=($a['totPath']-1);
                    //echo $number_of_vars;
                        //
                        $startIndex=$a['startPath']+1;
                        
                    for($ii=0;$ii<$number_of_vars;$ii++)
                    {
                        //echo '<p>check: '.$a['PATH'][$startIndex].' startIndex:'.$startIndex.' </p>';
                        //$k2['*']
                            
                            if(empty($child))
                            {
                                //pr($a['getAllowed'][$k]);echo '<h1>1</h1>';
                                //pr($a['getAllowed'][$k]);
                                $child=ROUTING::takeChild($a['getAllowed'][$k]);
                                //pr($child);
                            }
                            else
                            {
                                
                                $child=ROUTING::takeChild($child['*']);
                                //pr($child);
                            }
                                
                        //pr($child);
                        $a['STATUS']="404";
                        
                        $a=ROUTING::wildCard_recordCheck($a,$a['PATH'][$startIndex],$child['*']);   
                        //echo "<p>".$a['STATUS']."</p>";
                        if($a['STATUS']=="404")
                        {
                            //Check for Key->Value loop...
                            //pr($child);
                            $nextIndex=($startIndex+1);
                            //echo ''.$a['PATH'][$startIndex]." - ".$a['PATH'][$nextIndex];
                            $_GET[$a['PATH'][$startIndex]]=$a['PATH'][$nextIndex];
                            
                            $ALL_SET_GET[]=$a['PATH'][$startIndex];
                            
                            //pr($_GET);
                                $validation=$child[$a['PATH'][$startIndex]]['validation'];
                                //echo '<p> chech '.$validation.'</p>';
                            if(isset($child[$a['PATH'][$startIndex]]) &&  @$validation($a['PATH'][$nextIndex]) )
                            {
                                $number_of_vars=$number_of_vars-1;
                                $a['STATUS']="201";
                                //echo 'a';
                            }
                            else
                            {
                            $a['STATUS']="404";
                            break;
                            }
                        }
                        $startIndex++;
                    }
                break;
            }
            
            else
            {
                //echo $a['firstPath'];
                //echo 'AA';
                //echo $a['secondPath'];
                //echo 'no';
		$a['STATUS']="404";

            }
	    
	}
	
    }

    //pr($a);
    //pr($name_of_getAllowed);


    //pr($ALL_SET_GET);
    if(is_array($ALL_SET_GET))
    {
        $ALL_SET_GET_max=max(array_count_values($ALL_SET_GET));
        if($ALL_SET_GET_max>'1')
        {
        $a['STATUS']="404";
        }
    }
return $a;
}





function wildCard_recordCheck($a,$value=null,$array=null)
{
    //pr($a['PATH']);

if(empty($value))$value=$a['firstPath'];
if(empty($array))$array=$a['getAllowed']['*'];
//echo $value;
//pr($array);
//echo $array['table'];

$table=$array['table'];
global $$table; $table=$$table;

$field=$array['field'];
$add_w=$array['add_where'];

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
    $a['ACTION']="oneRecord_".$table;
    if(!empty($array['action'])) $a['ACTION']=$array['action'];
    
    $a['ACTION_TAB']=$table;
    $a['R'][$table]=$record;
    $a['STATUS']="201";
    }

    return $a;
}


function takeChild($a)
{
    if(isset($a['child']))
    {
    return $a['child'];
    }
    return false;
}




}
?>