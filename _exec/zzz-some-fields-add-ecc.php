<?php
$DO_IT=true;if(!$DO_IT){echo'<p><b>DISATTIVATO</b></p>';exit;}


echo "Dopo aver importato il tutto questo script aggiunge alcuni campi alle tabelle
<br> e delle piccole rifiniture che si sono aggiunte in corso d'oepra.";

$SQL[]="ALTER TABLE  ".$TAB_prodotti." ADD  peso INT NOT NULL DEFAULT  '100' ";    


    //EXEC SQL ARRAY
    exec_SqlArray($SQL);

    