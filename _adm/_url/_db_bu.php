<?php
//_db_bu.php
$DB_DATA=connect(array('bu'=>true));
//pr($DB_DATA);
$BU_dir=rootDOC."_files/db/";
$BU_file=$BU_dir.time().".sql";

if(isset($_GET['del']))
{
unlink($BU_dir.$_GET['del'].".sql");
header("Location: ".rootWWW."".$_GET['url']);exit;
}
if(isset($_GET['SAVE']))
{
$C="mysqldump ".$DB_DATA['n']." >".$BU_file." -u ".$DB_DATA['u']." -p".$DB_DATA['p']."";
//pr($C);
system($C);
header("Location: ".rootWWW."".$_GET['url']);exit;
}

echo '<a href="?SAVE">CREATE <b>DB</b> BACKUP</a>';

echo'<h3>Per sicurezza meglio non lasciare mai copie sul server</h3>';

$BU_dir_WWW=str_replace(rootDOC,rootWWW,$BU_dir);

$files=dirToArray($BU_dir,'file');
//pr($files);
if($files)
{
    foreach($files as $k=>$v)
    {
            
        $TIME=str_replace(".sql","",$v);
        $NAME="File di BackUp creato il: <b>".date("d-m-Y",$TIME)."</b> alle: <b>".date("H:i s",$TIME)."</b>";
        $DEL_URL="?del=".$TIME;
            
        echo'<p style="background:#ffffcc;border:1px solid #afafaf;padding:5px;margin:3px;">
        <a target="_blank" href="'.$BU_dir_WWW.$v.'" style="background:green;color:#ffffff;padding:3px;">SCARICA</a>
        <a href="'.$DEL_URL.'" style="background:red;color:#ffffff;padding:3px;">CANCELLA</a>
        
        '.$NAME.' </p>';
    }
}else{
    echo 'nessun backup trovato';
}
?>