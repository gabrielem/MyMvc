<?php
class VALIDATION
{
    
    function parse($a,$aGloabl)
    {
        // $a = DATI
        // $aGloabl = $a global array 
        //pr($a);
            
        $result['RESULT']=true;
        $ECHO_THIS=false;
        //$ECHO_THIS=true;
            
        /*
        1. Set the TABLE
        2. Load validation Array
        3. Load Post Data (So data must be in the POST_DATA var) if not trow error
        4. Compare the validation Array to POST_DATA only where array() af validation is set
        5. Reorganization of result:
                
            if errors are set
            a) send false in the array item RESULT
            b) make an array of all fields_name whit error
            c) make an array of all fields_name whit error=>error_msg
            d) make a var whit all messag of error together
                
            if not error
            a) send true in the array item RESULT
            
        */
            
        ###
        ###
        ### 1. Set the TABLE
        $TAB=$a['USE_TAB'];
            
        ###
        ###
        ### 2. Load validation Array
        include(rootDOC."_config/_validations/".$TAB.".php");
            
        if(!is_array($validationsDataArray))
        {
        echo "<b>validationsDataArray</b> not exists.";
        $result['RESULT']=false;
        }
        else
        {
            
        ###
        ###
        ### 3. Load Post Data (So data must be in the POST_DATA var) if not trow error
            
        $POST_DATA=$a['POST_DATA'];
        //pr($POST_DATA);
            
        ###
        ###
        ### 4. Compare the validation Array to POST_DATA only where array() af validation is set
                
                $err_msg_txt="";
                
            foreach($validationsDataArray as $k=>$v)
            {
                if($ECHO_THIS)echo '<p>';
                if($ECHO_THIS)echo'for the '.$k.'';
                    //pr($v);
                    /*
                        
                        If settings array for this field are not empty
                        init all the validate functions
                        
                    */
                    if(!empty($v)){
                        /*
                            Setting array
                        */
                            
                        foreach($v as $k2=>$v2)
                        {
                            /*
                            Here is an item of validation for the current field ($k)
                            set the parameter:
                            
                            validate_function
                            validate_function_settings
                            error_message
                            need_translations
                            require_a
                            
                            
                            */
                            if($ECHO_THIS)echo ' <li> '.$v2['validate_function']." -> ".$POST_DATA[$k]." (".$k.")</li>";
                            //echo ' <li> '.$v2['validate_function']." -> ".$POST_DATA[$k]." (".$k.")</li>";
                                
                                if(!empty($v2['require_a']) && !empty($v2['validate_function_settings']))
                                {
                                $FUNCTION_VALIDATE=$v2['validate_function']($aGloabl,$POST_DATA,$POST_DATA[$k],$v2['validate_function_settings']);
                                }
                                elseif(!empty($v2['require_a']))
                                {
                                $FUNCTION_VALIDATE=$v2['validate_function']($aGloabl,$POST_DATA,$POST_DATA[$k]);
                                }
                                elseif(!empty($v2['validate_function_settings']))
                                {
                                $FUNCTION_VALIDATE=$v2['validate_function']($POST_DATA[$k],$v2['validate_function_settings']);
                                }
                                else
                                {
                                $FUNCTION_VALIDATE=$v2['validate_function']($POST_DATA[$k]);
                                }
                                
                                
                            if(!$FUNCTION_VALIDATE)
                            {
                                if($ECHO_THIS)echo'<p>RETURN FALSE!</p>';
                            $result['RESULT']=false;
                                    /*
                                     
                                    Set $error_message whit or whitout translations
                                        
                                    */
                                    $error_message=$v2[error_message];
                                    if($v2[need_translations])
                                    {
                                    $error_message=_CORE::LANG($v2[error_message]);
                                    }
                                        
                                    /*
                                        
                                        Setting :: $_errors___array ::
                                        
                                    */
                                        
                                $err_fields[]=$k;
                                $err_fields_and_msg[]=array($k=>$error_message);
                                $err_msg_txt.="<li>".$error_message."</li>";
                                
                            }
                            
                        }
                    }
                if($ECHO_THIS)echo'</p>';
            }
            
            
            ###
            ###
            ### 5. Reorganization of result:
            if(!$result['RESULT'])
            {
                /*
                    
                    If errors are set
                    organize $result Array whit errors messages
                    
                */
                
                $result['err_fields']=$err_fields;
                $result['err_fields_and_msg']=$err_fields_and_msg;
                $result['err_msg_txt']=$err_msg_txt;
                
            }
            
        }
        
        return $result;
    }
    
}