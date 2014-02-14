<?php
//$DB_CONFIG_FG
//FALSE
//true
$DO_IMPORT=FALSE;
$DO_MUSICA=FALSE;
$DO_CAT=FALSE;
$DO_SOT=FALSE;
$DO_AUTORI=FALSE;
$DO_EDITORI=FALSE;

$TABLES_fg=showTab($DB_CONFIG_FG['n'],array('DB_CONFIG'=>$DB_CONFIG_FG));
//pr($TABLES_fg);
$TABLES=showTab($DB_CONFIG['n']);
//pr($TABLES);



if(!$DO_IMPORT){echo'<div style="background-color:yellow;padding:3px;border:5px solid;font-size:50px;margin:10px;">IMPORT TABLE DISABLED</div>';}

if($DO_MUSICA && !$STOPALL){echo'<h1>DO:MUSICA</h1>';
/******************************************************
 *
 *
 *  tab:  MUSICA 
 *
 *
 ******************************************************/
    $TAB_NEW="prodotti";
    $TAB_OLD="musica";
        
        //RENAME TABLE in PRODOTTI
        $SQL=array();
    //$SQL[]="RENAME TABLE ".$TAB_OLD." TO  ".$TAB_NEW."";
    $SQL[]="DROP TABLE ".$TAB_NEW."";
    $SQL[]="CREATE TABLE ".$TAB_NEW." LIKE ".$TAB_OLD."";
    $SQL[]="INSERT ".$TAB_NEW." SELECT * FROM ".$TAB_OLD."";
        
    //SAVE OLD ID
    $SQL[]="ALTER TABLE  ".$TAB_NEW." MODIFY  id INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." DROP PRIMARY KEY";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id id_oldfg INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id_insiemi INT NOT NULL DEFAULT  '2'";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD slug VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ";
        
        
    $r=dbAction::_exec(array('echo'=>'1','return_result'=>true,'sql'=>"SELECT *  FROM ".$TAB_NEW." ORDER BY id DESC  LIMIT 1 "));
    $row = mysql_fetch_array($r);$Auto_increment = $row['id']+1;
    //echo'<p><b style="color:red;">Auto_increment:'.$Auto_increment.'</b></p>';
        
    $SQL[]="ALTER TABLE ".$TAB_NEW." AUTO_INCREMENT = ".$Auto_increment;
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
        
        
    $SQL[]="ALTER TABLE  ".$TAB_NEW."
CHANGE  nome titolo VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
ADD  nome_m VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER  id_old,
ADD  sottotitolo VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER  titolo,
ADD  pagine VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER  editore,

MODIFY COLUMN costoB2B DECIMAL( 10, 2 ) NOT NULL DEFAULT  '0.00' AFTER costoB2C,
ADD  scontoB2B DECIMAL( 10, 2 ) NOT NULL DEFAULT  '0.00' AFTER  percB2C,
ADD  percB2B INT NOT NULL DEFAULT  '30' AFTER  scontoB2B,
ADD  costo_fissoB2B INT NOT NULL DEFAULT  '30' AFTER  percB2B,

ADD  sot_ed1  INT NOT NULL DEFAULT  '0' AFTER  vetrinaLIBRAIO,
ADD  sot_ed2  INT NOT NULL DEFAULT  '0' AFTER  sot_ed1,
ADD  sot_ed3  INT NOT NULL DEFAULT  '0' AFTER  sot_ed2,
ADD  edizioni_fg  INT NOT NULL DEFAULT  '0' AFTER  sot_ed3,
ADD  edizioni_lib  INT NOT NULL DEFAULT  '0' AFTER  edizioni_fg,
ADD  sot_ed4  INT NOT NULL DEFAULT  '0' AFTER  edizioni_lib,
ADD  sot_ed5  INT NOT NULL DEFAULT  '0' AFTER  sot_ed4,
ADD  sot_ed6  INT NOT NULL DEFAULT  '0' AFTER  sot_ed5,
DROP  inhome_video,
ADD  id_editori  INT NOT NULL DEFAULT  '0' AFTER idEditore,
ADD  manuali_gratis  INT NOT NULL DEFAULT  '0' AFTER  nomeEditore,

ADD  isbn VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER  anno_edizione,
ADD  formato VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER  isbn,
ADD  remainders  INT NOT NULL DEFAULT  '0' AFTER  formato,
ADD  disponibilein VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER  remainders,
ADD  campo_img VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER  disponibilein,


CHANGE  testo testo MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  testo2  testo2 MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
CHANGE  fornitore  fornitore VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  disponibilita  disponibilita VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  anno_edizione  anno_edizione VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  durata  durata VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  ean  ean VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  ''
";
        exec_SqlArray($SQL,array('DB_CONFIG'=>$DB_CONFIG_FG));
        
        
        
        
    //ADD SOME FILE TO TAB prodotti
        $SQL=array();
    $SQL[]="ALTER TABLE  ".$TAB_NEW."
ADD  durata VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER  campo_img,
ADD  ean VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER durata
";
        exec_SqlArray($SQL);
    //IMPORTING!
    $SETTINGS=array('TAB_NEW'=>$TAB_NEW,'TAB_OLD'=>$TAB_NEW,'DB_CONFIG_FG'=>$DB_CONFIG_FG,'FILEDS_TO_EXCLUDE'=>array('id'),'DATA_ONLY'=>true);
    if($DO_IMPORT)importTabFG($SETTINGS);
        
        
        //DROP TABLE on OLD DB
        $SQL=array();
        
    $SQL[]="DROP TABLE ".$TAB_NEW;
    if($DO_IMPORT)exec_SqlArray($SQL,array('DB_CONFIG'=>$DB_CONFIG_FG));
        
        $SQL=array();
        
    //OTHER
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id_insiemi id_insiemi INT( 11 ) NOT NULL DEFAULT  '0'";
    //EXEC SQL ARRAY
    exec_SqlArray($SQL);
}   

























if($DO_CAT && !$STOPALL){echo'<h1>DO:CAT</h1>';
/******************************************************
 *
 *
 *  tab:  CAT
 *
 *
 ******************************************************/
    $TAB_NEW="categorie";
    $TAB_OLD="musica_cat";
        
        //RENAME TABLE in PRODOTTI
        $SQL=array();
    //$SQL[]="RENAME TABLE ".$TAB_OLD." TO  ".$TAB_NEW."";
    $SQL[]="CREATE TABLE ".$TAB_NEW." LIKE ".$TAB_OLD."";
    $SQL[]="INSERT ".$TAB_NEW." SELECT * FROM ".$TAB_OLD."";
        
    //SAVE OLD ID
    $SQL[]="ALTER TABLE  ".$TAB_NEW." MODIFY  id INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." DROP PRIMARY KEY";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id id_oldfg INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id_insiemi INT NOT NULL DEFAULT  '2'";
        
    $r=dbAction::_exec(array('echo'=>'1','return_result'=>true,'sql'=>"SELECT *  FROM ".$TAB_NEW." ORDER BY id DESC  LIMIT 1 "));
    $row = mysql_fetch_array($r);$Auto_increment = $row['id']+1;
    //echo'<p><b style="color:red;">Auto_increment:'.$Auto_increment.'</b></p>';
        
    $SQL[]="ALTER TABLE ".$TAB_NEW." AUTO_INCREMENT = ".$Auto_increment;
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
    
    $SQL[]="ALTER TABLE  ".$TAB_NEW."
CHANGE  nome titolo VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  testo testo MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  codice  codice MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, 
ADD  slug VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
";

    //echo'<p><i>add ID</i></p>';
        exec_SqlArray($SQL,array('DB_CONFIG'=>$DB_CONFIG_FG));
        
        
        
        
    //IMPORTING!
    echo'<p><b>IMPORTING</b></p>';
    $SETTINGS=array('TAB_NEW'=>$TAB_NEW,'TAB_OLD'=>$TAB_NEW,'DB_CONFIG_FG'=>$DB_CONFIG_FG,'FILEDS_TO_EXCLUDE'=>array('id'),'DATA_ONLY'=>true);
    if($DO_IMPORT)importTabFG($SETTINGS);
        
        
        //DROP TABLE on OLD DB
        $SQL=array();
    $SQL[]="DROP TABLE ".$TAB_NEW;
        if($DO_IMPORT)exec_SqlArray($SQL,array('DB_CONFIG'=>$DB_CONFIG_FG));
        
        $SQL=array();
        
        
    //OTHER
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id_insiemi id_insiemi INT( 11 ) NOT NULL DEFAULT  '0'";


    //EXEC SQL ARRAY
    exec_SqlArray($SQL);
}   



















if($DO_SOT && !$STOPALL){echo'<h1>DO:SOT</h1>';
/******************************************************
 *
 *
 *  tab:  SOT
 *
 *
 ******************************************************/
    $TAB_NEW="sottocategorie";
    $TAB_OLD="musica_sot";
        
        //RENAME TABLE in PRODOTTI
        $SQL=array();
    //$SQL[]="RENAME TABLE ".$TAB_OLD." TO  ".$TAB_NEW."";
    $SQL[]="CREATE TABLE ".$TAB_NEW." LIKE ".$TAB_OLD."";
    $SQL[]="INSERT ".$TAB_NEW." SELECT * FROM ".$TAB_OLD."";
        
    //SAVE OLD ID
    $SQL[]="ALTER TABLE  ".$TAB_NEW." MODIFY  id INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." DROP PRIMARY KEY";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." DROP dvd";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id id_oldfg INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id_insiemi INT NOT NULL DEFAULT  '2'";
        
    $r=dbAction::_exec(array('echo'=>'1','return_result'=>true,'sql'=>"SELECT *  FROM ".$TAB_NEW." ORDER BY id DESC  LIMIT 1 "));
    $row = mysql_fetch_array($r);$Auto_increment = $row['id']+1;
    echo'<p><b style="color:red;">Auto_increment:'.$Auto_increment.'</b></p>';
        
    $SQL[]="ALTER TABLE ".$TAB_NEW." AUTO_INCREMENT = ".$Auto_increment;
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
    
    $SQL[]="ALTER TABLE  ".$TAB_NEW."
CHANGE  nome titolo VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  testo testo MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  codice  codice MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, 
ADD  slug VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
";

    //echo'<p><i>add ID</i></p>';
        exec_SqlArray($SQL,array('DB_CONFIG'=>$DB_CONFIG_FG));
        
        
        
        
    //IMPORTING!
    echo'<p><b>IMPORTING</b></p>';
    $SETTINGS=array('TAB_NEW'=>$TAB_NEW,'TAB_OLD'=>$TAB_NEW,'DB_CONFIG_FG'=>$DB_CONFIG_FG,'FILEDS_TO_EXCLUDE'=>array('id'),'DATA_ONLY'=>true);
    if($DO_IMPORT)importTabFG($SETTINGS);
        
        
        //DROP TABLE on OLD DB
        $SQL=array();
    $SQL[]="DROP TABLE ".$TAB_NEW;
        if($DO_IMPORT)exec_SqlArray($SQL,array('DB_CONFIG'=>$DB_CONFIG_FG));
        
        $SQL=array();
        
        
    //OTHER
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id_insiemi id_insiemi INT( 11 ) NOT NULL DEFAULT  '0'";


    //EXEC SQL ARRAY
    exec_SqlArray($SQL);
}  























if($DO_AUTORI && !$STOPALL){echo'<h1>DO:AUTORI</h1>';
/******************************************************
 *
 *
 *  tab:  AUTORI
 *
 *
 ******************************************************/
    $TAB_NEW="autori";
    $TAB_OLD="autori_musica";
        
        //RENAME TABLE in PRODOTTI
        $SQL=array();
    //$SQL[]="RENAME TABLE ".$TAB_OLD." TO  ".$TAB_NEW."";
    $SQL[]="DROP TABLE ".$TAB_NEW;
    $SQL[]="CREATE TABLE ".$TAB_NEW." LIKE ".$TAB_OLD."";
    $SQL[]="INSERT ".$TAB_NEW." SELECT * FROM ".$TAB_OLD."";
        
    //SAVE OLD ID
    $SQL[]="ALTER TABLE  ".$TAB_NEW." MODIFY  id INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." DROP PRIMARY KEY";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id id_oldfg INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id_insiemi INT NOT NULL DEFAULT  '2'";
        
    $r=dbAction::_exec(array('echo'=>'1','return_result'=>true,'sql'=>"SELECT *  FROM ".$TAB_NEW." ORDER BY id DESC  LIMIT 1 "));
    $row = mysql_fetch_array($r);$Auto_increment = $row['id']+1;
    echo'<p><b style="color:red;">Auto_increment:'.$Auto_increment.'</b></p>';
        
    $SQL[]="ALTER TABLE ".$TAB_NEW." AUTO_INCREMENT = ".$Auto_increment;
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
    
    $SQL[]="ALTER TABLE  ".$TAB_NEW."
CHANGE  nome nome VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  testo testo MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
ADD  slug VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
";
        exec_SqlArray($SQL,array('DB_CONFIG'=>$DB_CONFIG_FG));
        
/*
    Esec doble for get value in before ready...
*/
// ADD SOLE FIELDS but FIRST CHECK IF THERE ARE!!!
$FF=showFields(array($TAB_NEW),array('DB_CONFIG'=>$DB_CONFIG_FG,'ONLY_FNAME'=>true));
//pr($FF);
if(!in_array("nome2",$FF))
{$SQL[]="ALTER TABLE  ".$TAB_NEW." ADD nome2 VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER nome";}
if(!in_array("cognome",$FF))
{$SQL[]="ALTER TABLE  ".$TAB_NEW." ADD cognome VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER nome2";}
if(!in_array("autori_vari",$FF))
{$SQL[]="ALTER TABLE  ".$TAB_NEW." ADD autori_vari INT NOT NULL DEFAULT  '0' AFTER visibile";}
        
        exec_SqlArray($SQL,array('DB_CONFIG'=>$DB_CONFIG_FG));
        
        
        
        
    //IMPORTING!
    echo'<p><b>IMPORTING</b></p>';
    $SETTINGS=array('TAB_NEW'=>$TAB_NEW,'TAB_OLD'=>$TAB_NEW,'DB_CONFIG_FG'=>$DB_CONFIG_FG,'FILEDS_TO_EXCLUDE'=>array('id'),'DATA_ONLY'=>true);
    if($DO_IMPORT)importTabFG($SETTINGS);
        
        
        //DROP TABLE on OLD DB
        $SQL=array();
    $SQL[]="DROP TABLE ".$TAB_NEW;
        if($DO_IMPORT)exec_SqlArray($SQL,array('DB_CONFIG'=>$DB_CONFIG_FG));
        
        $SQL=array();
        
        
    //OTHER
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id_insiemi id_insiemi INT( 11 ) NOT NULL DEFAULT  '0'";


    //EXEC SQL ARRAY
    exec_SqlArray($SQL);
}






















if($DO_EDITORI && !$STOPALL){echo'<h1>DO:EDITORI</h1>';
/******************************************************
 *
 *
 *  tab:  EDITORI
 *
 *
 ******************************************************/
    $TAB_NEW="editori";
    $TAB_OLD="editori_musica";
        
        //RENAME TABLE in PRODOTTI
        $SQL=array();
    //$SQL[]="RENAME TABLE ".$TAB_OLD." TO  ".$TAB_NEW."";
    $SQL[]="DROP TABLE ".$TAB_NEW;
    $SQL[]="CREATE TABLE ".$TAB_NEW." LIKE ".$TAB_OLD."";
    $SQL[]="INSERT ".$TAB_NEW." SELECT * FROM ".$TAB_OLD."";
        
    //SAVE OLD ID
    $SQL[]="ALTER TABLE  ".$TAB_NEW." MODIFY  id INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." DROP PRIMARY KEY";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id id_oldfg INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id_insiemi INT NOT NULL DEFAULT  '2'";
        
    $r=dbAction::_exec(array('echo'=>'1','return_result'=>true,'sql'=>"SELECT *  FROM ".$TAB_NEW." ORDER BY id DESC  LIMIT 1 "));
    $row = mysql_fetch_array($r);$Auto_increment = $row['id']+1;
    echo'<p><b style="color:red;">Auto_increment:'.$Auto_increment.'</b></p>';
        
    $SQL[]="ALTER TABLE ".$TAB_NEW." AUTO_INCREMENT = ".$Auto_increment;
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
    
    $SQL[]="ALTER TABLE  ".$TAB_NEW."
CHANGE  nome nome VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  testo testo MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
ADD  slug VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
";
        exec_SqlArray($SQL,array('DB_CONFIG'=>$DB_CONFIG_FG));
        
        
        
        
    //IMPORTING!
    echo'<p><b>IMPORTING</b></p>';
    $SETTINGS=array('TAB_NEW'=>$TAB_NEW,'TAB_OLD'=>$TAB_NEW,'DB_CONFIG_FG'=>$DB_CONFIG_FG,'FILEDS_TO_EXCLUDE'=>array('id'),'DATA_ONLY'=>true);
    if($DO_IMPORT)importTabFG($SETTINGS);
        
        
        //DROP TABLE on OLD DB
        $SQL=array();
    $SQL[]="DROP TABLE ".$TAB_NEW;
        if($DO_IMPORT)exec_SqlArray($SQL,array('DB_CONFIG'=>$DB_CONFIG_FG));
        
        $SQL=array();
        
        
    //OTHER
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id_insiemi id_insiemi INT( 11 ) NOT NULL DEFAULT  '0'";


    //EXEC SQL ARRAY
    exec_SqlArray($SQL);
}





















?>