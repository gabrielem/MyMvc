<?php

//$DB_CONFIG_FG
$DO_ROUTES=FALSE;
$DO_INSIEMI=FALSE;
$DO_COLLANE=FALSE;
$DO_FOCUS=FALSE;
$DO_HOME_SLIDE=FALSE;

//FALSE
//true

$DO_LIBRI=FALSE;
$DO_CAT=FALSE;
$DO_SOT=FALSE;
$DO_AUTORI=FALSE;
$DO_EDITORI=FALSE;



$TABLES_fg=showTab($DB_CONFIG_FG['n'],array('DB_CONFIG'=>$DB_CONFIG_FG));
//pr($TABLES_fg);
$TABLES=showTab($DB_CONFIG['n']);
//pr($TABLES);







/* ROUTES */
if($DO_ROUTES && !$STOPALL){echo'<h1>DO:ROUTES</h1>';$T="routes"; addTable($T);}
/* INSIEMI */
if($DO_INSIEMI && !$STOPALL){echo'<h1>DO:INSIEMI</h1>';$T="insiemi"; addTable($T);}
/* COLLANE */
if($DO_COLLANE && !$STOPALL){echo'<h1>DO:COLLANE</h1>';$T="collane"; addTable($T);}
/* FOCUS */
if($DO_FOCUS && !$STOPALL){echo'<h1>DO:FOCUS</h1>';$T="focus"; addTable($T);}
/*HOME_SLIDE*/
if($DO_HOME_SLIDE && !$STOPALL){echo'<h1>DO:HOME_SLIDE</h1>';$T="home_slide"; addTable($T);}




if($DO_LIBRI && !$STOPALL){echo'<h1>DO:LIBRI</h1>';
/******************************************************
 *
 *
 *  tab:  LIBRI 
 *
 *
 ******************************************************/
    $TAB_NEW="prodotti";
    $TAB_OLD="libri";
        
    //IMPORTING!
    $SETTINGS=array('TAB_NEW'=>$TAB_NEW,'TAB_OLD'=>$TAB_OLD,'DB_CONFIG_FG'=>$DB_CONFIG_FG,'FILEDS_TO_EXCLUDE'=>array('_NONE_'));
    importTabFG($SETTINGS);
        
        $SQL=array();
        
    //SAVE OLD ID
    $SQL[]="ALTER TABLE  ".$TAB_OLD." MODIFY  id INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_OLD." DROP PRIMARY KEY";
    $SQL[]="ALTER TABLE  ".$TAB_OLD." CHANGE  id id_oldfg INT NOT NULL";
    $SQL[]="ALTER TABLE ".$TAB_OLD." AUTO_INCREMENT = 1";

        
    //RENAME
    $SQL[]="RENAME TABLE ".$TAB_OLD." TO  ".$TAB_NEW."";
    //ADD ID
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
    //UTF-8
    $SQL[]="ALTER TABLE ".$TAB_NEW." DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
    //OTHER
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id_insiemi INT NOT NULL DEFAULT  '1'";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id_insiemi id_insiemi INT( 11 ) NOT NULL DEFAULT  '0'";
    $SQL[]="ALTER TABLE  ".$TAB_NEW."
CHANGE  pagine pagine VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  testo testo MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  testo2  testo2 MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
CHANGE  fornitore  fornitore VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  formato  formato VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
ADD  slug VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
ADD  id_editori INT( 11 ) NULL DEFAULT  '0' AFTER idEditore,
ADD  scontoB2B DECIMAL( 10, 2 ) NOT NULL DEFAULT  '0.00' AFTER  percB2C,
ADD  percB2B INT NOT NULL DEFAULT  '30' AFTER  scontoB2B,
ADD  costo_fissoB2B INT NOT NULL DEFAULT  '30' AFTER  percB2B
";
    


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
    $TAB_OLD="libri_cat";
        
    //IMPORTING!
    $SETTINGS=array('echo'=>true,'TAB_NEW'=>$TAB_NEW,'TAB_OLD'=>$TAB_OLD,'DB_CONFIG_FG'=>$DB_CONFIG_FG,'FILEDS_TO_EXCLUDE'=>array('_NONE_'));
    importTabFG($SETTINGS);
        
        $SQL=array();
        
    //SAVE OLD ID
    $SQL[]="ALTER TABLE  ".$TAB_OLD." MODIFY  id INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_OLD." DROP PRIMARY KEY";
    $SQL[]="ALTER TABLE  ".$TAB_OLD." CHANGE  id id_oldfg INT NOT NULL";
    $SQL[]="ALTER TABLE ".$TAB_OLD." AUTO_INCREMENT = 1";
    
    //RENAME
    $SQL[]="RENAME TABLE ".$TAB_OLD." TO  ".$TAB_NEW."";
    //ADD ID
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
    //UTF-8
    $SQL[]="ALTER TABLE ".$TAB_NEW." DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
    //OTHER
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id_insiemi INT NOT NULL DEFAULT  '1'";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id_insiemi id_insiemi INT( 11 ) NOT NULL DEFAULT  '0'";
    $SQL[]="ALTER TABLE  ".$TAB_NEW."
CHANGE  nome titolo VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  testo testo MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  codice codice VARCHAR( 6 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
ADD  slug VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
";
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
    $TAB_OLD="libri_sot";
        
    //IMPORTING!
    $SETTINGS=array('TAB_NEW'=>$TAB_NEW,'TAB_OLD'=>$TAB_OLD,'DB_CONFIG_FG'=>$DB_CONFIG_FG,'FILEDS_TO_EXCLUDE'=>array('_NONE_'));
    importTabFG($SETTINGS);
        
        $SQL=array();
        
    //SAVE OLD ID
    $SQL[]="ALTER TABLE  ".$TAB_OLD." MODIFY  id INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_OLD." DROP PRIMARY KEY";
    $SQL[]="ALTER TABLE  ".$TAB_OLD." CHANGE  id id_oldfg INT NOT NULL";
    $SQL[]="ALTER TABLE ".$TAB_OLD." AUTO_INCREMENT = 1";
    
    //RENAME
    $SQL[]="RENAME TABLE ".$TAB_OLD." TO  ".$TAB_NEW."";
    //ADD ID
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
    //UTF-8
    $SQL[]="ALTER TABLE ".$TAB_NEW." DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
    //OTHER
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id_insiemi INT NOT NULL DEFAULT  '1'";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id_insiemi id_insiemi INT( 11 ) NOT NULL DEFAULT  '0'";
    $SQL[]="ALTER TABLE  ".$TAB_NEW."
CHANGE  nome titolo VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  testo testo MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  testofg testofg MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  codice codice VARCHAR( 6 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
ADD  slug VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
";
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
    $TAB_OLD="autori_libri";
        
    //IMPORTING!
    $SETTINGS=array('TAB_NEW'=>$TAB_NEW,'TAB_OLD'=>$TAB_OLD,'DB_CONFIG_FG'=>$DB_CONFIG_FG,'FILEDS_TO_EXCLUDE'=>array('_NONE_'));
    importTabFG($SETTINGS);
        
        $SQL=array();
        
    //SAVE OLD ID
    $SQL[]="ALTER TABLE  ".$TAB_OLD." MODIFY  id INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_OLD." DROP PRIMARY KEY";
    $SQL[]="ALTER TABLE  ".$TAB_OLD." CHANGE  id id_oldfg INT NOT NULL";
    $SQL[]="ALTER TABLE ".$TAB_OLD." AUTO_INCREMENT = 1";
        
    //RENAME
    $SQL[]="RENAME TABLE ".$TAB_OLD." TO  ".$TAB_NEW."";
    //ADD ID
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
    //UTF-8
    $SQL[]="ALTER TABLE ".$TAB_NEW." DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
    //OTHER
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id_insiemi INT NOT NULL DEFAULT  '1'";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id_insiemi id_insiemi INT( 11 ) NOT NULL DEFAULT  '0'";
    $SQL[]="ALTER TABLE  ".$TAB_NEW."
CHANGE  testo testo MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
ADD  slug VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
";
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
    $TAB_OLD="editori_libri";
        
    //IMPORTING!
    $SETTINGS=array('TAB_NEW'=>$TAB_NEW,'TAB_OLD'=>$TAB_OLD,'DB_CONFIG_FG'=>$DB_CONFIG_FG,'FILEDS_TO_EXCLUDE'=>array('_NONE_'));
    importTabFG($SETTINGS);
        
        $SQL=array();
        
    //SAVE OLD ID
    $SQL[]="ALTER TABLE  ".$TAB_OLD." MODIFY  id INT NOT NULL";
    $SQL[]="ALTER TABLE  ".$TAB_OLD." DROP PRIMARY KEY";
    $SQL[]="ALTER TABLE  ".$TAB_OLD." CHANGE  id id_oldfg INT NOT NULL";
    $SQL[]="ALTER TABLE ".$TAB_OLD." AUTO_INCREMENT = 1";
        
    //RENAME
    $SQL[]="RENAME TABLE ".$TAB_OLD." TO  ".$TAB_NEW."";
    //ADD ID
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
    //UTF-8
    $SQL[]="ALTER TABLE ".$TAB_NEW." DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
    //OTHER
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  id_insiemi INT NOT NULL DEFAULT  '1'";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id_insiemi id_insiemi INT( 11 ) NOT NULL DEFAULT  '0'";
    $SQL[]="ALTER TABLE  ".$TAB_NEW."
CHANGE  nome nome VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  testo testo MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
ADD  slug VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
";
    //EXEC SQL ARRAY
    exec_SqlArray($SQL);



}











?>