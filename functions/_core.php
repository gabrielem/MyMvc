<?php
class import
{
    function _coreFile($f){
        include (rootCore.$f);
    }
    
    function _dbFunction($f){
        require (rootCoreFunctionDb.$f.".php");
    }

    
}


function _defineArray($ARRAY,$NAME=null,$m="get")
{
    	if($m=="put")
	{
	    if(empty($NAME))
	    {
	    echo 'ERROR IN _defineArray() <b>_core.php</b>';
	    return false;
	    }
	    
	    $ARRAY= base64_encode( serialize($ARRAY) );
	    define($NAME,$ARRAY);
	return true;
	}
	else if($m=="get")
	{
	$ARRAY = unserialize( base64_decode($ARRAY) );
	return $ARRAY;
	}
}


function tableFiledExists($t,$f)
{
    $Q="SHOW COLUMNS FROM ".$t." LIKE '".$f."'";
    $result=dbAction::_exec(array('sql'=>$Q,'return_result'=>true));
    $exists = (mysql_num_rows($result))?TRUE:FALSE;
    return $exists;
}

function launchBackgroundProcess($call) {
     // Windows
    if(is_windows()){
        pclose(popen('start /b '.$call, 'r'));
    }
     // Some sort of UNIX
    else {
        pclose(popen($call.' > /dev/null &', 'r'));
    }
    return true;
}
  
function is_windows(){
    if(PHP_OS == 'WINNT' || PHP_OS == 'WIN32'){
        return true;
    }
    return false;
}



function search_in_array($array, $key, $value)
{
    $results = array();

    if (is_array($array))
    {
        if (isset($array[$key]) && $array[$key] == $value)
            $results[] = $array;

        foreach ($array as $subarray)
            $results = array_merge($results, search_in_array($subarray, $key, $value));
    }

    return $results;
/*
#UTILIZZO 
$arr = array(0 => array(id=>1,name=>"cat 1"),
       1 => array(id=>2,name=>"cat 2"),
       2 => array(id=>3,name=>"cat 1"));

print_r(search($arr, 'name', 'cat 1'));
*/
}


function bytesToSize($bytes, $precision = 2)
{  
    $kilobyte = 1024;
    $megabyte = $kilobyte * 1024;
    $gigabyte = $megabyte * 1024;
    $terabyte = $gigabyte * 1024;
   
    if (($bytes >= 0) && ($bytes < $kilobyte)) {
        return $bytes . ' B';
 
    } elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
        return round($bytes / $kilobyte, $precision) . ' KB';
 
    } elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
        return round($bytes / $megabyte, $precision) . ' MB';
 
    } elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
        return round($bytes / $gigabyte, $precision) . ' GB';
 
    } elseif ($bytes >= $terabyte) {
        return round($bytes / $terabyte, $precision) . ' TB';
    } else {
        return $bytes . ' B';
    }
}



function getArrayKey($array)
{
    $key=array_keys($array);
    $key=$key[0];
    return $key;
}

function errClassSet($arrayError,$nameField,$className=null){
    if(empty($className)) $className="err";
    if(in_array($nameField,$arrayError))
    {
	return $className;
    }
}

//SHORTCUT TO _CORE::LANG
function __($txt,$output=true){
    return _CORE::LANG($txt,$output);
}

class _CORE
{
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
function emailTemplateSwitch($settings)
{
    
if(!empty($settings['template'])){
$template=file_get_contents($settings['template']);
$template=str_replace("#TIT#",$settings['tit'],$template);
$template=str_replace("#TXT#",$settings['txt'],$template);
$template=str_replace("#ROOT#",rootWWW,$template);
}else{
$template=$settings['txt'];
}
return $template;
}    
    
function easyEmail($settings)
{
    $template=_CORE::emailTemplateSwitch($settings);
$SMTP_DATA=$settings['SMTP_DATA'];
$EMAIL_mittente=$SMTP_DATA['mittente'];
$NOME_mittente=$SMTP_DATA['mittente_nome'];
$destinatari=$settings['destinatari'];
$allegati=$settings['allegati'];

$TIT=$settings['tit'];
$TXT=$template;

    $to = $settings['destinatari'][0]; 
    $from = $EMAIL_mittente; 
    $subject = $TIT; 

    //begin of HTML message 
    $message =$TXT; 
   //end of message 
    $headers  = "From: $from\r\n"; 
    $headers .= "Content-type: text/html\r\n"; 

    //options to send to cc+bcc 
    //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]"; 
    //$headers .= "Bcc: [email]email@maaking.cXom[/email]"; 
     
    // now lets send the email. 
    mail($to, $subject, $message, $headers); 

}    
    
    
    
function smtpEmail($settings)
{
//pr($settings);exit;
//pr("A");exit;

    $template=_CORE::emailTemplateSwitch($settings);

$SMTP_DATA=$settings['SMTP_DATA'];
$EMAIL_mittente=$SMTP_DATA['mittente'];
$NOME_mittente=$SMTP_DATA['mittente_nome'];
$destinatari=$settings['destinatari'];
$allegati=$settings['allegati'];

$TIT=$settings['tit'];
$TXT=$template;
        
        
        if(empty($SMTP_DATA))
        {
            if(DEBUG) pr("SMTP_DATA mancanti");
            return false;
        }
        
    if(empty($settings['NOME_mittente']))$settings['NOME_mittente']=$settings['EMAIL_mittente'];
        
        
    if(class_exists("PHPMailer"))
    {
    $mail                = new PHPMailer(); 
    $mail->IsSMTP(); // telling the class to use SMTP 
    $mail->Host          = $SMTP_DATA['server'];
        if($SMTP_DATA['SMTPSecure'])
        {
        $mail->SMTPSecure = $SMTP_DATA['SMTPSecure']; 
        }
    $mail->SMTPAuth      = true;                  // enable SMTP authentication
    $mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
    $mail->Host          = $SMTP_DATA['server']; // sets the SMTP server
        
        if($SMTP_DATA['Port'])
        {
        $mail->Port = $SMTP_DATA['Port']; 
        }
        
    $mail->Username      = $SMTP_DATA['username']; // SMTP account username
    $mail->Password      = $SMTP_DATA['password'];        // SMTP account password
    $mail->From       = $EMAIL_mittente; 
    $mail->FromName   = $NOME_mittente; 
    $mail->IsHTML(true); 
    $mail->Subject       = $TIT; 
    $mail->Body    = $TXT; 
        
        if(!empty($allegati))
        {
            foreach($allegati as $k=>$allegato)
            {
             $mail->AddAttachment($allegato);      // attachment
            }
        }
        
        foreach($destinatari as $k=>$email)
        {
         $mail->AddAddress($email); 
        }
        
        if(!$mail->Send()) { 
            if(DEBUG_ON) echo "<h3>Mailer Error: " . $mail->ErrorInfo."</h3>";
            return false;
        }
          else
        {
        return true;
        }
    }
    else
    {
    pr("class phpmailer non presente");
    return false;
    }
}






    function url_work($url,$settings=null)
    {
	$headers = @get_headers($url);
        if(strpos($headers[0],'200')===false)return false;
        return true;
    }
    
    
    
    
    
    function dirToArray($directory,$settings)
{
	/*
	*	EXEMPLE of USAGE:
	*
	*	_CORE::dirToArray("/var/foo/",array('type'=>'file','exclude_files'=>array('.htaccess')))
	*/
	//
//$tipo= directory,file,all
$tipo=$settings['type'];
if(empty($tipo)) $tipo="directory";
if(empty($settings['exclude_files'])){$settings['exclude_files']=array();}


//pr($tipo);
//echo $directory;
//pr($settings['exclude_files']);

 if ($handle = opendir($directory))
 {
  while ($file = readdir($handle))
  {
   if (is_dir($directory."/".$file))
   {
    if ($file != "." & $file != "..") $dirs[] = $file;
   }
  else
  {
  if ($file != "." & $file != ".." & !in_array($file,$settings['exclude_files'])) $files[] = $file;
  }
 }
}

closedir($handle);

$all=array();


	if($tipo=="directory")
	{
	return $dirs;
	}
	else if($tipo=="file")
	{
	return $files;
	}
	else if($tipo=="all")
	{
	return $all;
	}

}



    function scriptEX($path)
    {
	//$fileToExec=rootCore."hellow.php";
        $fileOutput=rootCore."output";
        $fileToExec=$path;
	
        //exec($fileToExec.' > '.$fileOutput.' 2>&1 &');
        //shell_exec('php '.$fileToExec.' 2> /dev/null > '.$fileOutput."a");
        $descriptorspec = array(
            array('pipe', 'r'),               // stdin
            array('file', $fileOutput, 'a'), // stdout
            //array('pipe', 'w'),               // stderr
        );
	pr("Eseguo:".$fileToExec);
        $proc = proc_open('php '.$fileToExec.' &',$descriptorspec,$pipes);

    }
    
    
    
    
    function setRelationData($r,$tab,$a=null)
    {
	global $RELATIONS_DB_ARRAY;
	$dbRel=$RELATIONS_DB_ARRAY[$tab];
	if(!isset($dbRel))
	{
	    return $r;
	}
	
	//echo $tab;
	
	
	//pr($dbRel);
	for($i=0;$i<count($dbRel);$i++)
	{
	    /*
		
		Many to Many
		
	    */
		
	    $tab2=$dbRel[$i]['tab'];
	    $relType=$dbRel[$i]['rel'];
		
		$idTab1="id_".$tab;
		$idTab2="id_".$tab2;
		
	    if($relType=="many-to-many")
	    {
		//echo'<hr><h1>many to many for r: '.$r['id'].' -> '.$r['titolo'].' --- per la TAB: '.$dbRel[$i]['tab'].'</h1>';
		$loop=null;
		$TAB_REL=$tab."_".$tab2;
		  
		//$where=" WHERE  ";
		//$a['FILTER_SET'][$tab][$tab2]=array('key'=>$idTab2,'value'=>$r['id']);
		//$loop=dbAction::_loop(array('tab'=>$tab,'tab2'=>$tab2,'where'=>$where));
		    
		$where=" WHERE ".$idTab1."='".$r['id']."'";
		//echo'<p>tab: '.$TAB_REL.' | where: '.$where.'</p>';
		//$loop=_loop($TAB_REL,$where,"","",1);
		$loop=dbAction::_loop(array('tab'=>$TAB_REL,'where'=>$where,'limit'=>"LIMIT 0,100"));
		
		    if($a['echo']) {pr($loop);}
		    if(!$loop)
		    {
			//echo'AAA';
		    }
		if($loop)
		{
		    $add="";
		    
		    //echo '<p>'.$tab.' . '.$tab2.'</p>';
		    //pr($loop);
		    
		    for($ii=0;$ii<count($loop);$ii++)
		    {
			$add.=" OR id='".$loop[$ii][$idTab2]."' ";
		    }
		    
		    //$loop2=_loop($tab2," WHERE 1=0 ".$add." ");
		    
		    $loop2=dbAction::_loop(array('tab'=>$tab2,'where'=>" WHERE 1=0 ".$add." ",'limit'=>"LIMIT 0,300"));
		    
		    $r['REL'][$tab2]=$loop2;
		    //echo'<p>'.$tab.'</p>';
		    //pr($loop2);
		    if($a['echo']) {pr($loop2);}
		}
	    }
	    elseif($relType=="many-to-one" && $r[$idTab2]!="0")
	    {
		$record=null;
		//if(DEBUG) $EE="1";
		$record=_record($tab2,"id",$r[$idTab2],"",$EE);
		if($record)
		{
		    $r['REL'][$tab2]=$record;
		}
		else
		{
		    if(DEBUG)
		    {
			//echo'<p>ERROR IN RELATION:<br /><b>'.__FILE__.'</b> on line: '.__LINE__.'</p>';
			$r['REL'][$tab2]=false;
			$r['REL']['MSG']='<p>ERROR IN RELATION:<br /><b>'.__FILE__.'</b> on line: '.__LINE__.'</p>';
		    }
		}
	    }
	}
	    $r['dbRelations']=$dbRel;
	return $r;
    }
    
    
    
    
    
    function delete_db_files($r,$SET=null)
    {
	$return=true;
	
	$tab=$r['TAB_NAME'];
	
	$db_files_CONFIG=rootDOC."_config/_db_files/".$tab.".php";
	
	# Check if $db_files_CONFIG exists
	    if(file_exists($db_files_CONFIG))
	    {
		
		/*
		    
		    Loading array $db_files 
		    
		*/
		include($db_files_CONFIG);
		    
		    if(!empty($SET))
		    {
			if(!isset($db_files[$SET]))
			{
			    echo "SET NOT EXISTS";
			    $return=false;
			}
			$db_files=$db_files[$SET];
			$db_files[$SET]=$db_files;
		    }
		    
		foreach($db_files AS $k=>$v)
		{
		    //echo '<p><b>'.$k.'</b></p>';
			
		    /*
			
			Set the $NAME_FILE
			
		    */
			
		    $name_file_Array=$v['name_file'];
		    $NAME_FILE="";
                    foreach($name_file_Array AS $k_name_file=>$v_name_file)
                    {
                        if($v_name_file[0]=="#")
                        {
                            $v_name_file_DB=str_replace("#","",$v_name_file);
                            //echo'<p>'.$v_name_file_DB.' - '.$r[$v_name_file_DB].' - '.$NAME_FILE.'</p>';
                            if(!isset($r[$v_name_file_DB]))
                            {
                                echo "<p>field: '.$v_name_file.' not present in the table: '.$tab.'</p>";
                                return false;
                            }
                            $NAME_FILE.=$r[$v_name_file_DB];
                        }
                        else
                        {
                            $NAME_FILE.=$v_name_file;
                        }
                    }
		    
		    
		    
		    
		    
		    if($v['alphabetic_storage'])
		    {
			//1. Check if the alphabetic Dir exists
			$START_LETTER=substr($NAME_FILE,0,1);
			$alphabeticDir=rootDOC.$v['upload_path'].$START_LETTER."/";
			//2. Set $DIR_FOR_NEWFILE
			//$DIR_FOR_NEWFILE=$alphabeticDir;
			$v['upload_path']=$v['upload_path'].$START_LETTER."/";
		    }
		    
		    
		    
		    
		    //echo '<p>'.$v[$i].'</p>';
		    /*
			
			Run this only for image_sets
			
		    */
		    if(isset($v['image_sets']))
		    {
			//echo'<p>image_sets</p>';
			/*
			    
			    An image_sets is provide
			    let's try to delete all
			    image in the set
			    
			*/
			foreach($v['image_sets'] AS $k2=>$v2)
			{
			    //$fileToDelete=$v['upload_path'].$NAME_FILE."_".$k2.$v2['est'];
			    $fileToDelete=$v['upload_path'].$k2."/".$NAME_FILE.$v2['est'];
			    //echo'<p>delete: '.$fileToDelete.'</p>';
			    @unlink($fileToDelete); 
			}
		    }
		    /*
			ANY WAY RUN THIS!
			
			No image_sets
			so delete all the file
			for all allowed_estentions 
			
			This script is run for all
			also for image type (image_sets)
			
			for delete the main image
			that is no in the image_sets array
			
		    */
			
		    foreach($v['allowed_estentions'] AS $k2=>$v2)
		    {
			$fileToDelete=$v['upload_path'].$NAME_FILE.$v2;
			//echo'<p>delete: '.$fileToDelete.'</p>';
			@unlink($fileToDelete);
		    }
		    
		    
		}
	    }
		
	return $return;
    } //End f. delete_db_files()
    
    
    function onlyNotEmptyValue($array)
    {
	foreach($array AS $k=>$v)
	{
	    $v2=$v;
	    if(!is_array($v))$v2=trim($v);
	    if(empty($v2))
	    {
		unset($array[$k]);
	    }
	}
	return $array;
    }
    
    
    function getManyToManyTabs($array=null)
    {
	    
	//pr($array);
	$tabsArray=false;
	    
	if(is_array($array) && !empty($array ))
	{
	    foreach($array AS $k=>$v)
	    {
		if($v['rel']=="many-to-many")
		{
		    //echo'<p>'.$v['tab'].'</p>';
		$tabsArray[]=$v['tab'];
		}
		
	    }
	}
	return $tabsArray;
    }
	
	
	
    function setMetaTags($a,$tag,$OVERWRITE=false)
    {
	if(empty($a['METATAG']) || $OVERWRITE)
	{
	    $a['METATAG']=$tag;
	}
	else
	{
	    $a['METATAG'].="\n".$tag;
	}
	
	return $a;
    }
	
	
    function redirect($settings)
    {
	//array('location'=>'','STAUS'=>'');
	$location=$settings['location'];
	if($settings['location']=="referer" || empty($settings['location']))
	{
	    $location=$_SERVER['HTTP_REFERER'];
	}
	if(!empty($settings['STATUS']))
	{
	    _CORE::HTTPStatus($settings['STATUS']);
	}
	header("location: ".$location);
	exit;
    }
	
	
	
	
	
    function LANG($txt,$output=true)
    {
	global $lang;
	$txt_slug=slug($txt);
	if(isset($lang[$txt_slug]))
	{
	    return $lang[$txt_slug];
	}
	else
	{
	    if(DEBUG && $output)
	    {
		return '<span title="'.$txt_slug.'">'.$txt.'</span>';
	    }
		return $txt;
	}
	//return " - NEED TRANSLATION on _CORE::LANG() ".$txt;
    }
	
	
	
    function setRelNext($url){
	return '<link rel="next" href="'.$url.'" />';
    }
	
    function setRelPrev($url){
	return '<link rel="prev" href="'.$url.'" />';
    }
        
	
    function setRelCanonical($url){
	return '<link rel="canonical" href="'.$url.'" />';
    }
    
    function findEmptyVar($array,$required_fields){
	foreach($required_fields as $k=>$v)
	{
	    //echo'<p>'.$v. ' esiste? </p>';
	    if(empty($array[$v])) { $res[]=$v;}
	}
	return $res;
    }

    function sumWhere($arrayW,$W=null)
    {
	if(empty($W)) $W=" WHERE 1=1 ";
	    
	for($i=0;$i<count($arrayW);$i++)
	{
	    $W.=" ".$arrayW[$i]." ";
	}
	
	return $W;
    }
    
    function doAlert($alert,$noscript=null)
    {
	if(empty($noscript))
	{
	echo '<script>alert("'.$alert.'");</script>';
	}
	else
	{
	return 'alert("'.$alert.'");';
	}
    }
    
    
    function getVarClass($class,$var)
    {
    $v = get_class_vars($class);   
	return $v[$var];
    }
    
    
    function addView($view)
    {
	$view=rootDOC."_views/".$view.".php";
	return $view;
    }

    function fromDOC_toWWW($var)
    {
	$var=str_replace(rootDOC,rootWWW,$var);
	return $var;
    }
    function addCss($a,$f)
    {
    //pr($a);
    return "<link rel=\"stylesheet\" type=\"text/css\" href=\""._CORE::fromDOC_toWWW($a['TEMPLATE_DIR']).$f."\">";
    }

    
    function urlAnalysis($URL)
    {
    //$URL=$_GET['url'];
    //echo ''.$_GET['url'].'';
	    
	/*
	    
	    Setting the QueryString
	    
	*/    
	$QS=$_SERVER['QUERY_STRING'];
	$QS=substr(str_replace("url=".$URL,"",$QS),0);
        //echo $QS;
	    if(substr($QS,0,1)=="&"){$QS=substr($QS,1);}
	    if(!empty($QS)) $a['QS']="?".$QS;
	    
	    
	$r_default=array('name'=>'home','slug'=>'','model'=>'home','login'=>'0','login_set'=>'0');
	if(HOME_REQUIRE_LOGIN==true)
	{
	   $r_default=array('name'=>'home','slug'=>'','model'=>'home','login'=>'1','login_set'=>HOME_REQUIRE_LOGIN_SET,'login_tab'=>HOME_REQUIRE_LOGIN_TAB);
	}
	
    
    $a['__URL']=$URL;
    
    $pathArray=trimArray(explode("/",$URL));
    $totUrlVar=count($pathArray);
    //pr($pathArray);
    //echo $totUrlVar;
    
    $a['PATH']=$pathArray;
    
	$IS_HOME=true;
	$r=$r_default;
	
	if($totUrlVar!="0")
	{
	    if($pathArray[0]=="a")
	    {
	    $IS_HOME=false;
	    $SUPERADMIN=true;
	    }
	    else
	    {
	    //$r=_record($TAB_slug,"slug",$pathArray[0]," AND radice='1' ");
	    //$r=_record(TAB_ROUTES,"slug",$pathArray[0],"");
	    $r=dbAction::_record(array('tab'=>TAB_ROUTES,'field'=>'slug','value'=>$pathArray[0]));
		if($r)
		{
		    $IS_HOME=false;
		    
		    $a['STATUS']="201";
		    //$a['route']=$r;
		}
		else
		{
		    $IS_HOME=true;
		    
		    $a['STATUS']="404";
		    
		    $r=$r_default;
		    
		}
	    }
	}
    
    $a['route']=$r;
    //pr($a['route']);
    //$a['route']['model']
    
    //define(IS_HOME,$IS_HOME);
    
    
    //Set $totPath, $firstPath, $secondPath, $startPath
    $totPath=count($a['PATH'])-1;       
    $firstPath=$a['PATH'][1];           
    $secondPath=$a['PATH'][2];          
    $startPath="1";                     
    
    if($IS_HOME) $totPath=count($a['PATH']);
    if($IS_HOME) $firstPath=$a['PATH'][0];
    if($IS_HOME) $secondPath=$a['PATH'][1];
    if($IS_HOME) $startPath="0";
    
    $a['totPath']=$totPath;
    $a['firstPath']=$firstPath;
    $a['secondPath']=$secondPath;
    $a['startPath']=$startPath;
    
    $a['IS_HOME']=$IS_HOME;
    $a['SUPERADMIN']=$SUPERADMIN;
    $a['_pathArray_']=$pathArray;
    
    define(IS_HOME,$a['IS_HOME']);
    
    return $a;
	
    }

    //Chekin if View Exists
    function viewCheck($a)
    {
	### View Exists?
	if(!file_exists($a['VIEW'])){
	    if(DEBUG)
	    {
	    //IF MISSING: 
	    $a['VIEW_MISSING']=$a['VIEW']; 
	    $a['VIEW']=_CORE::lookingForView($a,"404view.php"); 
	    }
	    else
	    {
		$a['STATUS']="404";
	    }
	}
	return $a;
    }    
    

    //Select the right view in Core or in DOC
    function lookingForView($a,$view)
    {
	
	    
	$view_core=rootCore."_views/".$view;
        $view_doc=rootDOC."_views/".$view;
        $view_doc_model=rootDOC."_views/".$a['route']['model']."/".$view;    
	    
	    
	    if(file_exists($view_doc_model) && !empty($a['route']['model']) ){
	    $a['VIEW']=$view_doc_model;
	    }
	    else if(file_exists($view_doc))
	    {
	    $a['VIEW']=$view_doc;
	    }
	    else
	    {
	    $a['VIEW']=$view_core;
	    }
	    
	    return $a['VIEW'];
    }


    function statusView($a)
    {
	if($a['STATUS']=="404")
	{
	    $a['VIEW']=_CORE::lookingForView($a,"404.php"); 
	}
	return $a;
    }
    
    function Set_GET_DATA($a)
    {
	
	//pr($a['__SET_GET']);
	for($i=0;$i<count($a['__SET_GET']);$i++)
	{
	    $key=getArrayKey($a['__SET_GET'][$i]);
	    //echo '<p>'.$a['__SET_GET'][$i][$key].'</p>';
	    $_GET[$key]=$a['__SET_GET'][$i][$key];
	}
	//pr($_GET);
	$a['GET_DATA']=$_GET;
	return $a;
    }
    
    function Set_POST_DATA($a)
    {
	$a['POST_DATA']=$_POST;
	return $a;
    }
    
    
    function printAlert($a)
    {
	if(DEBUG && !empty($a['ALERT']))
	{
	    echo '<tt style="margin:9px;margin:0 auto;display:block;border-bottom:1px #afafaf solid;background:#ffffcc;padding:5px;">';
	    echo '<b style="color:red;">Alert!</b><br />';
	    echo $a['ALERT'];
	    echo '</tt>';
	    
	}
    return $a;

    }
    
    
    function showInfo($a)
    {
	global $RELATIONS_DB_ARRAY;
	$relDB=$RELATIONS_DB_ARRAY[$a['USE_TAB']];
	//pr($a);
	if(DEBUG)
	{
	echo'<div style="font-size:10px;background:#ffffcc;border-bottom:1px black solid;padding:3px;">';
	echo ' <b>'._CORE::HTTPStatus($a['STATUS'],1)."</b> | ";
	echo ' r: <a style="color:blue;" href="#" title="route][model">'.$a['route']['model'].'</a>';
	echo ' M_C: <a style="color:blue;" href="#" title="MODEL_CLASS">'.$a['MODEL_CLASS'].'</a>';
	
	echo ' C_CLASS: <a style="color:blue;" href="#" title="CONTROLLER_CLASS">'.$a['CONTROLLER_CLASS'].'</a>';
	
	if(!empty($a['BEHAVIOR'])){
	echo ' BEHAVIOR: <a style="color:green;" href="#" title="BEHAVIOR">'.$a['BEHAVIOR'].'</a>';}
	
	if(!empty($a['SUB_MODEL_CLASS'])){
	echo ' SUB M_C: <a style="color:blue;" href="#" title="SUB_MODEL_CLASS">'.$a['SUB_MODEL_CLASS'].'</a>';}
	
	if(!empty($a['SUB_CONTROLLER_CLASS'])){
	echo ' SUB C_C: <a style="color:blue;" href="#" title="SUB_CONTROLLER_CLASS">'.$a['SUB_CONTROLLER_CLASS'].'</a>';}
	
	echo ' | T: <a style="color:blue;" href="#" title="TEMPLATE_DIR: '.$a['TEMPLATE_DIR'].'"><b>/'.str_replace(rootDOC,"",$a['TEMPLATE_DIR']).'</b></a>';
	
	echo ' | V: <a style="color:blue;" href="#" title="VIEW: '.$a['VIEW'].'"><b>/'.str_replace(rootDOC,"",$a['VIEW']).'</b></a>';
	
	if(!empty($a['ACTION'])){
	echo ' ACTION: '.$a['ACTION'];
	} else {
	echo ' <span style="color:red;">ACTION: <b>...</b></span>';    
	}
	
	if(!empty($a['ACTION_TAB'])){
	echo ' ACTION_TAB: '.$a['ACTION_TAB'];}
	
	if(!empty($a['USE_TAB'])){
	    //pr($relDB);
	    for($i=0;$i<count($relDB);$i++)
	    {
	    $msg_USE_TAB.='tab: '.$relDB[$i][tab].' rel: '.$relDB[$i][rel].''." --- ";
	    }
	echo ' USE_TAB: <a style="color:blue;" href="#" title="'.$msg_USE_TAB.'">'.$a['USE_TAB']."</a>";}else{
	echo ' <span style="color:red;">USE_TAB: <b>...</b></span>';    
	}
	echo'</div>'; 
	}
    return $a;
    }

    function HTTPStatus_TITLE($a)
    {
	if($a['STATUS']=="404")
	{
	    $a['title']="404 - Page Not Found";
	}
	return $a;
    }
    function HTTPStatus($num,$echo=null) {
	$http = array(
	    100 => 'HTTP/1.1 100 Continue',
	    101 => 'HTTP/1.1 101 Switching Protocols',
	    200 => 'HTTP/1.1 200 OK',
	    201 => 'HTTP/1.1 201 Created',
	    202 => 'HTTP/1.1 202 Accepted',
	    203 => 'HTTP/1.1 203 Non-Authoritative Information',
	    204 => 'HTTP/1.1 204 No Content',
	    205 => 'HTTP/1.1 205 Reset Content',
	    206 => 'HTTP/1.1 206 Partial Content',
	    300 => 'HTTP/1.1 300 Multiple Choices',
	    301 => 'HTTP/1.1 301 Moved Permanently',
	    302 => 'HTTP/1.1 302 Found',
	    303 => 'HTTP/1.1 303 See Other',
	    304 => 'HTTP/1.1 304 Not Modified',
	    305 => 'HTTP/1.1 305 Use Proxy',
	    307 => 'HTTP/1.1 307 Temporary Redirect',
	    400 => 'HTTP/1.1 400 Bad Request',
	    401 => 'HTTP/1.1 401 Unauthorized',
	    402 => 'HTTP/1.1 402 Payment Required',
	    403 => 'HTTP/1.1 403 Forbidden',
	    404 => 'HTTP/1.1 404 Not Found',
	    405 => 'HTTP/1.1 405 Method Not Allowed',
	    406 => 'HTTP/1.1 406 Not Acceptable',
	    407 => 'HTTP/1.1 407 Proxy Authentication Required',
	    408 => 'HTTP/1.1 408 Request Time-out',
	    409 => 'HTTP/1.1 409 Conflict',
	    410 => 'HTTP/1.1 410 Gone',
	    411 => 'HTTP/1.1 411 Length Required',
	    412 => 'HTTP/1.1 412 Precondition Failed',
	    413 => 'HTTP/1.1 413 Request Entity Too Large',
	    414 => 'HTTP/1.1 414 Request-URI Too Large',
	    415 => 'HTTP/1.1 415 Unsupported Media Type',
	    416 => 'HTTP/1.1 416 Requested Range Not Satisfiable',
	    417 => 'HTTP/1.1 417 Expectation Failed',
	    500 => 'HTTP/1.1 500 Internal Server Error',
	    501 => 'HTTP/1.1 501 Not Implemented',
	    502 => 'HTTP/1.1 502 Bad Gateway',
	    503 => 'HTTP/1.1 503 Service Unavailable',
	    504 => 'HTTP/1.1 504 Gateway Time-out',
	    505 => 'HTTP/1.1 505 HTTP Version Not Supported',
	);
    
	if(isset($echo))
	{
	return $http[$num];   
	}
	else
	{
	header($http[$num]);
	return $http[$num];
	}    
	    
    }



    function templateSelect($a)
    {
	//pr($a);	    
	if(empty($a['TEMPLATE_DIR']))
	{
	    //Set Default!
	    $a['TEMPLATE_DIR']=TEMPLATE_DIR;
	    
	    $ModelTemplateDir=rootDOC."_template/_".$a['route']['model']."/";
	    if(is_dir($ModelTemplateDir))
	    {
	    $a['TEMPLATE_DIR']=$ModelTemplateDir;
	    }
	    
	    if(!is_dir($a['TEMPLATE_DIR']))
	    {
	    $a['TEMPLATE_DIR']=TEMPLATE_DIR;
	    $a['ALERT'].="TEMPLATE NOT EXISTS: \"<b>".$a['TEMPLATE_DIR']."</b>\"<BR />";
	    }
	    
	    $a['TEMPLATE_DIR_WWW']=str_replace(rootDOC,rootWWW,$a['TEMPLATE_DIR']);
	}
    return $a;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    function renameDbFiles($a,$rSave)
    {
	//pr($rSave);
	$TAB=$rSave['TAB_NAME'];
	    /*
	    Recovering data now!
	    */
	    $a_rNow=array('tab'=>$TAB,'field'=>'id','value'=>$rSave['id'],'echo'=>'0');
	    $rNow=dbAction::_record($a_rNow);
	    //pr($rNow);
	    
	    //exit;
	### 1. load $db_flies array configuration
        include(rootDOC."_config/_db_files/".$TAB.".php");
	
	### 2. loop the array and looking for files in the data
        foreach($db_files as $k=>$array)
        {
	    //echo'<p>'.$k.'->'.$array.'</p>';
	    
	    
		    ### a) take data from "name_file"
                    $name_file_Array=$array['name_file'];
                        
                        
                    ### b) loop the data and build the name whit $r record data
                    //pr($name_file_Array);
                        
                    $NAME_FILE="";
                    foreach($name_file_Array AS $k_name_file=>$v_name_file)
                    {
                        if($v_name_file[0]=="#")
                        {
                            $v_name_file_DB=str_replace("#","",$v_name_file);
                            //echo'<p>###########'.$v_name_file_DB.' - '.$rSave[$v_name_file_DB].' - '.$NAME_FILE.'</p>';
                            if(!isset($rSave[$v_name_file_DB]))
                            { 
                                ### SET RESULT
                                echo"<p>field: '.$v_name_file.' not present in the table: '.$TAB.'</p>";
                                return false;
                            }
                            $NAME_FILE.=$rSave[$v_name_file_DB];
                        }
                        else
                        {
                            $NAME_FILE.=$v_name_file;
                        }
                    }
		    //echo '<p>1 NAME_FILE: '.$NAME_FILE.'</p>';
		    
		    
		    ### b) loop the data and build the name whit $r record data
                    //pr($name_file_Array);
                        
                    $NAME_FILE_NOW="";
                    foreach($name_file_Array AS $k_name_file=>$v_name_file)
                    {
                        if($v_name_file[0]=="#")
                        {
                            $v_name_file_DB=str_replace("#","",$v_name_file);
                            echo'<p>'.$v_name_file_DB.' - '.$rNow[$v_name_file_DB].' - '.$NAME_FILE_NOW.'</p>';
                            if(!isset($rNow[$v_name_file_DB]))
                            { 
                                ### SET RESULT
                                echo"<p>field: '.$v_name_file.' not present in the passed <b>DATA</b> ()</p>";
                                return false;
                            }
                            $NAME_FILE_NOW.=$rNow[$v_name_file_DB];
                        }
                        else
                        {
                            $NAME_FILE_NOW.=$v_name_file;
                        }
                    }
		    
		    
		    echo '<p>NAME_FILE_NOW: '.$NAME_FILE_NOW.'</p>';
		    //exit;
			
		    /*
			Loop all allowed_estentions
			and just rename it!
		    */
		    for($i=0;$i<count($array['allowed_estentions']);$i++){
			$est=$array['allowed_estentions'][$i];
			if($array['alphabetic_storage'])
			{
			    $I_NAME_FILE=strtolower(substr($NAME_FILE,0,1));
			    $I_NAME_FILE_NOW=strtolower(substr($NAME_FILE_NOW,0,1));
			    $fileSave=rootDOC.$array['upload_path'].$I_NAME_FILE."/".$NAME_FILE.$est;
			    $fileNew=rootDOC.$array['upload_path'].$I_NAME_FILE."/".$NAME_FILE_NOW.$est;
			}
			else
			{
			    $fileSave=rootDOC.$array['upload_path'].$NAME_FILE.$est;
			    $fileNew=rootDOC.$array['upload_path'].$NAME_FILE_NOW.$est;
			}
			/*
			    
			    If $fileSave exists AND is differente from $fileNew
			    copy it to file new and delete it ($fileSave)
			    
			*/
			pr($fileSave."-".$fileNew);
			if(file_exists($fileSave) && $fileSave!=$fileNew)
			{
			    echo'<p style="color:red;"> ESEGUO: <b>copy</b> '.$fileSave." -> ".$fileNew.'</p>';
			    if(copy($fileSave,$fileNew))
			    {
			    unlink($fileSave);
			    }
			}
			
			
		    }
		    //
		    
		    /*
			
			And if isset(image_sets)
			loop all and rename it all!
			
		    */
		    
		    if(isset($array['image_sets']))
                    {
                        //for($i=0;$i<count($array['image_sets']);$i++)
                        foreach($array['image_sets'] AS $k_image_sets=>$v_image_sets)
			{
			    if($array['alphabetic_storage'])
			    {
				$I_NAME_FILE=strtolower(substr($NAME_FILE,0,1));
				$I_NAME_FILE_NOW=strtolower(substr($NAME_FILE_NOW,0,1));
				$fileSave=rootDOC.$array['upload_path'].$I_NAME_FILE."/".$k_image_sets."/".$NAME_FILE.$v_image_sets['est'];
				$fileNew=rootDOC.$array['upload_path'].$I_NAME_FILE_NOW."/".$k_image_sets."/".$NAME_FILE_NOW.$v_image_sets['est'];
			    }
			    else
			    {
				$fileSave=rootDOC.$array['upload_path'].$k_image_sets."/".$NAME_FILE.$v_image_sets['est'];
				$fileNew=rootDOC.$array['upload_path'].$k_image_sets."/".$NAME_FILE_NOW.$v_image_sets['est'];
			    }
			    /*
				
				If $fileSave exists AND is differente from $fileNew
				copy it to file new and delete it ($fileSave)
				
			    */
			    echo'<p style="color:red;"> (SET) ESEGUO: <b>copy</b> '.$fileSave." -> ".$fileNew.'</p>';
			    if(file_exists($fileSave) && $fileSave!=$fileNew)
			    {
				if(copy($fileSave,$fileNew))
				{
				unlink($fileSave);
				}
			    }
				
				
			}
		    }
		    
		    
		    //exit;
	}
	
    }
    
    
    function uploadFiles($a,$ID_RECORD,$TAB,$IMG_ON_SERVER=null)
    {
	//echo'AAAAAAAAAAA';exit;
        ini_set('upload_max_filesize','100M');    
        $res['RESULT']=true;
        /*
	    
	    1. load $db_flies array configuration
	    2. loop the array and looking for files in the data
	    3. if is find it save it
		- For image can be added the method for save different size
        */
        ### 1. load $db_flies array configuration
        include(rootDOC."_config/_db_files/".$TAB.".php");
                            
        ### 2. loop the array and looking for files in the data
        foreach($db_files as $k=>$array)
        {
            //$db_files[$i];
            //pr($_FILES);
            if(!empty($_FILES[$array['campo_upload']]['name']) || !empty($IMG_ON_SERVER))
            {                    
                $UPLOAD_FILE_INFO=$_FILES[$array['campo_upload']];
		if(!empty($IMG_ON_SERVER)) $UPLOAD_FILE_INFO=$IMG_ON_SERVER;
                /*
                    
                    This Upload Request it is set
                    Lets do the upload ...
                    
                    1. Check if sxtention is allowed & take estention of the file
                    2. Check byte size of the file
                    3. Recovering record data
                    
                    
                */
                        
                ### 1. Check if sxtention is allowed
                    $actual_file_estention=strtolower(strrchr( $UPLOAD_FILE_INFO['name'], '.'));
                    if(!in_array($actual_file_estention,$array['allowed_estentions']))
                    {
                        ### SET RESULT
                        $res['RESULT']=false;
                        $res['ERR_MSG']="<p>".__("Estention of file not allowed")."</p>";
                        return $res;
                    }
                    
                    
                ### 2. Check byte size of the file
                //$UPLOAD_FILE_INFO['size'];
                $max_file_allowed=$array['max_filesize'];
                    //echo '<p>file: '.$UPLOAD_FILE_INFO['size'].' max: '.$max_file_allowed.'</p>';
                    if($UPLOAD_FILE_INFO['size']>$max_file_allowed)
                    {
                        ### SET RESULT
                        $res['RESULT']=false;
                        $max_size=bytesToSize($max_file_allowed);
                        $res['ERR_MSG']='<p>'.__("File Size is too big.<br />File size must be of:").' '.$max_size.'</p>';
                        return $res;
                    }
                    
                    
                ### 3. Recovering record data
                $r=dbAction::_record(array('tab'=>$TAB,'field'=>'id','value'=>$ID_RECORD,'echo'=>true));
                    if(!$r)
                    {
                        ### SET RESULT
                        $res['RESULT']=false;
                        $res['ERR_MSG']="<p>".__("Unable to recover data from database")."</p>";
                        return $res;
                    }
                        
                    
                    
                ### Set $fileTemp
                //pr($UPLOAD_FILE_INFO['tmp_name']);
                $fileTemp=$UPLOAD_FILE_INFO['tmp_name'];
                    /*
                        
                        Build name for file
                        a) take data from "name_file"
                        b) loop the data and build the name whit $r record data
                        
                    */
                        
                        
                    ### a) take data from "name_file"
                    $name_file_Array=$array['name_file'];
                        
                        
                    ### b) loop the data and build the name whit $r record data
                    //pr($name_file_Array);
                        
                    $NAME_FILE="";
                    foreach($name_file_Array AS $k_name_file=>$v_name_file)
                    {
                        if($v_name_file[0]=="#")
                        {
                            $v_name_file_DB=str_replace("#","",$v_name_file);
                            //echo'<p>'.$v_name_file_DB.' - '.$r[$v_name_file_DB].' - '.$NAME_FILE.'</p>';
                            if(!isset($r[$v_name_file_DB]))
                            {
                                ### SET RESULT
                                $res['RESULT']=false;
                                $res['ERR_MSG']="<p>field: '.$v_name_file.' not present in the table: '.$TAB.'</p>";
                                return $res;
                            }
                            $NAME_FILE.=$r[$v_name_file_DB];
                        }
                        else
                        {
                            $NAME_FILE.=$v_name_file;
                        }
                    }
                     
                     
                ### Set the name of the new File $fileNew
                $DIR_FOR_NEWFILE=rootDOC.$array['upload_path'];
			
		    if($array['alphabetic_storage'])
		    {
			//1. Check if the alphabetic Dir exists
			$START_LETTER=substr($NAME_FILE,0,1);
			$alphabeticDir=rootDOC.$array['upload_path'].$START_LETTER."/";
			if(!is_dir($alphabeticDir))
			{
			    mkdir($alphabeticDir, 0755);
			}
			//2. Set $DIR_FOR_NEWFILE
			$DIR_FOR_NEWFILE=$alphabeticDir;
		    }
			
		$file_with_no_est=$DIR_FOR_NEWFILE.$NAME_FILE;
                $fileNew=$file_with_no_est.$actual_file_estention;
                    //echo "<p>".$fileNew."</p>";
                    
                    
                    
                    
                    
                    
                    //pr("fileTemp:".$fileTemp);
		    //pr("fileNew:".$fileNew);
		    
		    if(empty($IMG_ON_SERVER))
		    {
			/*
			    Do it this only if file is a real upload one
			*/
	                $upload_file=move_uploaded_file($fileTemp, $fileNew);
		    }
                    
                    /*
                        
                        Create all the variants from the image_sets ARRAY
                        but only if it is set! 
                        
                    */
                    if(isset($array['image_sets']))
                    {
                        //for($i=0;$i<count($array['image_sets']);$i++)
                        foreach($array['image_sets'] AS $k_image_sets=>$v_image_sets)
                        {
			    
                        //$imgToResize=$file_with_no_est."_".$k_image_sets.$v_image_sets['est'];
			$imgToResize=$DIR_FOR_NEWFILE.$k_image_sets."/".$NAME_FILE.$v_image_sets['est'];
			    if(!is_dir($DIR_FOR_NEWFILE.$k_image_sets."/"))
			    {
				mkdir($DIR_FOR_NEWFILE.$k_image_sets."/", 0755);
			    }
                        $IMG=New IMG();
                        $IMG->_riduciImg($fileNew,$imgToResize,$v_image_sets['w'],$v_image_sets['h']);
                        }
                    }
                    
            }
            
        }
            
        return $res;
            
    }//End f _uploadFiles()
	
	
	
	
	
	
	
	
	
    function checkDbFiles($r,$TAB,$settings=null)
    {
	//echo '<p> - tab: '.$TAB.' - </p>';
	$config_file=rootDOC."_config/_db_files/".$TAB.".php";
	if(!file_exists($config_file))
	{
	    return $r;
	}
        ### 1. load $db_flies array configuration
        include($config_file);
	    
	    //pr($db_files);
	    
        ### 2. loop $db_files and check if file exists
        foreach($db_files as $k=>$array)
        {
        /*
            
            For each record check all the db_file possibility
            
        */
            ### a) take data from "name_file"
            $name_file_Array=$array['name_file'];
            $NAME_FILE="";
                foreach($name_file_Array AS $k_name_file=>$v_name_file)
                {
		    
		    
		    
                    if($v_name_file[0]=="#")
                    {
                        $v_name_file_DB=str_replace("#","",$v_name_file);
                        //echo'<p>'.$v_name_file_DB.' - '.$r[$v_name_file_DB].' - '.$NAME_FILE.'</p>';
                        if(!isset($r[$v_name_file_DB]))
                        {
                            echo "<p>field: '.$v_name_file.' not present in the table: '.$TAB.'</p>";
                            //return $res;
                        }
                        $NAME_FILE.=$r[$v_name_file_DB];
                    }
                    else
                    {
                        $NAME_FILE.=$v_name_file;
                    }
                }
		
		
		
		
		if($array['alphabetic_storage'])
		    {
			//1. Check if the alphabetic Dir exists
			$START_LETTER=substr($NAME_FILE,0,1);
			$alphabeticDir=rootDOC.$array['upload_path'].$START_LETTER."/";
			//2. Set $DIR_FOR_NEWFILE
			//$DIR_FOR_NEWFILE=$alphabeticDir;
			$array['upload_path']=$array['upload_path'].$START_LETTER."/";
		    }
		
		
		
		
            if(!isset($array['image_sets']))
            {
                /*
                    
                    For No Images Files
                    
                */
		
		//Loop of all 'allowed_estentions'
		foreach($array['allowed_estentions'] AS $k_file_ae=>$a_file_ae)
		{
		    $fileToCheck=rootDOC.$array['upload_path'].$NAME_FILE.$a_file_ae;
		    if(file_exists($fileToCheck))
		    {
			$r[$k][$a_file_ae]=array(
				'url'=>str_replace(rootDOC,rootWWW,$fileToCheck),
				);
		    }
		    
		}
            }
            else
            { 
                /*
                    Is an Image Set
                    I will check all set
                */
		//pr($array['image_sets']);
                foreach($array['image_sets'] AS $k_image_sets=>$v_image_sets)
                {
                    
                    //$imgToCheck=rootDOC.$array['upload_path'].$NAME_FILE;
                    //echo '<p>'.$imgToCheck.'</p>';
                    //$imgToCheck=$imgToCheck."_".$k_image_sets.$v_image_sets['est'];
                    $imgToCheck=rootDOC.$array['upload_path'].$k_image_sets."/".$NAME_FILE.$v_image_sets['est'];
		    
		    //echo '<p>'.$imgToCheck.'</p>';
                    if(file_exists($imgToCheck))
                    {
                        //getimagesize
                        list($w, $h) = getimagesize($imgToCheck);
                        /*
                            
                            Update the loop
                            
                        */
                        $r[$k][$k_image_sets]=array(
                            'url'=>str_replace(rootDOC,rootWWW,$imgToCheck),
                            'w'=>$w,
                            'h'=>$h,
                            );
                    }
		    elseif(isset($v_image_sets['default']) && file_exists($v_image_sets['default']) && !isset($settings['no_default_db_files']))
		    {
			/* get file size */
			list($w, $h) = getimagesize($v_image_sets['default']);
			
			$r[$k][$k_image_sets]=array(
                            'url'=>str_replace(rootDOC,rootWWW,$v_image_sets['default']),
                            'w'=>$w,
                            'h'=>$h,
                            );
		    }
		    /*
		    else
		    {
			$r[$k][$k_image_sets]=array(
                            'url'=>$v_image_sets['default'],
                            'w'=>$w,
                            'h'=>$h,
                            );
		    }
		    */
                }
            }
        }
        //pr($r);
    return $r;
    } //end f checkDbFiles
    
    
    
    
    
    
    
    
    
    
    
} // CLOSING :: class _CORE
#####################################
#####################################
#####################################














################################################################################
#### OLD ONE START HERE !!!
function MY_simplexml_load_file($url)
{
    $result=@simplexml_load_file($url);
    if(!$result)
    {
	throw new Exception('File not open.');
    }
    else
    {
	return $result;
    }
}










function _template($settings=null)
{
global $rootAssoluta;
global $DIR_template;
global $contenuto_pagina;
	if ($settings['_template_']['empty'])
	{
	$aTemplate[]=$contenuto_pagina;
	}
	else
	{
	$aTemplate[]=$rootAssoluta.$DIR_template."head.php";
	$aTemplate[]=$rootAssoluta.$DIR_template."body.php";
	$aTemplate[]=$rootAssoluta.$DIR_template."down.php";
	
	}
return $aTemplate;
}


function makeRedirect($arg)
{
//pr($arg);
	if(!empty($arg['url']))
	{
		if(empty($arg['n'])){$arg['n']=="302";}
		header("Location: ".$arg['url']."",TRUE,$arg['n']);
	}
	else
	{
	//send_err_msg_to_admin(URL_NOW,"HEADER URL MANCANTE",true);
	}


}


class makePagination___STOPPED
{

var $pagSuffDEFAULT="p/";

	function _init($paginate,$url,$pagSuff=null)
	{ 
//pr($paginate);
		if(empty($pagSuff)){$pagSuff=$this->$pagSuffDEFAULT;}
	$settings=array_merge($paginate,array('url'=>$url,'pagSuff'=>$pagSuff));
	return $settings;
	}


	function Indietro($ANCHOR,$settings)
	{ 
	//pr($settings);
		if($settings['indietro'])
		{
			if($settings['indietro']=="1")
			{
			$url=$settings['url'];
			}
			else
			{
			$url=$settings['url'].$settings['pagSuff'].$settings['indietro'];
			}

		$html='<a href="'.$url.'">'.$ANCHOR.'</a>';

		return $html;
		}
	}
	function Avanti($ANCHOR,$settings)
	{
		if($settings['avanti'])
		{
			$url=$settings['url'].$settings['pagSuff'].$settings['avanti'];

		$html='<a href="'.$url.'">'.$ANCHOR.'</a>';

		return $html;
		}
	
	}
	
	function Numeri($settings) 
	{
		for($i=1;$i<=$settings['totPagine'];$i++){
			if($i=="1")
			{
			$url=$settings['url'];
			}
			else
			{
			$url=$settings['url'].$settings['pagSuff'].$i;
			}

			if($i==$settings['pag'])
			{
			$html.=" ".$i." ";
			}
			else
			{
			$html.=" <a href=\"".$url."\">".$i."</a> ";
			}
		}

		return $html;
	}

}





function makeSlugLink($s)
{
	global $rootBase;
	if($s['radice']=="1")
	{
	$url=$rootBase.$s['slug'];
	}
	else
	{
		if(!empty($s['modello']) && !empty($s['comportamento']))
		{
		$url=$rootBase.$s['modello']."/".$s['comportamento']."/".$s['slug'];
		}
		else if(!empty($s['modello']))
		{
		$url=$rootBase.$s['modello']."/".$s['slug'];
		}
		else
		{
		send_err_msg_to_admin("SLUG DATA: ".var_export($s,true),"slug error");
		//
		$url=$rootBase.$s['slug']."#slug_error";
		}
	}
	return $url;
}











function outLogin()
{
unset($_SESSION['login']);
}

function isLogin($gruppoID=null)
{//echo$gruppoID;
//pr($_SESSION['login']);
	if(!empty($gruppoID) && $_SESSION['login']['gruppo']==$gruppoID)
	{
	return true;
	}
	else if(empty($gruppoID) && isset($_SESSION['login']))
	{
	return true;
	}
	else
	{
	return false;
	}
}


function checkLogin___($settings)
{
global $LOGIN_SETTING;

	$PSW=md5($settings['password']);
	$USD=$settings[$LOGIN_SETTING['nome_campo_usr']];
	$nomeCampoIdGruppo="id_".$LOGIN_SETTING['tab_gruppi'];

	$r=_record($LOGIN_SETTING['tab'],$LOGIN_SETTING['nome_campo_usr'],$USD," AND password='".$PSW."' AND bannato='0' AND attivo='1' ",0);
	
	if($r)
	{
	$_SESSION['login']=array('id'=>$r['id'],'id_save'=>$r['id'],'gruppo'=>$r[$nomeCampoIdGruppo]);
	return true;
	}
	else
	{
	return false;
	}
}




function p($a){return "<p>".$a."</p>";}








function addCss($f)
{ global $rootBase;
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$rootBase.$f."\">";
}

function addView($f)
{
//return $rootAssoluta.$f.".php";
return rootCore.$f.".php";
}

function pr($a)
{
//echo '<div style="width:100%;overflow:auto;height:190px;position:absolute;top:0;left:0;color:#000000;background:#ffffff;">';
    if(is_array($a))
    {
    echo "<pre style=\"overflow:auto;height:210px;background-color:#ffffcc;opacity:0.8;filter:alpha(opacity=80);\">";
    print_r($a);
    echo "</pre>";
    }
    else
    {
    echo '<P style="background:#ffffcc;padding:3px;font-size:11px;border:1px #efefef solid;margin:3px;">'.$a.'</P>';
    }
//echo "</div>";
}


function creaCookie($nome,$value,$scadenza=null)
{
	if(empty($scadenza)){$scadenza=time()+311040000;/*imposto la scadenza ad un anno se non impostata*/}
	setcookie($nome,$value,$scadenza,"/");
	return true;
}

function leggiCookie($nome,$debug=null)
{
	if($debug=='1')
	{
	pr($_COOKIE);
	}
	
	if(isset($_COOKIE[$nome]))
	{
	return $_COOKIE[$nome];
	}
	else
	{
	return false;
	}
}



function generatePassword($length=9, $strength=0) {
	$vowels = 'aeuy';
	$consonants = 'b1d2g3h4j5m6n7p8q9r0stvz';
	if ($strength & 1) {
		$consonants .= 'B1D2G3H4J5L6M7N8P9Q0RSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}





function isNotNull($dati)
{
	if(empty($dati))
	{return false;}
	else
	{return true;}

}


function rootBase($arg=null)
{
global $rootBase;
	if($arg['echo']==flase)
	{
	return $rootBase;
	}
	else
	{
	echo $rootBase;
	}
}


function getUrlNow($u)
{
global $rootBase;
if(substr($u,-1)!="/" && !empty($u)){$u=$u."/";}
	$url=$rootBase.$u;
return $url;

}


function trimArray($a)
{

	foreach($a as $chiave=>$valore)
	{
	if($a[$chiave] == '')unset($a[$chiave]);

	}
	return $a;
}



function playMp3($url,$w=null,$h=null)
{
	if(empty($w))$w="100%";
	if(empty($h))$h="30";
$player='<embed type="application/x-shockwave-flash" flashvars="audioUrl='.$url.'" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="'.$w.'" height="'.$h.'" quality="best"></embed>';
return $player;

}


function is_time ($str)
{
  $month = date( 'm', $str ); 
  $day   = date( 'd', $str ); 
  $year  = date( 'Y', $str ); 

  if (checkdate($month, $day, $year)) 
  { 
     return TRUE; 
  } 
  
  return FALSE; 

}

function is_date( $str ) 
{ 
  $stamp = strtotime( $str ); 
  
  if (!is_numeric($stamp)) 
  { 
     return FALSE; 
  } 
  $month = date( 'm', $stamp ); 
  $day   = date( 'd', $stamp ); 
  $year  = date( 'Y', $stamp ); 
  
  if (checkdate($month, $day, $year)) 
  { 
     return TRUE; 
  } 
  
  return FALSE; 
} 



function slug($str)
{

	$str=strtolower($str);
	$str=str_replace("'","-",$str);
	
		$vocali=array('a','e','i','o','u');
		$caratteri=array('grave','acute','circ','tilde','uml','ring');
		for($i=0;$i<count($vocali);$i++){
			for($ii=0;$ii<count($caratteri);$ii++){
			$str = str_replace("&".$vocali[$i].$caratteri[$ii].";",$vocali[$i],$str);
			}
		}

	$str = html_entity_decode($str);
	$str = strtolower(trim($str));
	$str = preg_replace('/[^a-z0-9-]/', '-', $str);
	$str = preg_replace('/-+/', "-", $str);


	if(substr($str,-1)=="-")$str=substr($str,0,-1);
	if(substr($str,0,1)=="-")$str=substr($str,1);
	return $str;
}



function paginate_data($dati,$perPagina,$pagCorrente=false)
{
$paginate_data=array();
$p_data['totRecord']=count($dati);
$p_data['totPagine']=ceil($p_data['totRecord'] / $perPagina);
$p_data['pagCorrente'] = (!$pagCorrente) ? 1 : (int)$pagCorrente; 

return $p_data;
}


function paginate($dati,$perPagina,$pagCorrente=false)
{
//recupero i dati
$p_data=paginate_data($dati,$perPagina,$pagCorrente);
$totRecord=$p_data['totRecord'];
$totPagine=$p_data['totPagine'];
$paginaCorrente=$p_data['pagCorrente'];

if($totPagine!="1")
{

	//echo '<p>perPagina:'.$perPagina.'</p>';
	//echo '<p>totRecord:'.$totRecord.'</p>';
	//echo '<p>totPagine:'.$totPagine.'</p>';
	//echo '<p>paginaCorrente:'.$paginaCorrente.'</p>';
	

	for($i=0;$i<=$totPagine;$i++)
	{
		if($i=="0")
		{
		$datiPaginate[$i]="";
		}
		else
		{
		//echo '<p>pag '.$i.'</p>';
			//range dei record
			$endR = $perPagina*$i;
			$startR=$endR-$perPagina;
			unset($memDATI);
			$memDATI=array();
			//echo '<p>end:'.$endR.' - RstartR:'.$startR.'</p>';
			for($ii=$startR;$ii<$endR;$ii++)
			{
				if(!empty($dati[$ii]))
				{
				//echo '<p>record '.$ii.'</p>';
				$memDATI[]=$dati[$ii];
				}

			}
			
			$datiPaginate[$i]=$memDATI;
		}
	}
	//echo "?".$paginaCorrente;
	$pag_precedente=($paginaCorrente==1) ? 0 : ($paginaCorrente-1);
	$pag_successiva=($paginaCorrente==$p_data['totPagine']) ? 0 : ($paginaCorrente+1);

//pr($datiPaginate[2]);
$dati['dati']=$datiPaginate[$paginaCorrente];
$dati['indietro']=$pag_precedente;
$dati['avanti']=$pag_successiva;
$dati['totRecord']=$p_data['totRecord'];
$dati['totPagine']=$p_data['totPagine'];
$dati['pag']=$paginaCorrente;
}
else
{
$dati=false;
}	

	return $dati;


}



function pulisciDatiArray($a) 
{
$a=trim($a);
$a=stripslashes($a);
$a=addslashes($a);
$a=trim($a);
return $a;
}


function pulisciDati($nome) {
$nome2=$nome;
$nome2=trim($nome2); 
//$nome2=str_replace("\"", "", $nome2);
//$nome2=str_replace("\\", "", $nome2);
//$nome2=str_replace("", "", $nome2);
$nome2=stripslashes($nome2);
$nome2=addslashes($nome2);
$nome2=trim($nome2);

return $nome = $nome2;
}




function dirToArray($directory,$tipo="directory")
{
//$tipo= directory,file,all

 if ($handle = opendir($directory))
 {
  while ($file = readdir($handle))
  {
   if (is_dir($directory."/".$file))
   {
    if ($file != "." & $file != "..") $dirs[] = $file;
   }
  else
  {
  if ($file != "." & $file != "..") $files[] = $file;
  }
 }
}

closedir($handle);

$all=array();


	if($tipo=="directory")
	{
	return $dirs;
	}
	else if($tipo=="file")
	{
	return $files;
	}
	else if($tipo=="all")
	{
	return $all;
	}

}




function send_err_msg_to_admin($url,$msg)
{
global $emailAdmin;
global $emailDefault;
global $nomeSito;
global $attivaAlertError;

$URL_PAG='http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; 
$REFERER=$_SERVER['HTTP_REFERER']; 
$IP=$_SERVER['REMOTE_ADDR'];
$MSG =$msg."\n"."\n";
$MSG.='URL: '.$URL_PAG.''."\n";
$MSG.='[]: '.$url.''."\n"."\n";
$MSG.='REFERER: '.$REFERER.''."\n";
$MSG.='IP: '.$IP.''."\n";


	if($attivaAlertError)
	{
$to      = $emailAdmin;
$subject = 'ERROR ALERT: '.$nomeSito." - ".time();
$message = $MSG;
$headers = 'From: '.$emailDefault.'' . "\r\n" .
    'Reply-To: '.$emailDefault.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
	}

}




function save_array($a,$m="put")
{
	if($m=="put")
	{
	$a = base64_encode( serialize($a) );
	}
	else if($m=="get")
	{
	$a = unserialize( base64_decode($a) );
	}
return $a;
}



/*
	foreach($a as $k=>$v)
	{
		$ADD_start="";
		$ADD_end="";

		$v2=$v;
		$v2=str_replace("<!--","",$v2);
		$v2=str_replace("-->","",$v2);
		$v2=str_replace(" ","",$v2);
		if(substr($v2,0,5)=="link:")
		{ 
		$v2=str_replace("link:","",$v2); 
		$ADD_start='<a href="';
		$ADD_end='">';
		}


	$nomevar=$v2; 
	$NEW_STRING=$ADD_start.$$nomevar.$ADD_end;
	// ... [] ... [] ...
	$template=str_replace($v,$NEW_STRING,$template); 
	}



*/

function arrayMerge($a,$a_add)
{
    if(is_array($a))
    {
    $a=array_merge($a,$a_add);
    }
    else
    {
    $a=array($a_add);
    }
    return $a;
}







function _pathValidate_DEPRECATED($a)
{
    $note= '<pre style="font-size:19px;">
    Sono in _core.php
    alla function pathValidate
    
    Devo fare:
    
    1. Conto i "child"
    Se sono maggiori del PATH[N] totale
    C\'&egrave; qualcosa che non va! -> 404
    
    2. devo verificare che ci sia un child LOOP sino al numero indicato,
    se non C\'&egrave; -> 404
    
    3. adesso, se ho i numeri corretti
    devo verificare:
	- i nomi delle variabili
	- i valori con le funzioni associate
	- anche tener conto di allow e not se ci sono
    
    
    </pre>';
    //echo $note;


/* split getAllowed */

$number_of_child="0";
foreach($a['getAllowed'] as $k=>$v)
{
    //pr($v);
    $name_of_getAllowed[]=$k;
    if(!empty($v['child_of'])) {
	$number_of_child++;
	$child_array[]=$v['child_of'];
    }
}
	

/* SPLIT Key & Value of PATH*/

    $PATH=$a['PATH'];
    if(!IS_HOME) { unset($PATH[0]); $PATH=array_values($PATH); }
for($i=1;$i>0;$i++){
//echo'<p>'.$i.'</p>';

    $PATH=array_values($PATH);
    //pr($PATH);

    for($ii=0;$ii<count($PATH);$ii++)
    {

	$PATH_K[]=$PATH[0];
	//If is not a key whit no value i take and delete the value (next item)
	    echo '<p>'.$PATH[0].'</p>';
	    if($a['getAllowed'][$PATH[0]]['validate']!="is_only_set" && !empty($PATH[1]))
	    {
	    $PATH_V[$PATH[$ii]]=$PATH[1];
	    unset($PATH[1]);
	    }
	unset($PATH[0]);

	
        
        
    //break;
    }
    if(count($PATH)=="0")
    {
	break;
    }
	
	
}
    echo '<p>- PATH_K</p>';
    pr($PATH_K);
    echo '<p>- PATH_V</p>';
    pr($PATH_V);
    $path=$PATH_K;//$a['PATH'];
    //pr($a['PATH']);
	
	
	
	
	
	
	
	
	
	$totPath=count($path)-1;
	$firstPath=$path[1];
	if(IS_HOME) $totPath=count($path);
	if(IS_HOME) $firstPath=$path[0];

	//Check for duplicated key in child array
	if(is_array($child_array))
	{
	$child_array_count_value=array_count_values($child_array);	
	//pr($child_array_count_value);
	$child_repetition_max=max($child_array_count_value);
	//echo $child_repetition_max;
	}
	
	
	//echo '<p>totPath: '.$totPath.'</p>';
	//echo '<p>number_of_child: '.$number_of_child.'</p>';
	//echo '<p>child_repetition_max: '.$child_repetition_max.'</p>';
	
	//Number of child & $totPath Must be the same, & no repetition for child!
	if($child_repetition_max>1)
	{
	    //In this case child has a repetition!
	    if(DEBUG){
	    echo '<h1>Error</h1>';
	    echo'var $getAllowed incorrect (child has a repetition)<br />';
	    echo'<i>Class Controller: <b>'.$a['CONTROLLER_CLASS'].'</b></i>';
	    }
	    $a['STATUS']="404";
	}
	elseif($number_of_child>=($totPath-1))
	{
	    //Quantity is correct
	    $path_revers=array_reverse($path);
		
		$START="0"; 
		$STOP=count($path_revers)-1; 
		if(IS_HOME)$STOP=count($path_revers); 
		
	    for($i=$START;$i<$STOP;$i++)
	    {
		//echo''.$path_revers[$i]."<br />";
		/*
		Startin from the last
		
		1. Check if name is correct and is child of previously
		
		*/
		    //If there are more than one var
		    //if($STOP>'1')
		    //{
			//$STOP;
			$rest=$STOP-($i);
			//echo '<P>['.$i.'] CHECK: <b>'.$path_revers[$i].'</b> && rest to check: '.$rest.'</P>';
			
			//CHECK FOR NAME EXISTS
			$var_allow=in_array($path_revers[$i],$name_of_getAllowed);
			
			if(!$var_allow)
			{
			    //The var is not in the $getAllowed ARRAY
			    if(DEBUG){echo'<h1>Error</h1>path not allowed';}
			    $a['STATUS']="404";
			}
			else
			{
			    $a['STATUS']="201";
			    
			    //$NAME_OF_CHILD=$path_revers[$i];
			    //echo '<p>@'.$path_revers[$i].'</p>';
				
				$count=1;
			    for($ii=($i);$ii<($STOP);$ii++)
			    {
				//if($path_revers[$i]!=$path_revers[$ii])
				if($count=="2" && $path_revers[$i]!=$firstPath)
				{
				//echo '<p>is '.$path_revers[$i].' child of '.$path_revers[$ii].'</p>';
				    if($a['getAllowed'][$path_revers[$i]]['child_of']!=$path_revers[$ii])
				    {
					if(DEBUG){echo'<h1>Error</h1>path not allowed';}
					$a['STATUS']="404";
				    }
				}
				$count++;
				
				
			    }
			}
			
		    //}
	    }	
	    
	}
	else
	{
	    if(DEBUG){echo'<h1>Error</h1>path not allowed';}
	    $a['STATUS']="404";
	}
	

    return $a;
}



































############################################################################
###
### email class
###
############################################################################

class _email
{

var $TITLE_EMAIL="titolo email";
var $rootBase="http://www.sito.tld";
var $nomeSito=nomeSito;
var $BODY_EMAIL="testo email";




#######################################################################################à
### parseEmailTemplateData
function parseEmailTemplateData($a,$template,$dati=null)
{
global $rootBase;
//pr($dati);
//echo "<textarea style='width:300px;'>".$template."</textarea><br />";
//pr($a);
	foreach($a as $k=>$v)
	{
	//echo'<p>'.$k.'->'.htmlentities($v).'</p>';
		$ADD_start="";
		$ADD_end="";

		$v2=$v;
		$v2=str_replace("<!--","",$v2);
		$v2=str_replace("-->","",$v2);
		$v2=str_replace(" ","",$v2);
		if(substr($v2,0,5)=="link:")
		{ 
		$v2=str_replace("link:","",$v2); 
		$ADD_start='<a href="';
		$ADD_end='">';
		}
	// se la var è nell'array dei dati la prendo da li
	//echo'<p>'.$k.'->'.htmlentities($v2).'</p>';
	if(!empty($dati[$v2])) 
	{
	$varValue=$dati[$v2];
	}
	else
	{
	//altirmenti metto il default della classe...
	$varValue=$this->$v2;
	}
		
	$NEW_STRING=$ADD_start.$varValue.$ADD_end;
	### ... [] ... [] ... 
	### echo htmlentities($v).'<input value="'.htmlentities($NEW_STRING).'" style="width:300"><br/>';
	$template=str_replace($v,$NEW_STRING,$template); 
	
	
	
	$template=str_replace("<!-- rootBase -->",$rootBase,$template); 
	
	}
return $template;
}







######################################################################################################
### parseEmailTemplate
function parseEmailTemplate($template,$dati=null)
{
global $lang;
global $dir_VIEWS;
global $dir_COMPONENTI;
#######################à
### PHP5 
//if(PHP5)
if($PHP5_NOT_NOW)
{
include($dir_COMPONENTI."html_parsing/PHP5_simple_html_dom.php");
$html = str_get_html($template);

    $variabili = array();
    // Find all tags 
    foreach($html->find($tagname) as $element) {
        $variabili[] = $element->plaintext;
    }
//pr($variabili);
}
else
{
#############################
### PHP4
global $rootCore;
$dir_COMPONENTI=$rootCore."components/";
include_once ($dir_COMPONENTI."html_parsing/phphtmlparser_php4/src/htmlparser.inc");

$parser = new HtmlParser($template);
    while ($parser->parse()) {
	//$var=array();
	if($parser->iNodeName=="Comment")
	{
	//echo'<p>'.htmlentities($parser->iNodeValue).'</p>';
	$a[]=$parser->iNodeValue;
	}
        //echo "Node type: " . $parser->iNodeType . "<br/>";
        //echo "Node name: " . $parser->iNodeName . "<br/>";
        //echo "Node value: " . $parser->iNodeValue . "<br/>";
    }
}

//return $a;
	return $this->parseEmailTemplateData($a,$template,$dati);

}





#################################################################################################
### sendSmtpEmail
function sendSmtpEmail($SMTP_DATA,$destinatari,$dati,$template=null,$allegati=null)
{

//pr($dati);

 if(class_exists("PHPMailer"))
 {
global $lang;
global $dir_VIEWS;
global $dir_COMPONENTI;

//organizzo i dati:

//pr($SMTP_DATA);


$ogettoMAIL=$dati['TITLE_EMAIL'];

//set value data
if(empty($EMAIL_mittente))$EMAIL_mittente=$SMTP_DATA['mittente'];
if(empty($NOME_mittente))$NOME_mittente=$SMTP_DATA['mittente_nome'];
if(empty($ogettoMAIL))$ogettoMAIL=$lang['oggettoMailDefault']." ".nomeSito."";

//template
if(empty($template))$template="default.html";

    if(empty($dir_VIEWS)) $dir_VIEWS=rootDOC."_views/";
	if($template!="no-template")
	{
	$template=$dir_VIEWS."_email/".$template;
	$template=file_get_contents($template); 
	}
//$msg

//$testoMAIL=str_replace("");

### eseguo parsin dei tag <!-- -->
	    
	if($template!="no-template")
	{
	$testoMAIL=$this->parseEmailTemplate($template,$dati);
	}
	else
	{
	$testoMAIL=$dati['BODY_EMAIL'];
	}







 $mail                = new PHPMailer(); 
 $mail->IsSMTP(); // telling the class to use SMTP 
 $mail->Host          = $SMTP_DATA['server'];

if($SMTP_DATA['SMTPSecure'])
{
$mail->SMTPSecure = $SMTP_DATA['SMTPSecure']; 
}

 $mail->SMTPAuth      = true;                  // enable SMTP authentication
 $mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
 $mail->Host          = $SMTP_DATA['server']; // sets the SMTP server

if($SMTP_DATA['Port'])
{
$mail->Port = $SMTP_DATA['Port']; 
}

 $mail->Username      = $SMTP_DATA['username']; // SMTP account username
 $mail->Password      = $SMTP_DATA['password'];        // SMTP account password
 $mail->From       = $EMAIL_mittente; 
 $mail->FromName   = $NOME_mittente; 
 $mail->IsHTML(true); 
 $mail->Subject       = $ogettoMAIL; 
 $mail->Body    = $testoMAIL; 


if(!empty($allegati))
{
foreach($allegati as $k=>$allegato)
{
 $mail->AddAttachment($allegato);      // attachment
}
}

foreach($destinatari as $k=>$email)
{
 $mail->AddAddress($email); 
}


  if(!$mail->Send()) { 
   if(DEBUG_ON) echo "<h3>Mailer Error: " . $mail->ErrorInfo."</h3>";
  return false;

  }
  else
  {
  return true;
  }
 }
 else
 {
  if(DEBUG_ON) echo "<h3>la classe PHPMailer non esisite</h3>";
 return false;

 }
}

}





function GetPageRank($q,$host='toolbarqueries.google.com',$context=NULL) {
	$seed = "Mining PageRank is AGAINST GOOGLE'S TERMS OF SERVICE. Yes, I'm talking to you, scammer.";
	$result = 0x01020345;
	$len = strlen($q);
	for ($i=0; $i<$len; $i++) {
		$result ^= ord($seed{$i%strlen($seed)}) ^ ord($q{$i});
		$result = (($result >> 23) & 0x1ff) | $result << 9;
	}
	$ch=sprintf('8%x', $result);
	$url='http://%s/tbr?client=navclient-auto&ch=%s&features=Rank&q=info:%s';
	$url=sprintf($url,$host,$ch,$q);
	@$pr=file_get_contents($url,false,$context);
	return $pr?substr(strrchr($pr, ':'), 1):false;
}







#
#http://www.alexpoole.name/seo/155/simple-php-article-spinner
#
function spin_easy($txt){

$test = preg_match_all("#\{(.*?)\}#", $txt, $out);

if (!$test) return $txt;

$toFind = Array();
$toReplace = Array();

foreach($out[0] AS $id => $match){
$choices = explode(”|”, $out[1][$id]);
$toFind[]=$match;
$toReplace[]=trim($choices[rand(0, count($choices)-1)]);
}

return str_replace($toFind, $toReplace, $txt);
}







#
#http://www.paul-norman.co.uk/2009/06/spin-text-for-seo/comment-page-1/#comment-519
#
function spin($string, $seedPageName = true, $openingConstruct = '{{', $closingConstruct = '}}', $separator = '|')
{
    # If we have nothing to spin just exit
    if(strpos($string, $openingConstruct) === false)
    {
        return $string;
    }

    # Find all positions of the starting and opening braces
    $startPositions = strpos_all($string, $openingConstruct);
    $endPositions   = strpos_all($string, $closingConstruct);

    # There must be the same number of opening constructs to closing ones
    if($startPositions === false OR count($startPositions) !== count($endPositions))
    {
        return $string;
    }

    # Optional, always show a particular combination on the page
    if($seedPageName)
    {
        mt_srand(crc32($_SERVER['REQUEST_URI']));
    }

    # Might as well calculate these once
    $openingConstructLength = mb_strlen($openingConstruct);
    $closingConstructLength = mb_strlen($closingConstruct);

    # Organise the starting and opening values into a simple array showing orders
    foreach($startPositions as $pos)
    {
        $order[$pos] = 'open';
    }
    foreach($endPositions as $pos)
    {
        $order[$pos] = 'close';
    }
    ksort($order);

    # Go through the positions to get the depths
    $depth = 0;
    $chunk = 0;
    foreach($order as $position => $state)
    {
        if($state == 'open')
        {
            $depth++;
            $history[] = $position;
        }
        else
        {
            $lastPosition   = end($history);
            $lastKey        = key($history);
            unset($history[$lastKey]);

            $store[$depth][] = mb_substr($string, $lastPosition + $openingConstructLength, $position - $lastPosition - $closingConstructLength);
            $depth--;
        }
    }
    krsort($store);

    # Remove the old array and make sure we know what the original state of the top level spin blocks was
    unset($order);
    $original = $store[1];

    # Move through all elements and spin them
    foreach($store as $depth => $values)
    {
        foreach($values as $key => $spin)
        {
            # Get the choices
            $choices = explode($separator, $store[$depth][$key]);
            $replace = $choices[mt_rand(0, count($choices) - 1)];

            # Move down to the lower levels
            $level = $depth;
            while($level > 0)
            {
                foreach($store[$level] as $k => $v)
                {
                    $find = $openingConstruct.$store[$depth][$key].$closingConstruct;
                    if($level == 1 AND $depth == 1)
                    {
                        $find = $store[$depth][$key];
                    }
                    $store[$level][$k] = str_replace_first($find, $replace, $store[$level][$k]);
                }
                $level--;
            }
        }
    }

    # Put the very lowest level back into the original string
    foreach($original as $key => $value)
    {
        $string = str_replace_first($openingConstruct.$value.$closingConstruct, $store[1][$key], $string);
    }

    return $string;
}

# Similar to str_replace, but only replaces the first instance of the needle
function str_replace_first($find, $replace, $string)
{
    # Ensure we are dealing with arrays
    if(!is_array($find))
    {
        $find = array($find);
    }

    if(!is_array($replace))
    {
        $replace = array($replace);
    }

    foreach($find as $key => $value)
    {
        if(($pos = mb_strpos($string, $value)) !== false)
        {
            # If we have no replacement make it empty
            if(!isset($replace[$key]))
            {
                $replace[$key] = '';
            }

            $string = mb_substr($string, 0, $pos).$replace[$key].mb_substr($string, $pos + mb_strlen($value));
        }
    }

    return $string;
}

# Finds all instances of a needle in the haystack and returns the array
function strpos_all($haystack, $needle)
{
    $offset = 0;
    $i      = 0;
    $return = false;
   
    while(is_integer($i))
    {   
        $i = mb_strpos($haystack, $needle, $offset);
       
        if(is_integer($i))
        {
            $return[]   = $i;
            $offset     = $i + mb_strlen($needle);
        }
    }

    return $return;
}









function clean_spin_tags($txt,$openingConstruct = '{{', $closingConstruct = '}}', $separator = '|')
{
$txt=str_replace($openingConstruct,"",$txt);
$txt=str_replace($closingConstruct,"",$txt);
$txt=str_replace($separator,"",$txt);
return $txt;
}


#
#http://www.paul-norman.co.uk/2010/09/php-spinner-updated-spin-articles-for-seo/
#
class Spinner
{
    # Detects whether to use the nested or flat version of the spinner (costs some speed)
    public static function detect($text, $seedPageName = true, $openingConstruct = '{{', $closingConstruct = '}}', $separator = '|')
    {
        if(preg_match('~'.$openingConstruct.'(?:(?!'.$closingConstruct.').)*'.$openingConstruct.'~s', $text))
        {
            return self::nested($text, $seedPageName, $openingConstruct, $closingConstruct, $separator);
        }
        else
        {
            return self::flat($text, $seedPageName, false, $openingConstruct, $closingConstruct, $separator);
        }
    }

    # The flat version does not allow nested spin blocks, but is much faster (~2x)
    public static function flat($text, $seedPageName = true, $calculate = false, $openingConstruct = '{{', $closingConstruct = '}}', $separator = '|')
    {
        # Choose whether to return the string or the number of permutations
        $return = 'text';
        if($calculate)
        {
            $permutations   = 1;
            $return         = 'permutations';
        }

        # If we have nothing to spin just exit (don't use a regexp)
        if(strpos($text, $openingConstruct) === false)
        {
            return $$return;
        }
       
        if(preg_match_all('!'.$openingConstruct.'(.*?)'.$closingConstruct.'!s', $text, $matches))
        {
            # Optional, always show a particular combination on the page
            self::checkSeed($seedPageName);

            $find       = array();
            $replace    = array();

            foreach($matches[0] as $key => $match)
            {
                $choices = explode($separator, $matches[1][$key]);

                if($calculate)
                {
                    $permutations *= count($choices);
                }
                else
                {
                    $find[]     = $match;
                    $replace[]  = $choices[mt_rand(0, count($choices) - 1)];
                }
            }

            if(!$calculate)
            {
                # Ensure multiple instances of the same spinning combinations will spin differently
                $text = self::str_replace_first($find, $replace, $text);
            }
        }

        return $$return;
    }

    # The nested version allows nested spin blocks, but is slower
    public static function nested($text, $seedPageName = true, $openingConstruct = '{{', $closingConstruct = '}}', $separator = '|')
    {
        # If we have nothing to spin just exit (don't use a regexp)
        if(strpos($text, $openingConstruct) === false)
        {
            return $text;
        }

        # Find the first whole match
        if(preg_match('!'.$openingConstruct.'(.+?)'.$closingConstruct.'!s', $text, $matches))
        {
            # Optional, always show a particular combination on the page
            self::checkSeed($seedPageName);

            # Only take the last block
            if(($pos = mb_strrpos($matches[1], $openingConstruct)) !== false)
            {
                $matches[1] = mb_substr($matches[1], $pos + mb_strlen($openingConstruct));
            }

            # And spin it
            $parts  = explode($separator, $matches[1]);
            $text   = self::str_replace_first($openingConstruct.$matches[1].$closingConstruct, $parts[mt_rand(0, count($parts) - 1)], $text);

            # We need to continue until there is nothing left to spin
            return self::nested($text, $seedPageName, $openingConstruct, $closingConstruct, $separator);
        }
        else
        {
            # If we have nothing to spin just exit
            return $text;
        }
    }

    # Similar to str_replace, but only replaces the first instance of the needle
    private static function str_replace_first($find, $replace, $string)
    {
        # Ensure we are dealing with arrays
        if(!is_array($find))
        {
            $find = array($find);
        }

        if(!is_array($replace))
        {
            $replace = array($replace);
        }

        foreach($find as $key => $value)
        {
            if(($pos = mb_strpos($string, $value)) !== false)
            {
                # If we have no replacement make it empty
                if(!isset($replace[$key]))
                {
                    $replace[$key] = '';
                }

                $string = mb_substr($string, 0, $pos).$replace[$key].mb_substr($string, $pos + mb_strlen($value));
            }
        }

        return $string;
    }

    private static function checkSeed($seedPageName)
    {
        # Don't do the check if we are using random seeds
        if($seedPageName)
        {
            if($seedPageName === true)
            {
                mt_srand(crc32($_SERVER['REQUEST_URI']));
            }
            elseif($seedPageName == 'every second')
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].date('Y-m-d-H-i-s')));
            }
            elseif($seedPageName == 'every minute')
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].date('Y-m-d-H-i')));
            }
            elseif($seedPageName == 'hourly' OR $seedPageName == 'every hour')
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].date('Y-m-d-H')));
            }
            elseif($seedPageName == 'daily' OR $seedPageName == 'every day')
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].date('Y-m-d')));
            }
            elseif($seedPageName == 'weekly' OR $seedPageName == 'every week')
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].date('Y-W')));
            }
            elseif($seedPageName == 'monthly' OR $seedPageName == 'every month')
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].date('Y-m')));
            }
            elseif($seedPageName == 'annually' OR $seedPageName == 'every year')
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].date('Y')));
            }
            elseif(preg_match('!every ([0-9.]+) seconds!', $seedPageName, $matches))
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].floor(time() / $matches[1])));
            }
            elseif(preg_match('!every ([0-9.]+) minutes!', $seedPageName, $matches))
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].floor(time() / ($matches[1] * 60))));
            }
            elseif(preg_match('!every ([0-9.]+) hours!', $seedPageName, $matches))
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].floor(time() / ($matches[1] * 3600))));
            }
            elseif(preg_match('!every ([0-9.]+) days!', $seedPageName, $matches))
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].floor(time() / ($matches[1] * 86400))));
            }
            elseif(preg_match('!every ([0-9.]+) weeks!', $seedPageName, $matches))
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].floor(time() / ($matches[1] * 604800))));
            }
            elseif(preg_match('!every ([0-9.]+) months!', $seedPageName, $matches))
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].floor(time() / ($matches[1] * 2620800))));
            }
            elseif(preg_match('!every ([0-9.]+) years!', $seedPageName, $matches))
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].floor(time() / ($matches[1] * 31449600))));
            }
            else
            {
                throw new Exception($seedPageName. ' Was not a valid spin time option!');
            }
        }
    }
}
?>
