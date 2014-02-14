<?php
//pr($a);
        //echo $a['STATUS'];
        
            
        
    if($a['route']['login']=="1" && $a['STATUS']!="404")
    {
        $loginRequired=true;
            
        /*
            
            Name Tab
            
        */
        $nameTabLogin=$a['route']['login_tab'];    
        $LOGIN_TAB=$$nameTabLogin;
        $a['ALERT'].="<p><b>NEED LOGIN</b> [n:".$nameTabLogin." T:".$LOGIN_TAB."] </p>";
        if(empty($a['route']['login_tab']))
        {
            $nameTabLogin=LOGIN_TAB_DEFAULT;    
            $LOGIN_TAB=$$nameTabLogin;
            $a['route']['login_tab']=$nameTabLogin;
        }
        //echo "<p>LOGIN_TAB: ".$nameTabLogin."</p>";
            
            
            
        /*
            
            Login_Set
            
        */
        if($a['route']['login_set']!="0" && !empty($a['route']['login_set']))
        {
            $loginRequired_SET=true;
            
        }
            
        /*
            F a t a l   E r r o r  ?
            
            Check for fatal error
            if there is no tab selected or tab is incorrect
        */
        
        //echo $LOGIN_TAB;
        
        if(empty($LOGIN_TAB))
        {
            echo'<p><h3>FATAL ERROR</h3>on <b>_config/auth.php</b> LOGIN_TAB_DEFAULT not set correctly<br />Looking for table: <b style="color:red;">'.$a['route']['login_tab'].'</b></p>
            <br />on file: '.__FILE__.' - at line: <b>'.__LINE__.'</b></p>';
            exit;
        }
            
          
          
          
          
          
        //echo '<p>login_tab: '.$a['route']['login_tab'].'</p>';
        $ID_AUTH=str_replace("TAB","",$a['route']['login_tab']);
        //pr($ID_AUTH);
            
            
        /*
            Cechk COOKIE
            $_COOKIE['AUTH'])
            
        */
            
        if(isset($_COOKIE['AUTH'.$ID_AUTH]))
        {
            //echo'checkLoginCookie';
            AUTH::checkLoginCookie($a,$ID_AUTH);
        }

            
            
        /*
            $TAB_SET_AUTH
        */
            
        //pr($AUTH_A[$ID_AUTH]);
        $TAB_SET_AUTH=$$AUTH_A[$ID_AUTH]['table_set'];
            
        if(empty($TAB_SET_AUTH))
        {
            echo'<p><h3>FATAL ERROR</h3>on <b>_config/auth.php</b> TAB_SET_AUTH not set correctly<br />Looking for table: <b style="color:red;">'.$AUTH_A[$ID_AUTH]['table_set'].'</b>
            <br />on file: '.__FILE__.' - at line: <b>'.__LINE__.'</b></p>';
            exit;
        }
            
            
            
        // $a['route']['login_tab']&& $nameTabLogin are set!
        $LOGIN_ID_SET_field="id_".$TAB_SET_AUTH;
        
        
        /*
            id form set LOGIN_ID_FORM_DEFAULT if is empty
        */
        $ID_AUTH_FORM=$AUTH_A[$ID_AUTH]['id_form'];
        if(empty($AUTH_A[$ID_AUTH]['id_form']))
        {
            $ID_AUTH_FORM=LOGIN_ID_FORM_DEFAULT;
        }
        
    }
        
        
        
        
        
        
        
        
        
    //pr($a['POST_DATA']);
    /*
        
        - loop all $AUTH_A && check when login data is send
        
    */
    //echo'<p><CHECK AUTH/p>';
        
    foreach($AUTH_A as $name=>$v)
    {
        /*Set LOGIN_ID_FORM_DEFAULT if empty */
        if(empty($v['id_form'])){$v['id_form']=LOGIN_ID_FORM_DEFAULT;}
            
            
        if(isset($a['POST_DATA'][$v['id_form']]))
        {
            /*
            $ID_AUTH
            $LOGIN_ID_SET_field
            $ID_AUTH_FORM
            */
            
            $settings=array(
                'AUTH_A'=>$AUTH_A,
                'ID_AUTH'=>$ID_AUTH,
                'LOGIN_TAB'=>$LOGIN_TAB,
                'LOGIN_ID_SET_field'=>$LOGIN_ID_SET_field,
                'ID_AUTH_FORM'=>$ID_AUTH_FORM,
                
                );
                
                
                
            $a=AUTH::checkLogin($a,$settings);
        }
            
    }
        
    
    
    
  
    
    
    
    
    
    /*
    if(isset($a['POST_DATA'][LOGIN_ID_FROM]))
    {
        $a=checkLogin($a);
        
    }
    */
    
    //LOGOUT
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
       //Function for checking login
    
    ### Data need:
    /*
    1. ID FORM LOGIN (default: LOGIN_CHECK)
    2. TABLE of users (default: ???)
    3. TABLE of users_sets (default: ???)
    4. USERNAME field name of the DB table (default: email)
    5. PASSWORD field name of the DB table (default: password)
    6. ID_SET   field name of the DB table (default: id_"TABLE_SET")
    7. ADD_WHERE to add some condition (default=null)
    8. REDIRECT field name of the form (default:redirect) => but normaly empty -> use $a[GET_DATA][url]
    9. 
    */
