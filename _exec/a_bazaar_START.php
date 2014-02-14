<?php
//$DB_CONFIG_FG
$CODICE2="1";
$INSIEME="3";
//$CODICE2="2";
//$INSIEME="4";
//FALSE
//true
$DO_IMPORT=FALSE;
$DO_BAZAAR=FALSE;
$DO_CAT=FALSE;
$DO_SOT=FALSE;
$DO_AUTORI=FALSE;
$DO_EDITORI=FALSE;

$TABLES_fg=showTab($DB_CONFIG_FG['n'],array('DB_CONFIG'=>$DB_CONFIG_FG));
//pr($TABLES_fg);
$TABLES=showTab($DB_CONFIG['n']);
//pr($TABLES);

if(!$DO_IMPORT){echo'<div style="background-color:yellow;padding:3px;border:5px solid;font-size:50px;margin:10px;">IMPORT TABLE DISABLED</div>';}


if($CODICE2=="1"){echo'<h1 style="background-color:red;font-size:41px;">BAZAAR: CARTA</h1>';}
elseif($CODICE2=="2"){echo'<h1 style="background-color:red;font-size:41px;">BAZAAR: REGALI</h1>';}





if($DO_BAZAAR && !$STOPALL){echo'<h1>DO:BAZAAR</h1>';
/******************************************************
 *
 *
 *  tab:  BAZAAR 
 *
 *
 ******************************************************/
    $TAB_NEW="prodotti";
    $TAB_OLD="bazaar";
        
        //RENAME TABLE in PRODOTTI
        $SQL=array();
    //$SQL[]="RENAME TABLE ".$TAB_OLD." TO  ".$TAB_NEW."";
    $SQL[]="DROP TABLE ".$TAB_NEW."";
    $SQL[]="CREATE TABLE ".$TAB_NEW." AS SELECT * FROM  ".$TAB_OLD." WHERE codice2='".$CODICE2."'";
    //$SQL[]="INSERT ".$TAB_NEW." SELECT * FROM ".$TAB_OLD."";
        
    //SAVE OLD ID
    $SQL[]="ALTER TABLE  ".$TAB_NEW." MODIFY  id INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." DROP PRIMARY KEY";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id id_oldfg INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id_insiemi INT NOT NULL DEFAULT  '".$INSIEME."'";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD slug VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  nome titolo VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  numero nome_n VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  sottotitolo VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER  titolo ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  autore VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER  sottotitolo ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  editore VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER  autore ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  pagine VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER  editore ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD testofg MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER testo2 ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD testo2fg MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER testofg ";
        
        
    $r=dbAction::_exec(array('echo'=>'1','return_result'=>true,'sql'=>"SELECT *  FROM ".$TAB_NEW." ORDER BY id DESC  LIMIT 1 "));
    $row = mysql_fetch_array($r);$Auto_increment = $row['id']+1;
    //echo'<p><b style="color:red;">Auto_increment:'.$Auto_increment.'</b></p>';
        
    $SQL[]="ALTER TABLE ".$TAB_NEW." AUTO_INCREMENT = ".$Auto_increment;
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
        
    $SQL[]="ALTER TABLE  ".$TAB_NEW." MODIFY COLUMN costoB2B DECIMAL( 10, 2 ) NOT NULL DEFAULT  '0.00' AFTER costoB2C ";
        
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  scontoB2B DECIMAL( 10, 2 ) NOT NULL DEFAULT  '0.00' AFTER  percB2C ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  percB2B INT NOT NULL DEFAULT  '30' AFTER  scontoB2B "; 
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  costo_fissoB2B INT NOT NULL DEFAULT  '30' AFTER  percB2B ";
        
    $SQL[]="ALTER TABLE  ".$TAB_NEW." MODIFY COLUMN codice2  tinyint NOT NULL DEFAULT  '0' AFTER imballo ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." MODIFY COLUMN imballoForzato  int NOT NULL DEFAULT  '1' AFTER slug ";
        
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  DATA date NOT NULL DEFAULT  AFTER  codice2 ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  dataora date NOT NULL DEFAULT  AFTER  DATA ";
        
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  sot_ed1  INT NOT NULL DEFAULT  '0' AFTER  vetrinaLIBRAIO ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  sot_ed2  INT NOT NULL DEFAULT  '0' AFTER  sot_ed1 ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  sot_ed3  INT NOT NULL DEFAULT  '0' AFTER  sot_ed2 ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  edizioni_fg  INT NOT NULL DEFAULT  '0' AFTER  sot_ed3 ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  edizioni_lib  INT NOT NULL DEFAULT  '0' AFTER  edizioni_fg ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  sot_ed4  INT NOT NULL DEFAULT  '0' AFTER  edizioni_lib ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  sot_ed5  INT NOT NULL DEFAULT  '0' AFTER  sot_ed4 ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  sot_ed6  INT NOT NULL DEFAULT  '0' AFTER  sot_ed5 ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." 
    ADD idAutore  INT NOT NULL DEFAULT  '0' AFTER  sot_ed6,
    ADD chiaveAutore  INT NOT NULL DEFAULT  '0' AFTER  idAutore,
    ADD nomeAutore  INT NOT NULL DEFAULT  '1' AFTER  chiaveAutore,
    ADD idEditori  INT NOT NULL DEFAULT  '0' AFTER  nomeAutore,
    ADD id_editori  INT NOT NULL DEFAULT  '0' AFTER  idEditori,
    ADD chiaveEditore  INT NOT NULL DEFAULT  '0' AFTER  id_editori,
    ADD nomeEditore  INT NOT NULL DEFAULT  '0' AFTER  chiaveEditore,
    ADD manuali_gratis  INT NOT NULL DEFAULT  '0' AFTER  nomeEditore,
    ADD disponibilita VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER  inhome,
    ADD disponibile  INT NOT NULL DEFAULT  '0' AFTER  disponibilita,
    ADD voto  INT NOT NULL DEFAULT  '0' AFTER  disponibile,
    ADD ristampa  INT NOT NULL DEFAULT  '0' AFTER  voto,
    ADD nuovaedizione  INT NOT NULL DEFAULT  '0' AFTER  ristampa,
    ADD anno_edizione  INT NOT NULL DEFAULT  '0' AFTER  nuovaedizione,
    ADD isbn VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER   anno_edizione,
    ADD formato VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER   isbn,
    ADD remainders  INT NOT NULL DEFAULT  '0' AFTER  formato,
    ADD disponibilein VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER   remainders,
    ADD campo_img VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER   disponibilein,
    ADD durata VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER   campo_img,
    ADD ean VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER   durata,
    DROP inhome_sb
    ";


$FF=showFields(array($TAB_NEW),array('ONLY_FNAME'=>true));//pr($FF);
if(in_array("id_categorie",$FF)){
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id_categorie  INT NOT NULL DEFAULT  '0'";
}

    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  testo testo MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  testo2  testo2 MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL  ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  fornitore  fornitore VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '' ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  disponibilita  disponibilita VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '' ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  anno_edizione  anno_edizione VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '' ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  durata  durata VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '' ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  ean  ean VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '' ";

        exec_SqlArray($SQL,array('DB_CONFIG'=>$DB_CONFIG_FG));
        
        
        
        
    //ADD SOME FILE TO TAB prodotti
        $SQL=array();
    $SQL[]="ALTER TABLE  ".$TAB_NEW."
ADD imballoForzato  INT NOT NULL DEFAULT  '0' AFTER  slug
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
    $TAB_OLD="bazaar_cat";
        
        //RENAME TABLE in PRODOTTI
        $SQL=array();
    //$SQL[]="RENAME TABLE ".$TAB_OLD." TO  ".$TAB_NEW."";
    $SQL[]="DROP TABLE ".$TAB_NEW."";
    $SQL[]="CREATE TABLE ".$TAB_NEW." AS SELECT * FROM  ".$TAB_OLD." WHERE codice2='".$CODICE2."'";
    //$SQL[]="INSERT ".$TAB_NEW." SELECT * FROM ".$TAB_OLD."";
        
    //SAVE OLD ID
    $SQL[]="ALTER TABLE  ".$TAB_NEW." MODIFY  id INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." DROP PRIMARY KEY";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id id_oldfg INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id_insiemi INT NOT NULL DEFAULT  '".$INSIEME."'";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." DROP codice2 ";
        
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
    $TAB_OLD="bazaar_sot";
        
        //RENAME TABLE in PRODOTTI
        $SQL=array();
    //$SQL[]="RENAME TABLE ".$TAB_OLD." TO  ".$TAB_NEW."";
    $SQL[]="DROP TABLE ".$TAB_NEW."";
    $SQL[]="CREATE TABLE ".$TAB_NEW." AS SELECT * FROM  ".$TAB_OLD." WHERE codice2='".$CODICE2."'";
    //$SQL[]="INSERT ".$TAB_NEW." SELECT * FROM ".$TAB_OLD."";
        
    //SAVE OLD ID
    $SQL[]="ALTER TABLE  ".$TAB_NEW." MODIFY  id INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." DROP PRIMARY KEY";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id id_oldfg INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id_insiemi INT NOT NULL DEFAULT  '".$INSIEME."'";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." DROP codice2 ";
        
    $r=dbAction::_exec(array('echo'=>'1','return_result'=>true,'sql'=>"SELECT *  FROM ".$TAB_NEW." ORDER BY id DESC  LIMIT 1 "));
    $row = mysql_fetch_array($r);$Auto_increment = $row['id']+1;
    echo'<p><b style="color:red;">Auto_increment:'.$Auto_increment.'</b></p>';
        
    $SQL[]="ALTER TABLE ".$TAB_NEW." AUTO_INCREMENT = ".$Auto_increment;
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
    
    $SQL[]="ALTER TABLE  ".$TAB_NEW."
CHANGE  nome titolo VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  testo testo MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  testofg testofg MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  codice  codice MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, 
ADD  slug VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
MODIFY COLUMN testoB2B  MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER testo 
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
        
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  novita TINYINT NOT NULL DEFAULT  '0' AFTER testofg ";    
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  testoB2B MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL  AFTER testo ";    
        
    //OTHER
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id_insiemi id_insiemi INT( 11 ) NOT NULL DEFAULT  '0'";


    //EXEC SQL ARRAY
    exec_SqlArray($SQL);
}  































?>