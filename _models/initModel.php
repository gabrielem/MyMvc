<?php
//_models/init.php
class initModel
{
var $includeCoreComponents=array();
var $includeComponents=array();

    function _beforeInit($a) 
    {
        //pr($a);
        $a['url_mod']=rootWWW."".$a['route']['model']."/";
        return $a; 
    }

    function init($a)
    {
        return $a;
    }
    
    function _afterInit($a)
    {
        return $a;
    }


    
    function _record($a,$settings=null)
    {
        //$settings['add_w'];
        //$settings['set_w'];
        //$settings['echo'];
            if(empty($settings['ID']))
            {
                $settings['ID']=$a['GET_DATA']['upd'];
            }
            
        $a=$this->_record_Exec($a,$settings);
        return $a;
    }
    function _record_Exec($a,$settings)
    {
        $FIELD=$settings['FIELD'];
        $ID=$settings['ID'];
        $add_w=$settings['add_w'];
        $set_w=$settings['set_w'];
        $echo=$settings['echo']; 
            
            
            if(empty($FIELD)) $FIELD="id";
            if(empty($settings['value'])){$settings['value']=$settings['ID'];}
            if(empty($settings['FIELD'])){$settings['FIELD']="id";}
            if(empty($settings['field'])){$settings['field']=$settings['FIELD'];}
            if(empty($settings['tab'])){$settings['tab']=$a['USE_TAB'];}
            
        if(isset($a['TAB2'][$a['USE_TAB']]))$tab2=$a['TAB2'][$a['USE_TAB']];
            
        
        //$aaa=array('tab'=>$a['USE_TAB'],'field'=>$FIELD,'value'=>$ID,'add_w'=>$add_w,'set_w'=>$set_w,'echo'=>$echo);
        //pr($aaa);
        $a['R'][$a['USE_TAB']]=dbAction::_record($settings);
            if($echo){exit;}
        //$a['R'][$a['USE_TAB']]=dbAction::_record(array('tab'=>$a['USE_TAB'],'field'=>$FIELD,'value'=>$ID,'add_w'=>$add_w,'set_w'=>$set_w,'echo'=>$echo));
            if(!$a['R'][$a['USE_TAB']])
            {
                $a['STATUS']="404";
            }
        return $a;
    }
    
    
    function _loop($a,$settings=null)
    {
        
        
        //Set $settings[]
        if(empty($settings))
        {
        $settings['url_pagination']=$a['url_mod'];
        $settings['records_for_pag']="3";
        $settings['current_page']="1";
        $settings['pagSuff']="p";
        //$settings['where']="";
        //$settings['query_recover']=array('q'); //Un array dei valori in get da recuperare e ripassare ad ogni loink della pagizione!
        }
        $a=$this->_loop_Exec($a,$settings);
        return $a;
    }
        
        
    function _loop_Exec($a,$settings=null)
    {
        //Recovering Settings
        //pr($settings);
        if(empty($settings['tab']))
        {
            $settings['tab']=$a['USE_TAB'];
        }
            //pr($settings);
        /*
        $url_pagination=$settings['url_paination'];
        $records_for_pag=$settings['records_for_pag'];
        $current_page=$settings['current_page'];
        $pagSuff=$settings['pagSuff'];
        $where=$settings['where'];
        $query_recover=$settings['query_recover'];
        $orderby=$settings['orderby'];
        $echo=$settings['echo'];
        $settings['']
        */  
        $a['WHERE'][$a['USE_TAB']]=array();
        $a=FILTER_CHECK::setWhere($a);
        /* Make $where sumWhere() FROM $a['WHERE'][{TAB-NAME}] coming from FILTER_CHECK::setWhere */        
        $a['WHERE'][$a['USE_TAB']]=_CORE::sumWhere($a['WHERE'][$a['USE_TAB']],$settings['where']);
            
        $settings['where']=$a['WHERE'][$a['USE_TAB']];
            
        if(isset($a['TAB2'][$a['USE_TAB']]))$settings['tab2']=$a['TAB2'][$a['USE_TAB']];
        //if(isset($settings['tab2'])) $tab2=$settings['tab2'];
            
            
        
        /*
            Set Current Page
            getting the Suffis for Page and check in get data
            
        */
        
        /*
            START
            Add check for using pagination parameter on ?querystring
        */
        $pagSuff=$settings['pagSuff'];
        if(substr($pagSuff,0,1)=="?"){$pagSuff=substr($pagSuff,1);}
        /*  START  */
        
        if(!empty($a['GET_DATA'][$pagSuff])) $settings['current_page']=$a['GET_DATA'][$pagSuff];
	//echo "".$current_page;
        
        /*
            Setting a canonical for page==1
        */
            if($a['GET_DATA'][$pagSuff]=="1")
            {
                /*
                    SETTING METATAGS
                    Avoid to use directly
                    //$a['METATAG']=_CORE::setCanonical($a['url_mod']);
                    and use the function setMetaTags() in _CORE class
                    this method add directly all the tags for the moments
                    in optional 3° vars is true ,overwrite all...
                */
                $a=_CORE::setMetaTags($a,_CORE::setRelCanonical($a['url_mod']),false);
            }
        /*
            
            From Now the loop can RETURN
            $a array if second & optional var is set $A
            it will return automaticaly the array on $a['LOOP'][$a['USE_TAB']]
            and it can provide data for the global array $a
            but, still where is not like this it will continue to work
            
            Compatibility in this case is required from FILTER
            
            
        */
        
        //$a['LOOP'][$a['USE_TAB']]=dbAction::_loop(array('tab'=>$a['USE_TAB'],'tab2'=>$tab2,'where'=>$where,'records_for_pag'=>$records_for_pag,'current_page'=>$current_page,'pagSuff'=>$pagSuff,'url_pagination'=>$url_pagination,'query_recover_pagination'=>$query_recover,'echo'=>0));
        //$a=dbAction::_loop(array('tab'=>$a['USE_TAB'],'tab2'=>$tab2,'where'=>$where,'orderby'=>$orderby,'records_for_pag'=>$records_for_pag,'current_page'=>$current_page,'pagSuff'=>$pagSuff,'url_pagination'=>$url_pagination,'query_recover_pagination'=>$query_recover,'echo'=>$echo),$a);
        $a=dbAction::_loop($settings,$a);  
            
            
            /************************************************************************
                
                U P G R A D E 
                
                ---
                
                S I   P U O '   S P O S T A R E   T U T T I
                Q U E S T I   D A T I   I N   P A G I N A Z I O N E
                
                - Passando l'array globale $a - 
                
            *************************************************************************/
            
            
            //$pagination_data
            if(isset($a['LOOP'][$a['USE_TAB']][0]['pagination_data']))
            {
                $a['pagination_data']=$a['LOOP'][$a['USE_TAB']][0]['pagination_data'];            
                    
                /*
                    If current_page is Bigger than tot_page trow a 404 error
                    And if is not page 1... 
                */
                if(($a['pagination_data']['current_page']!="1" && $a['pagination_data']['current_page']!="") AND $a['pagination_data']['current_page']>$a['pagination_data']['tot_pages'])
                {
                    $a['STATUS']="404";
                }
                
                
                /*
                    Setting noindex for $query_recover if it isset
                */
                if(!empty($a['pagination_data']['query_recover_write']) && isset($_GET[$a['pagination_data']['query_recover_pagination'][0]]))
                {
                $a=_CORE::setMetaTags($a,'<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">',false);    
                }
                
                
                /*
                    
                    Set link rel Next & Prevd 
                    using _CORE::setMetaTags()
                    and _CORE::setRelPrev && _CORE::setRelNext
                    //
                    //pr($a['pagination_data']);
                    //
                */
                if(isset($a['pagination_data']['prev']))
                {
                $a=_CORE::setMetaTags($a,_CORE::setRelPrev($a['pagination_data']['url_prev']),false);
                }
                if(isset($a['pagination_data']['next']))
                {
                $a=_CORE::setMetaTags($a,_CORE::setRelNext($a['pagination_data']['url_next']),false);
                }
                    
                    
                
                
            }
            //pr($a['pagination_data']);
        //pr($a['LOOP'][$a['USE_TAB']]);
        return $a;
    }
    
    
    
    function _afterSAVE($a)
    {
        //echo'1';
        return $a;
    }
    function _beforeSAVE($DATA,$a)
    {
        //echo'1';
        return $DATA;
    }
    
    
    function _insert($a,$settings=null)
    {
        /*
            Setting value for _insert
        */
        $a['NEW']['data']=$this->_beforeSAVE($a['POST_DATA'],$a);
        $a['NEW']['echo']="0";
        //$MSG_INSERT_OK="Record Creato!";
        //$MSG_INSERT_OFF="Errore nella creazione del nuovo record";
        $a['NEW']['MSG_INSERT_OK']="Record Created!";
        $a['NEW']['MSG_INSERT_OFF']="Error, not able to create new records!";
        //$a['NEW']['make_slug_from']="";
        //$a['NEW']['URL_REDIRECT'];
        /*
            Set defauklt settings
        */
        $settings=array(array('action'=>'NEW','tab'=>$a['USE_TAB']));
        $a=$this->_insert_Exec($a,$settings);
        
    return $a;   
    }
        
        
        
    function _insert_Exec($a,$settings=null)
    {
        $a['DB_ACTION']="INSERT";
        /*
            Check settings:
            1. loop the settings and take $ACTION_NEW & $TABLE_NEW
        */ 
            
            
            //pr($settings);
            //pr($a['POST_DATA']);
            for($i=0;$i<count($settings);$i++)
            {
                if(isset($a['POST_DATA'][$settings[$i]['action']]))
                {
                    $ACTION_NEW=$settings[$i]['action'];
                    $TABLE_NEW=$settings[$i]['tab'];
                    break;
                }
            }
    
    
    
    
            /*
            Check if an action is called!
            If so, start with the update process:
                
            1. Set _beforeSAVE() && Set Validation for incoming data, from $TABLE_UPD
                
                # if validation is not ok, (return flase)
                
            2. send errors data    
                
                # else validation is ok means return true 
                
            2. database update 
            3. redirection

                
        */
        if(!empty($ACTION_NEW))
        {
            /*
                
                1. Set Validation for incoming data, from $TABLE_UPD
                
            */
            $DATA=array('USE_TAB'=>$TABLE_NEW,'POST_DATA'=>$a[$ACTION_NEW]['data']);
                
                
                
                /*
                VALIDATION
                */
            $res_validation=VALIDATION::parse($DATA,$a);
            //pr($res_validation);
            //$res_validation['RESULT'];
            /*
                
                # if validation is not ok, (return flase)
                
            */
            if(!$res_validation['RESULT'])
            {
                /*
                     
                    2. send errors data
                        
                    Recovering the $res_validation ARRAY from VALIDATION::parse()
                    init the $a Array with all the error values
                    for using it on the view
                        
                */
                //if(in_array("titolo",$res_validation[err_fields])) echo'AAAAAAA';
                //pr($_POST);
                //pr($res_validation);
                //pr($res_validation['err_fields']);
                $a['err_fields']=$res_validation['err_fields'];
                $a['err_fields_and_msg']=$res_validation['err_fields_and_msg'];
                $a['err_msg_txt']=$res_validation['err_msg_txt'];
                    
                    htmlHelper::setFlash("err",$a['err_msg_txt']);
                    
            }
            else
            {
                /*
                        
                    # else validation is ok means return true 
                        
                        
                    2. database update
                        
                */
                //echo'<h1>2. MAKE DATABASE INSERT</h1>';
                    
                        $tab=$TABLE_NEW;
                        $id=$a[$ACTION_NEW]['id'];
                        $data=$a[$ACTION_NEW]['data'];
                        $where=$a[$ACTION_NEW]['where'];
                        $echo=$a[$ACTION_NEW]['echo'];
                        $make_slug_from=$a[$ACTION_NEW]['make_slug_from'];
                        $MSG_INSERT_OK=$a[$ACTION_NEW]['MSG_INSERT_OK'];
                        $MSG_INSERT_OFF=$a[$ACTION_NEW]['MSG_INSERT_OFF'];
                            
                        //pr($data);
                        $INSERT_RESULT=dbAction::_insert(array('tab'=>$TABLE_NEW,'data'=>$data,'make_slug_from'=>$make_slug_from,'echo'=>$echo));
                        
                    
                /*
                    
                    3. redirection & upload file
                    
                */
                //echo'<h1>3. MAKE REDIRECTION</h1>';
                    
                    /*
                        AnyWay I trow _afterSAVE
                        there must made a check if
                        operation: $a['ID_SAVED']=fasle
                        means ERROR
                    */
                    $a['ID_SAVED']=$INSERT_RESULT;
                    $a=$this->_afterSAVE($a);
                    
                    
                    if($INSERT_RESULT)
                    {
                        
                        
                        /*
                            
                            DEFAULT URL_REDIRECT
                            
                        */
                        if(empty($a[$ACTION_NEW]['URL_REDIRECT'])) $a[$ACTION_NEW]['URL_REDIRECT']=$a['url_mod']."upd/".$INSERT_RESULT."/";
                        
                        
                    $uploadFiles=_CORE::uploadFiles($a,$INSERT_RESULT,$TABLE_NEW);
                        
                        if($uploadFiles['RESULT'])
                        {
                            htmlHelper::setFlash("msg",$MSG_INSERT_OK); 
                            $a[$ACTION_NEW]['RESULT']=$INSERT_RESULT;
                        }
                        else
                        {
                            htmlHelper::setFlash("err",$uploadFiles['ERR_MSG']);
                            $a[$ACTION_NEW]['RESULT']=false;
                        }
                        //
                        
                            if(!$a[$ACTION_NEW]['STOP_REDIRECT']){
                                
                                //echo $a[$ACTION_NEW]['URL_REDIRECT'];
                                echo 'Redirect in corso...';
                                echo'<script language="javascript" type="text/javascript">';
                                echo'window.location.href="'.$a[$ACTION_NEW]['URL_REDIRECT'].'"';
                                echo'</script>';
                                _CORE::redirect(array('location'=>$a[$ACTION_NEW]['URL_REDIRECT']));
                                //header("location: ".$a[$ACTION_NEW]['URL_REDIRECT']);exit;
                                
                                }
                            
                    }
                    else
                    {
                         /*
                            
                            DEFAULT URL_REDIRECT
                            
                        */
                         if(empty($a[$ACTION_NEW]['URL_REDIRECT'])) $a[$ACTION_NEW]['URL_REDIRECT']=$a['url_mod'];
                        
                        //pr($a);
                        htmlHelper::setFlash("err",$MSG_INSERT_OFF);
                        $URL_TO_GO=$a['url_mod'];
                        if(!$a[$ACTION_NEW]['STOP_REDIRECT']){header("location: ".$a[$ACTION_NEW]['URL_REDIRECT']);exit;}
                        $a[$ACTION_NEW]['RESULT']=false;
                    }
                    
            }
        }   
    return $a;
    } //End f _insert_Exec
    
    
    
    
    
    
    function _update($a,$settings=null)
    {
        /*
            Setting value for _update_Exec
        */
        $a['UPD']['id']=$a['POST_DATA']['id'];
        $a['UPD']['data']=$this->_beforeSAVE($a['POST_DATA'],$a);
        $a['UPD']['where']="";
        $a['UPD']['echo']="0";
        $a['UPD']['make_slug_from']="";
        $a['UPD']['MSG_UPDATE_OK']="Data Saved!";
        $a['UPD']['MSG_UPDATE_OFF']="Error, not able to save data!";
        //$a['UPD']['URL_REDIRECT']
        //DEFAULT SETTINGS!
        $settings=array(array('action'=>'UPD','tab'=>$a['USE_TAB']));
            
        $a=$this->_update_Exec($a,$settings);            
        return $a;
    }
    
    function _update_Exec($a,$settings=null)
    {
        $a['DB_ACTION']="UPDATE";
        //pr($a['UPD']);exit;
        
        //
        //pr($settings);
        /*
            Check settings:
            LOOP the settings and take $ACTION_UPD & $TABLE_UPD
        */ 
            for($i=0;$i<count($settings);$i++)
            {
                //pr('?Settato= POST_DATA->'.$settings[$i]['action'].'</p>');
                if(isset($a['POST_DATA'][$settings[$i]['action']]))
                {
                    $ACTION_UPD=$settings[$i]['action'];
                    $TABLE_UPD=$settings[$i]['tab'];
                    break;
                }
            }
                
        /*
            Check if an action is called!
            If so, start with the update process:
                
            1. Set Validation for incoming data, from $TABLE_UPD
                
                # if validation is not ok, (return flase)
                
            2. send errors data    
                
                # else validation is ok means return true 
                
            2. database update 
            3. upload Files & redirection  
        
                
        */
        if(!empty($ACTION_UPD))
        {
            
            /*
                
                1. Set _beforeSAVE && Set Validation for incoming data, from $TABLE_UPD
                
            */
            $DATA=array('USE_TAB'=>$TABLE_UPD,'POST_DATA'=>$a[$ACTION_UPD]['data']);
                
                
                
                /*
                VALIDATION
                */
            //pr($DATA);
            $res_validation=VALIDATION::parse($DATA,$a);
            //pr($res_validation);exit;
                
            //$res_validation['RESULT'];
            /*
                
                # if validation is not ok, (return flase)
                
            */
            if(!$res_validation['RESULT'])
            {
                /*
                     
                    2. send errors data
                        
                    Recovering the $res_validation ARRAY from VALIDATION::parse()
                    init the $a Array with all the error values
                    for using it on the view
                        
                */
                //if(in_array("titolo",$res_validation[err_fields])) echo'AAAAAAA';
                //pr($_POST);
                //pr($res_validation);
                //pr($res_validation['err_fields']);
                $a['err_fields']=$res_validation['err_fields'];
                $a['err_fields_and_msg']=$res_validation['err_fields_and_msg'];
                $a['err_msg_txt']=$res_validation['err_msg_txt'];
                    
                    htmlHelper::setFlash("err",$a['err_msg_txt']);
                    
            }
            else
            {
                /*
                        
                    # else validation is ok means return true 
                        
                        
                    2. database update
                        
                */
                //echo'<h1>2. MAKE DATABASE UPDATE</h1>';
                    
                           
                        $MSG_UPDATE_OK=$a[$ACTION_UPD]['MSG_UPDATE_OK'];
                        $MSG_UPDATE_OFF=$a[$ACTION_UPD]['MSG_UPDATE_OFF'];
                         
                        $tab=$TABLE_UPD;
                        $id=$a[$ACTION_UPD]['id'];
                        $data=$a[$ACTION_UPD]['data'];
                        $where=$a[$ACTION_UPD]['where'];
                        $echo=$a[$ACTION_UPD]['echo'];
                        $make_slug_from=$a[$ACTION_UPD]['make_slug_from'];
                           
                            /*
                                
                                Before Update Save the records for
                                Image rename...
                                
                            */
                                $a_rSave=array('tab'=>$TABLE_UPD,'field'=>'id','value'=>$id,'echo'=>'0');
                                $rSave=dbAction::_record($a_rSave);
                                    
                                //pr($rSave);
                                
                                
                                
                        $UPDATE_RESULT=dbAction::_update(array('tab'=>$TABLE_UPD,'id'=>$id,'data'=>$data,'where'=>$where,'make_slug_from'=>$make_slug_from,'echo'=>$echo));
                            
                            /*
                                Rename dbFiles
                            */
                                
                            _CORE::renameDbFiles($a,$rSave);    
                                //exit;
                            //
                            
                        
                    
                /*
                    
                    3. upload Files & redirection 
                    
                */
                    /*
                        
                        DEFAULT URL_REDIRECT
                        
                    */
                    
                    
                    if(empty($a[$ACTION_UPD]['URL_REDIRECT'])) $a[$ACTION_UPD]['URL_REDIRECT']=$a['url_mod']."upd/".$id."/";
                        //
                        
                    /*
                        AnyWay I trow _afterSAVE
                        there must made a check if
                        operation: $a['ID_SAVED']=fasle
                        means ERROR
                    */
                     
                     $a['ID_SAVED']=$UPDATE_RESULT;
                     $a=$this->_afterSAVE($a);
                        
                     
                    if($UPDATE_RESULT)
                    {
                        
                        //pr("a");exit;
                        
                        /*
                            
                            If _update is sucsefull
                            check for uploads
                            
                            
                            lunch _CORE::uploadFiles() f
                            
                            if is succsefull set ok
                            
                        */
                            
                            $uploadFiles=_CORE::uploadFiles($a,$id,$TABLE_UPD);
                            
                            if($uploadFiles['RESULT'])
                            {
                                htmlHelper::setFlash("msg",$MSG_UPDATE_OK); 
                                $a[$ACTION_UPD]['RESULT']=$id;
                            }
                            else
                            {
                                htmlHelper::setFlash("err",$uploadFiles['ERR_MSG']); 
                                $a[$ACTION_UPD]['RESULT']=false;
                            }
                            if($echo){exit;}
                            if(!$a[$ACTION_UPD]['STOP_REDIRECT']){
                                echo 'Redirect in corso...';
                                echo'<script language="javascript" type="text/javascript">';
                                echo'window.location.href="'.$a[$ACTION_NEW]['URL_REDIRECT'].'"';
                                echo'</script>';
                                
                                header("location: ".$a[$ACTION_UPD]['URL_REDIRECT']);exit;
                            }
                    }
                    else
                    {
                        //pr($a);
                        htmlHelper::setFlash("err",$MSG_UPDATE_ERR);
                        if($echo){exit;}
                        if(!$a[$ACTION_UPD]['STOP_REDIRECT']){
                            echo 'Redirect in corso...';
                                echo'<script language="javascript" type="text/javascript">';
                                echo'window.location.href="'.$a[$ACTION_NEW]['URL_REDIRECT'].'"';
                                echo'</script>';
                            header("location: ".$a[$ACTION_UPD]['URL_REDIRECT']);exit;
                            
                            }
                        $a[$ACTION_UPD]['RESULT']=false;
                    }
                    
            }
        }   
    return $a;
    } //End f _update_Exec()
        
        
        
        
        
        
    function _delete($a,$settings=null)
    {
        //pr($a);
        $a['DEL']['id']=$a['GET_DATA']['del'];
        //$a['DEL']['where']="";
        $a['DEL']['echo']="0";
        $a['DEL']['msg_ok']="Item Deleted";
        $a['DEL']['msg_err']="Item Not Deleted";
        $a['DEL']['URL_REDIRECT']=$a['url_mod'];
        
        $a=$this->_delete_Exec($a,$settings);
            
            
            
        return $a;
    }
        
        
        
        
    function _delete_Exec($a,$settings=null)
    {
            if(empty($a['DEL']['URL_REDIRECT'])) $a['DEL']['URL_REDIRECT']=$a['url_mod'];
            
            
        $del=dbAction::_delete(array('tab'=>$a['USE_TAB'],'id'=>$a['DEL']['id'],'where'=>$a['DEL']['where'],'echo'=>$a['DEL']['echo']));
            
            if($del)
            {
                htmlHelper::setFlash("msg",$a['DEL']['msg_ok']); 
                header("location: ".$a['DEL']['URL_REDIRECT']);exit;
            }
            else
            {
                htmlHelper::setFlash("err",$a['DEL']['msg_err']);
                $a['STATUS']="404";
                //header("location: ".$a['DEL']['URL_REDIRECT']);exit;
            }
        
        return $a;
    }
        
        
        
        
        
}
?>