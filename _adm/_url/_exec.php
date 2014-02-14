<?php

if($_GET['ex']!="")
{
    //include();
    //pr("Eseguo: ".$_GET['ex']);
    //_CORE::scriptEX(rootCore."_exec/".$_GET['ex']." -rCore='AAA'");
    //_CORE::scriptEX(rootCore."_exec/".$_GET['ex']);
    //include(rootCore."_exec/".$_GET['ex']);
    $f=rootCore."_exec/".$_GET['ex'];
    $f_www=str_replace(rootCore,rootWWW,$f);
    /*
    $f=rootWWW.$_POST['ex'];
        $COMMANDO="wget -O /dev/null http://www.3ml.it/app/mw_calendar/_cron &";
	shell_exec($COMMANDO);
    */
        
    /**/
    if(file_exists($f))
    {
        echo'<p><b style="color:GREEN;">COMANDO LANCIATO</b><br />'.$f_www.'</p>';
    //launchBackgroundProcess("php ".$f);
    
        $COMMANDO="wget -O /dev/null ".$f_www." &";
	shell_exec($COMMANDO);
    }
    else
    {
        echo'<p><b style="color:red;">ERROR</b></p>';
        pr( '<i>'.rootCore."_exec/".$_GET['ex'].'</i> <u>do not exists</u>');
    }
    
}



?>
<!-- 
<span style="font-size:30px;">
Una buona idea sarebbe quella di rendere eseguibili tutti i file in URL di <strong>A</strong>
con un pre-script che includa i file necessari...
</span>
-->

<form action="" method="get">
<input type="text" name="ex" value="" style="width:550px;">
    <input type="submit" value="ESEGUI">
</form>

<?php
    
    if(!$ALLOW_EXEC)
    {
        echo'
        <div style="width:500px;border:3px solid;background:#ffff00;padding:15px;font-size:21px;text-align:center;">
        VAR $ALLOW_EXEC in /_config/main.php is FALSE
        <br />EXECUTION is disabled!
        </div>
        ';
    }



$F=_CORE::dirToArray(rootCore."_exec/",array('type'=>'file','exclude_files'=>array('.htaccess')));
//pr($F);
sort($F);
foreach($F as $i=>$f)
{
    echo '<p style="margin:3px;padding:5px;font-size:12px;background:#ffffcc;">
    <a href="'.rootWWW."_exec/".$f.'" style="color:blue;" target="_blank"> WWW</a>
    &nbsp; &nbsp;  
    <a href="'.rootWWW."a/url/_exec/?ex=".$f.'"  style="color:green;" title="Execute like a background process">BG-Exec</a>
    &nbsp;  &nbsp;  &nbsp; 
    '.$f.'
    </p>';
}
?>
