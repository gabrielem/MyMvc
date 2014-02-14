<?php
//

/*
$Mem_A_MODELLI=dirToArray($dir_MODELLI);
$Mem_A_COMPORTAMENTI=dirToArray($dir_COMPORTAMENTI);
$mem ='<?php '."\n";$mem.='$A_MODELLI=array();'."\n";
	for($ii=0;$ii<count($Mem_A_MODELLI);$ii++){$mem.='$A_MODELLI[]="'.$Mem_A_MODELLI[$ii].'";'."\n";}	
$mem.='?>';
$mem2 ='<?php '."\n";$mem2.='$A_COMPORTAMENTI=array();'."\n";
	for($ii=0;$ii<count($Mem_A_COMPORTAMENTI);$ii++){$mem2.='$A_COMPORTAMENTI[]="'.$Mem_A_COMPORTAMENTI[$ii].'";'."\n";}	
$mem2.='?>';
if(write($fileA_MODELLI,$mem) && write($fileA_COMPORTAMENTI,$mem2))
{echo $lang['MSG_ElencoModCompAggiornato'];}
else {echo $lang['MSG_ElencoModCompNonAggiornato'];}
*/


function recursiveChmod ($path, $filePerm=0644, $dirPerm=0755) {
        // Check if the path exists
        if (!file_exists($path)) {
            return(false);
        }
 
        // See whether this is a file
        if (is_file($path)) {
            // Chmod the file with our given filepermissions
            chmod($path, $filePerm);
 
        // If this is a directory...
        } elseif (is_dir($path)) {
            // Then get an array of the contents
            $foldersAndFiles = scandir($path);
 
            // Remove "." and ".." from the list
            $entries = array_slice($foldersAndFiles, 2);
 
            // Parse every result...
            foreach ($entries as $entry) {
                // And call this function again recursively, with the same permissions
                recursiveChmod($path."/".$entry, $filePerm, $dirPerm);
            }
 
            // When we are done with the contents of the directory, we chmod the directory itself
            chmod($path, $dirPerm);
        }
 
        // Everything seemed to work out well, return true
        return(true);
    }






$is_writable_models=is_writable(rootDOC."_models/") ? true : false;
$PERM_models=substr(sprintf('%o', fileperms(rootDOC."_models/")), -4);
$is_writable_controllers=is_writable(rootDOC."_controllers/") ? true : false;
$PERM_controllers=substr(sprintf('%o', fileperms(rootDOC."_controllers/")), -4);
$is_writable_views=is_writable(rootDOC."_views/") ? true : false;
$PERM_views=substr(sprintf('%o', fileperms(rootDOC."_views/")), -4);

//recursiveChmod ($path, $filePerm=0644, $dirPerm=0755);
/*
recursiveChmod (rootDOC."_models/", "0777", "0777");
recursiveChmod (rootDOC."_controllers/", "0777", "0777");
recursiveChmod (rootDOC."_views/", "0777", "0777");
*/



echo'<div style="background:#ffffcc;padding:9px;margin:9px;font-size:11px;">';
if($is_writable_models){
    echo '<p>dir _models is writable ('.$PERM_models.')</p>';
}else{
    echo '<p style="color:red;">dir _models is NOT writable ('.$PERM_models.')</p>';
}

if($is_writable_controllers){
    echo '<p>dir _controllers is writable ('.$PERM_controllers.')</p>';
}else{
    echo '<p style="color:red;">dir _controllers is NOT writable ('.$PERM_controllers.')</p>';
}


if($is_writable_views){
    echo '<p>dir _views is writable ('.$PERM_views.')</p>';
}else{
    echo '<p style="color:red;">dir _views is NOT writable ('.$PERM_views.')</p>';
}
echo'</div>';




if($_POST['ist_name']!="" && !isset($_SESSION['_ist_name_'][$_POST['ist_name']]) ){
//copy(rootCoreModels."_model.php",rootDOC."_models/aaa.php");
/*
    Copio il models
*/
//$M=file_get_contents(rootCoreModels.".model");
//$M=str_replace("ITEMNAME",$_POST['ist_name'],$M);
$M ="<?php "."\n";
$M.='//_models/_all.php'."\n";
$M.="class mod_".$_POST['ist_name']." extends modAll"."\n";
$M.='{'."\n";
$M.='var $includeCoreComponents=array();'."\n";
$M.='var $includeComponents=array();'."\n";
$M.=''."\n";
$M.='    function _beforeInit($a) '."\n";
$M.='    {'."\n";
$M.='        $a=parent::_beforeInit($a);'."\n";
$M.='        $a[\'title\']="";'."\n";
$M.='        $a=$this->_JS($a);'."\n";
$M.='        return $a;'."\n";
$M.='    }'."\n";
$M.=''."\n";
$M.='    function init($a)'."\n";
$M.='    {'."\n";
$M.='        $a=parent::init($a);'."\n";
$M.='        return $a;'."\n";
$M.='    }'."\n";
$M.='    '."\n";
$M.='    function _afterInit($a)'."\n";
$M.='    {'."\n";
$M.='        $a=parent::_afterInit($a);'."\n";
$M.='        return $a;'."\n";
$M.='    }'."\n";
$M.=''."\n";
$M.='    function _JS($a){'."\n";
$M.='        $a[\'JS\']=\'\';'."\n";
$M.='        return $a;'."\n";
$M.='    }'."\n";
$M.=''."\n";
$M.='}'."\n";


mkdir(rootDOC."_models/".$_POST['ist_name']."/", 0777);
file_put_contents(rootDOC."_models/".$_POST['ist_name']."/class.php", $M);

/*
    Copio il controllers
*/
//$C=file_get_contents(rootCoreControllesrs.".controllers");
//$C=str_replace("ITEMNAME",$_POST['ist_name'],$C);

$C ="<?php "."\n";
$C.="//_controllers/initController.php"."\n";
$C.="class c_".$_POST['ist_name']." extends cAll"."\n";
$C.="{"."\n";
$C.='var $getAllowed=array('."\n";
$C.="            '*'=>array('action'=>'getPag','table'=>'TAB_pagine','field'=>'slug',)"."\n";
$C.="            );"."\n";
$C.=""."\n";
$C.='    function _beforeInit($a)'."\n";
$C.="    {"."\n";
$C.='        $a=parent::_beforeInit($a);'."\n";
$C.='        return $a; '."\n";
$C.="    }"."\n";
$C.=""."\n";
$C.="}"."\n";


file_put_contents(rootDOC."_controllers/".$_POST['ist_name'].".php", $C);

/*
    Creo la view
*/
$V="<h1>".$_POST['ist_name']."</h1>";
file_put_contents(rootDOC."_views/".$_POST['ist_name'].".php", $V);

//pr("FILE AGGIORNATI");
$_SESSION['_ist_name_'][$_POST['ist_name']]=true;
//_CORE::_redirect();
}else{




/*

$FFF=rootCoreControllesrs."controllers_empty.php";
$CCC=file_get_contents($FFF);
pr($FFF);
if(file_exists($FFF))
{
echo 'AAA';
}else{echo'NO';}
echo $CCC;
*/
?>

<div style="background:#ffffff;padding:9px;margin:9px;font-size:11px;">
<form action="" method="post">
<p>Inserisci il nome dell'item da creare</p>
<input type="text" name="ist_name" style="padding:5px;width:350px;" />
<input type="submit" />
</form>
</div>

<?php
if(!empty($_SESSION['_ist_name_']))
{
    //pr($_SESSION['_ist_name_']);
    echo'<div style="background:#efefef;padding:9px;margin:9px;">';
    echo "<p>Item creati</p>";
    foreach($_SESSION['_ist_name_'] AS $I=>$v)
    {
        pr($I);
    }
    echo'</div>';
}


}
?>