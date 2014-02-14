<?php

/*****************************************************
 *****************************************************
 *****************************************************
 *****************************************************
 *****************************************************
 **
 **
 **     RICONTROLLARE FUNZIONAMNETO
 **     aggiunto valorizzazione del cammpo $B2B
 **
 **     inoltre non c'è per il momento il cambio del campo
 **     
 **     id_utente in id_utenti
 **     
 **
 **
 **
 **
 **
 *****************************************************
 *****************************************************
 *****************************************************/


$DO_IT=FALSE;
$DO_IT=true;
if(!$DO_IT){echo'<p><b>DISATTIVATO</b></p>';exit;}



$TAB_NEW=$TAB_ordini;
$TAB_OLD="ordini2_reduced";
$TAB_PRO=$TAB_prodotti;


echo'<div style="border:1px solid black;padding:9px;margin:5px;background:#ffff55;">
    Questa operazione &egrave; formata da due fasi:<br />
    - IMPORT della vecchia tabella<br />
    - RINNOVO DEI DATI tramite loop. (<b>NECESSITA PRIMA DI AGGIORNAMENTO schema!</b>)
</div>';

//FALSE
//true
$DO_IMPORT=FALSE;$DO_RINNOVO_DATI=FALSE;

$DO_IMPORT=true;$DO_RINNOVO_DATI=FALSE;
//$DO_IMPORT=FALSE;$DO_RINNOVO_DATI=true;



    if($DO_IMPORT && $DO_RINNOVO_DATI)
    {
        echo '<h1 style="color:red;text-align:center;border:30px solid red;padding:15px;margin:5px;">ERRORE: impossibile effettuare $DO_IMPORT & $DO_RINNOVO_DATI assieme </h1>';
        exit;
    }





/**************************************************************
 *
 *
 *      D O  - R I N N O V O
 *
 *
**************************************************************/
if($DO_RINNOVO_DATI && !$STOPALL){echo'<h1>DO:RINNOVO DATI</h1>';


$LIMIT="5000";
$LIMIT="1000";
$TOT='0';
pr("TAB: ".$TAB_NEW);
$l=_loop($TAB_NEW," WHERE ordini_vecchi='1' AND timestamp='0' "," ORDER BY id LIMIT 0, ".$LIMIT."",1,1);
pr($l);
    if($l)
    {
        $TOT=count($l);
        
        for($i=0;$i<count($l);$i++)
        {
            $I=$l[$i];
            
            $items_base=array_filter(explode("|||",$I['dati_carrello']));
            //pr($items_base);
            $items=array();
                
            foreach($items_base as $k=>$v)
            {
                $vA=array_filter(explode("||",$v));
                //pr($vA);
                    if($vA[2]=="libri"){$ADDW=" AND id_insiemi='1'";}
                    elseif($vA[2]=="musica"){$ADDW=" AND id_insiemi='2'";}
                    elseif($vA[2]=="bazaar"){$ADDW=" AND (id_insiemi='3' OR id_insiemi='4')";}
                    
                $r=_record($TAB_PRO,"id_oldfg",$vA[0],$ADDW,"0");
                $items[]=array('id'=>$r['id'],'t'=>'prodotti','qta'=>$vA[1]);
                
            }
            //pr($items);
            //NOW TAKE NEW ID for TAB PRODOTTI where id_insieme...
            
            
            
            
        $dati_carrello_NEW=json_encode($items);
        //pr($I['data_ora']);
        //$format = '%Y-%m-%d %H:%M:%S';
        //$d = strptime($I['data_ora'],$format);
        //pr($d);
        //$timestamp=mktime($d['tm_hour'], $d['tm_min'], $d['tm_sec'], $d['tm_mon'], $d['tm_mday'], $d['tm_year']);
        $dd=explode(" ",$I['data_ora']);
        $d1=explode("-",$dd[0]);
        $d2=explode(":",$dd[1]);
        
        $timestamp=mktime($d2[0], $d2[1], $d2[2], $d1[1], $d1[2], $d1[0]);
        //$timestamp=strtotime($d['tm_year']."-".$d['tm_mon']."-".)
        
        //PR($timestamp);
        //PR(DATE("d-m-Y H.i.s",$timestamp));
            
            //Recovering user data if there are, and set B2B if it is
            $B2B='0';
            pr($I['id_utenti']);
            if($I['id_utenti']!="0" && $I['id_utente']!="")
            {
                $UTENTE=_record($TAB_utenti,"id",$I['id_utente']);
                if($UTENTE['b2b']=='1')
                {
                    $B2B='1';
                }
            }
            
        $Q="UPDATE ".$TAB_NEW." SET timestamp='".$timestamp."', items='".$dati_carrello_NEW."', b2b='".$B2B."' WHERE id='".$I['id']."'";
        //pr($I['id']." ".$Q." - - - ".$I['dati_carrello']);
        //pr($Q);
        $RES=dbAction::_exec(array('sql'=>$Q,'return_result'=>true));
        
        }
    }

//echo $TOT;

    //pr($a['__URL']);
    if($TOT!="0") _CORE::redirect(array('location'=>rootWWW.$a['__URL']));
}























/**************************************************************
 *
 *
 *      D O  - I M P O R T
 *
 *
**************************************************************/

if($DO_IMPORT && !$STOPALL){echo'<h1>DO:IMPORT</h1>';

$SETTINGS=array('TAB_NEW'=>$TAB_NEW,'TAB_OLD'=>$TAB_OLD,'DB_CONFIG_FG'=>$DB_CONFIG_FG,'FILEDS_TO_EXCLUDE'=>array('_NONE_'));
    importTabFG($SETTINGS);
    
    $SQL[]="RENAME TABLE  ".$TAB_OLD." TO  ".$TAB_NEW."";
    $SQL[]="ALTER TABLE ".$TAB_NEW." DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  ordini_vecchi INT NOT NULL DEFAULT  '1'";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." ADD  b2b INT NOT NULL DEFAULT  '0'";
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  ordini_vecchi ordini_vecchi INT( 11 ) NOT NULL DEFAULT  '0'";
    
    $SQL[]="ALTER TABLE  ".$TAB_NEW." CHANGE  id_utente id_utenti INT( 11 ) NOT NULL DEFAULT  '0'";
    
    $SQL[]="ALTER TABLE  ".$TAB_NEW."
CHANGE  dati_carrello dati_carrello MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  sessione  sessione VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  sito_provenienza sito_provenienza VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  ip ip VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  userid userid VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  nome nome VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  cognome cognome VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  email email VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  cf cf VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  iva iva VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  indirizzo indirizzo VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  cap cap VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  provincia provincia VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  citta citta VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  telefono telefono VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  fax fax VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  cellulare cellulare VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  sito_personale sito_personale VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  spedizione spedizione VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  note note MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
CHANGE  caff caff VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
CHANGE  pagamento pagamento VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '',
ADD  timestamp INT( 11 ) NULL DEFAULT  '0' AFTER ip,
ADD  items MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER dati_carrello
";
    exec_SqlArray($SQL);
    
}





