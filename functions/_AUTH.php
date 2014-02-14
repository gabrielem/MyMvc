<?php
class AUTH
{
    
    function _formTag($TAB)
    {
        global $AUTH_A;
        $ID_AUTH=str_replace("TAB","",$TAB);
        //$AUTH_A[$ID_AUTH];
        
        $generaForm=new generaForm();$generaForm->_formTag($ID_AUTH);
        //echo $generaForm;
    }
    
    function getSetSession($TAB)
    {
        global $AUTH_A;
        $ID_AUTH=str_replace("TAB","",$TAB);
        $AUTH_A[$ID_AUTH];
        global $$AUTH_A[$ID_AUTH]['table_set'];
        $TAB_SET=$$AUTH_A[$ID_AUTH]['table_set'];
        //pr($TAB_SET);
        //pr($_SESSION['AUTH'][$ID_AUTH]);
        return $_SESSION['AUTH'][$ID_AUTH]['id_'.$TAB_SET];
            
    }
    
    
    function isLogin($TAB=null,$settings=null)
    {
        
        if(empty($TAB)) { $TAB=LOGIN_TAB_DEFAULT; }
        global $AUTH_A;
        $ID_AUTH=str_replace("TAB","",$TAB);
        $AUTH_A[$ID_AUTH];
        if($settings['echo'])echo pr($_SESSION['AUTH'][$ID_AUTH]);
        if(isset($_SESSION['AUTH'][$ID_AUTH]))
        {
                $SET_NAME="id".str_replace("TAB","",$AUTH_A[$ID_AUTH]['table_set']);
                if($settings['get_set'])
                {
                    //pr($settings);
                    //pr($AUTH_A[$ID_AUTH]);
                    return $_SESSION['AUTH'][$ID_AUTH][$SET_NAME];
                    //return false;
                }
                if($settings['add_data'])
                {
                    foreach($settings['add_data'] as $k=>$v)
                    {
                        if(!isset($_SESSION['AUTH'][$ID_AUTH][$k]) || $settings['overwrite'])
                        {
                            $_SESSION['AUTH'][$ID_AUTH][$k]=$v;
                        }
                    }   
                }
            if($settings['echo'])echo pr("Y");
            return $_SESSION['AUTH'][$ID_AUTH];
        }
        else
        {
            if($settings['echo'])echo pr("N");
            return false;
        }
        
    }
    
    function checkLoginCookie($a,$ID_AUTH)
    {
        global $AUTH_A;
        
        if(!isset($_COOKIE['AUTH'.$ID_AUTH]))
        {
            return false;
        }
        //echo "AAA";
        //$_COOKIE['AUTH'.$ID_AUTH]
            //$DATA=$_COOKIE['AUTH'.$ID_AUTH];
            $DATA=json_decode(stripslashes($_COOKIE['AUTH'.$ID_AUTH]),true);    
        $settings['AUTH_A']=$AUTH_A;
        $settings['ID_AUTH']=$DATA['id'];
        $settings['LOGIN_ID_SET_field']="id_".$AUTH_A[$DATA['id']]['table_set'];
        $settings['COOKIE']=$DATA;
        
        //pr($settings);
        $return = AUTH::checkLogin($a,$settings);
        //if($return){echo'Y';}
        //else{echo'N';}
        return $return;
        
        
    }
    function checkLogin($a,$settings)
    {
        /*
        $settings
        {
        'AUTH_A',
        'ID_AUTH'
        'LOGIN_TAB' //CAN BE EMPTY
        'LOGIN_ID_SET_field'
        'NAME_SESSION_LOGIN'
        'ID_AUTH_FORM'
        }
        */
        
        
        //pr($a);
        //echo 'AAA';
        //$USR=$a['POST_DATA'][LOGIN_USR_field];
        //$PSW=md5($a['POST_DATA'][LOGIN_PSW_field]);
        //$REDIRECT=$a['POST_DATA'][LOGIN_AD_REDIRECT_input_form];
            
            //pr($settings);
            $AUTH_A_I=$settings['AUTH_A'][$settings['ID_AUTH']];
            //pr($AUTH_A_I);
            
        $ID_AUTH=$settings['ID_AUTH'];
            
        if(empty($settings['LOGIN_TAB'])) {global $$AUTH_A_I['table']; $settings['LOGIN_TAB']=$$AUTH_A_I['table'];}
        $LOGIN_TAB=$settings['LOGIN_TAB'];
        
        //pr("--> ".$LOGIN_TAB);
        
        $LOGIN_TAB_SET=$AUTH_A_I['table_set'];
        $LOGIN_ID_SET_field=$settings['LOGIN_ID_SET_field'];
            
        $LOGIN_USR_field=$AUTH_A_I['usr_field'];
        $LOGIN_PSW_field=$AUTH_A_I['psw_field'];
        $LOGIN_REDIRECT=$AUTH_A_I['redirect_from'];
            
        $LOGIN_AD_WHERE=$AUTH_A_I['add_where'];
            
        $LOGIN_REMEMBER_field=$AUTH_A_I['remember_field'];
        if(empty($LOGIN_REMEMBER_field)) $LOGIN_REMEMBER_field="remember";
        
                
                
            /**************************************************
             *
             *   $psw_crypt_function
             * 
            **************************************************/
                
            $psw_crypt_function=$AUTH_A_I['psw_crypt_function'];
                
                
                
            /*
                
                Set the POST VALUE
                from COOKIE if ther is
                and if FORM is not submit
                
            */
            if($settings['COOKIE'] && empty($a['POST_DATA'][$LOGIN_USR_field]) && empty($a['POST_DATA'][$LOGIN_PSW_field]))
            {
                //echo '<p>COOKIE</p>';
                //pr($settings['COOKIE']);
                //pr($LOGIN_USR_field);
                //pr($LOGIN_PSW_field);
                $IS_COOKIE=true;
                $a['POST_DATA'][$LOGIN_USR_field]=$settings['COOKIE'][$LOGIN_USR_field];
                $a['POST_DATA'][$LOGIN_PSW_field]=$settings['COOKIE'][$LOGIN_PSW_field];
            }
                
                
                
                
                //pr("USR:".$LOGIN_USR_field."->".$a['POST_DATA'][$LOGIN_USR_field]);
            $USR=$a['POST_DATA'][$LOGIN_USR_field];
                
                
            /*
                
                Set PSW an $psw_crypt_function();
                
            */
                //pr("PSW: ".$LOGIN_PSW_field);
                //pr($a['POST_DATA'][$LOGIN_PSW_field]);
            $PSW=$a['POST_DATA'][$LOGIN_PSW_field];
            if(!empty($psw_crypt_function))
            {
                $PSW=$psw_crypt_function($a['POST_DATA'][$LOGIN_PSW_field]);
            }
                
                
            //echo "a".$LOGIN_REMEMBER_field;
            $REMEMBER=$a['POST_DATA'][$LOGIN_REMEMBER_field];
            //echo $REMEMBER;
            
            
            
            
            
        $REDIRECT=$a['POST_DATA'][$LOGIN_REDIRECT];
            
            
            
            
            $REDIRECT_URL=$a['GET_DATA']['url'];
            if(!empty($REDIRECT)) $REDIRECT_URL=rootWWW.$REDIRECT;
            
            
        if(empty($a['route']['login_set'])) $a['route']['login_set']="0"; 
            
            
            
                
            //pr("--> ".$LOGIN_TAB);
            if($a['route']['login_set']!="0")
            {
                $W=" AND ".$LOGIN_PSW_field."='".$PSW."' AND ".$LOGIN_ID_SET_field."='".$a['route']['login_set']."' ".$LOGIN_AD_WHERE;
            }
            else
            {
                $W=" AND ".$LOGIN_PSW_field."='".$PSW."'".$LOGIN_AD_WHERE;
            }
            //pr($_POST);
            //pr($settings);
            //pr($a['route']['login_set']);
            
            
            
            
            $set=false;
            
        if(!empty($USR) && !empty($PSW))
        {
        //pr("check");
        $set=array(
        'echo'=>0,
        'tab'=>$LOGIN_TAB, 
        'field'=>$LOGIN_USR_field, 
        'value'=>$USR, 
        'add_w'=>$W, 
        );
        }
        elseif(!empty($settings['AUTH_FROM_ID']))
        {
        $set=array(
        'echo'=>0,
        'tab'=>$LOGIN_TAB, 
        'value'=>$settings['AUTH_FROM_ID'], 
        );
        }
        
        //pr($set);
        
        if($set){
        //pr($set);
        $r=dbAction::_record($set);
        //pr($r);
        //echo $LOGIN_ID_SET_field;
            if($r)$r['_SET_']=$r[$LOGIN_ID_SET_field];
        //pr($r);exit;
        //exit;
        }
            /*
                R E D O N D A N D
                
                This now is redondand
                becouse add in where
                ...
                
            */
            
            $SET_ALLOW=true;
            if($a['route']['login_set']!="0")
            {
                $SET_ALLOW=false;
                if($a['route']['login_set']==$r[$LOGIN_ID_SET_field])
                {
                    $SET_ALLOW=true;
                }
            }
                
                
                
                if(!empty($settings['SET_msg_login_yes']))$AUTH_A_I['msg_login_yes']=$settings['SET_msg_login_yes'];
                if(!empty($settings['SET_msg_login_no']))$AUTH_A_I['msg_login_no']=$settings['SET_msg_login_no'];
                
                
        if($r && $SET_ALLOW)
        {
                
            $AUTH_RESULT=true;
                
           //echo'OK'; 
        $_SESSION['AUTH'][$settings['ID_AUTH']]=$r;
            
            if(!$IS_COOKIE) htmlHelper::setFlash("msg",__($AUTH_A_I['msg_login_yes']));
            
            if($REMEMBER=="1")
            {
                //echo 'aa';exit;
                $PSW_COOKIE=$r[$LOGIN_PSW_field];
                $ID_AUTH_COOKIE=$settings['ID_AUTH'];
                if(!empty($psw_crypt_function))
                {
                    $PSW_COOKIE=$psw_crypt_function($r[$LOGIN_PSW_field]);
                    $ID_AUTH_COOKIE=$settings['ID_AUTH'];
                }
                $value=json_encode(array($LOGIN_USR_field=>$r[$LOGIN_USR_field],$LOGIN_PSW_field=>$PSW_COOKIE,'id'=>$ID_AUTH_COOKIE));
                $date_exp=time()+80000000;
                setcookie("AUTH".$ID_AUTH,$value,$date_exp,"/");
            }
            else
            {
                /*
                    Delete the cookie
                    if access is not from
                    the cookie him self
                */
                
            if(!$IS_COOKIE) setcookie("AUTH".$ID_AUTH, '', 1,"/");
            }
            
            
            if($IS_COOKIE) return true;
            
        } else {
                
                $AUTH_RESULT=false;
                
            
            if(!$IS_COOKIE) htmlHelper::setFlash("err",__($AUTH_A_I['msg_login_no']));
            
            if($IS_COOKIE) return false;
        }
        
        if(!$IS_COOKIE)
        {
            //echo rootWWW."---".$REDIRECT_URL;
            //echo rootWWW;
            //echo rootWWW;
            //if($AUTH_RESULT)
            if(!$settings['STOP_REDIRECT']){Header("location: ".rootWWW."".$REDIRECT_URL);exit;}
            return false;
        }
    }
    
    function logout($a,$ID_AUTH,$REDIRECT_URL=null)
    {
        //pr($a);
        //echo
        //pr($ID_AUTH);
        if(empty($a['GET_DATA']['url'])) { $URL_TO_GO=rootWWW; }
        else { $URL_TO_GO=rootWWW.$a['GET_DATA']['url']; }
        //pr($_SESSION['AUTH'][$ID_AUTH]);
        //echo''.$ID_AUTH;
        if(empty($ID_AUTH))
        {
            //echo'E';
            /*
                ID_AUTH empty
                first check if
                is inside logout var
            */
                
                if(!empty($_GET['logout']) && isset($_SESSION['AUTH'][$_GET['logout']]))
                {
                    unset($_SESSION['AUTH'][$_GET['logout']]);
                    setcookie('AUTH'.$_GET['logout'], '', 1,"/");
                }
                else
                {
                    //echo'all';
                    /*
                        Else
                        unset 
                        ALL 
                    */
                        
                    unset($_SESSION['AUTH']);
                        //pr($_SESSION['AUTH']);
                    foreach($_COOKIE as $k=>$v)
                    {
                        /* Look for AUTH cookies */
                        if(substr($k,0,4)=="AUTH")
                        {
                            echo'<p>'.$k.'</p>';
                            setcookie($k, '', 1,"/");
                        }
                    }
                }
        }
        else
        {
            unset($_SESSION['AUTH'][$ID_AUTH]);
            setcookie("AUTH".$ID_AUTH, '', 1,"/");
        }
        Header("location: ".$URL_TO_GO);exit;
        
    }
}