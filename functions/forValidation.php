<?php
###
### validate data functions
###

function is_required($val)
{
    echo'<p>:::'.$val.'</p>';
    return is_not_empty($val);
}

function is_minLength_of($val,$settings)
{
    if(strlen($val)>$settings['n'])
    {
        return true;
    }
    return false;
}

function is_one($val)
{
//echo strlen($val);
	if($val!="1")
	{
	return false;
	}
	else
	{
	return true;
	}
}

function is_not_empty($val)
{
//echo strlen($val);
	if(empty($val))
	{
	return false;
	}
	else
	{
	return true;
	}
}

function is_only_set($val)
{
//echo strlen($val);
	if(strlen($val)=='0')
	{
	return true;
	}
	else
	{
	return false;
	}
}

function is_pagination($val){
    if(is_natural_number($val) && $val!="1")
    {
	return true;
    }
    return false;
}

//function is_natural_number($val, $acceptzero = false) {
function is_natural_number($val, $settings=null) {
    $acceptzero=$settings['acceptzero'];
 $return = ((string)$val === (string)(int)$val);
 if ($acceptzero)
  $base = 0;
 else
  $base = 1;
 if ($return && intval($val) < $base)
  $return = false;
 return $return;
}

function is_email($e)
{
    $r = "([a-z0-9]+[._-]?){1,3}([a-z0-9])*";
    $r = "^{$r}@{$r}.[a-z]{2,6}$";
    return eregi($r, $e);

}






function not_exists($a,$data,$val,$settings=null)
{
    //pr($a);
    //pr($data);
    //pr($a['DB_ACTION']);
    //pr($val);
    if(!empty($settings['fields_to_check']))
    {
	$id=$a['POST_DATA']['id'];
	$fieldsToC=$settings['fields_to_check'];
	//pr($fieldsToo);
	//pr($a['USE_TAB']);
	$W=" WHERE ";
	    for($i=0;$i<count($fieldsToC);$i++)
	    {
		if(!is_array($data[$fieldsToC[$i]]))
		{	
		    $W.=" ".$fieldsToC[$i]."='".$data[$fieldsToC[$i]]."' ";
		}
		else
		{
		    $check_for_rel[$fieldsToC[$i]]=$data[$fieldsToC[$i]];
		}
		//$data
	    }
	    //pr($W);
	$SET=array(
	    'tab'=>$a['USE_TAB'],
	    'set_w'=>$W,
	    'echo'=>'',
	    );
	//pr($SET);
	$r=dbAction::_record($SET);
	//pr($r);
	if(!$r)
	{
	    return true;
	}
	else
	{
	    //pr($check_for_rel);
	    foreach($check_for_rel as $k=>$Array)
	    {
		$TAB_NAME_REL=str_replace("id_","",$k);
		if(isset($r['REL'][$TAB_NAME_REL]))
		{
		    //$Array
		    //echo '<p>Tab Rel EXISTS, let\'s check if one of values is same</p>';
		    //pr($r['REL'][$TAB_NAME_REL]);
		    foreach($r['REL'][$TAB_NAME_REL] as $KK=>$AAR)
		    {
			//echo '<p>'.$AAR['id'].'</p>';
			if(in_array($AAR['id'],$Array))
			{
			    //pr($AAR['id']);
			    /*
				
				Record Exists
				
			    */
			    $record_exists=true;
			    break;
			}
		    }
		}
	    }
	    if($record_exists)
	    {
		return false;
	    }
	    else
	    {
		return true;
	    }
	}
	
    }
    //return false;
}


