<?php

$DO_RESET=false;

if($DO_RESET)
{
    $STOPALL=true;
    if(!isset($_SESSION['RESETDB']))$_SESSION['RESETDB']=time();
    //pr($_GET['RESETDB']);
    //pr($_SESSION['RESETDB']);
    if($_GET['RESETDB']==$_SESSION['RESETDB']) {pr("AAA".$DB_CONFIG['n']);doResetDb($DB_CONFIG['n']);}
    echo'<div style="background:#dfdfdf;width:540px;font-size:12px;padding:9px;margin:3px;border:5px solid red;border-radius: 9px;-moz-border-radius: 9px;-webkit-border-radius: 9px;">';
    echo '<b style="font-size:15px;">DELETE THE DATABASE?</b></br/>';
    echo 'you are going to delete and reset al the data for the databse: <b>'.$DB_CONFIG['n'].'</b>';
    echo'<br /><a href="?RESETDB='.$_SESSION['RESETDB'].'" onclick="return confirm(\'are you sure?\')" style="font-size:18px;font-weight:bold;margin:5px;padding:5px 3px 3px 3px;text-align:center;display:block;width:50px;background:red;color:#fff;border-radius: 9px;-moz-border-radius: 9px;-webkit-border-radius: 9px;">OK</a>';
    echo'<br />OR SET $DO_RESET=FALSE;';
    echo'</div>';
}


function exec_SqlArray($SQL,$settings=null)
{
    for($i=0;$i<count($SQL);$i++)
    {
    $SETTINGS=array('SQL'=>$SQL[$i],'echo'=>'1');
    dbAction::_shell_query($SETTINGS);
    sleep(1);
    }
}

function doResetDb($DB){
    //pr($DB);
    $TABLES=showTab($DB);
    for($i=0;$i<count($TABLES);$i++)
    {
    $SQL[]="DROP TABLE ".$TABLES[$i];
    }
    //$SQL[]="CREATE DATABASE ".$DB." DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
    //pr($SQL);
    exec_SqlArray($SQL);
    _CORE::redirect(array('location'=>rootWWW."a"));
}