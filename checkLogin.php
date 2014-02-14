<?php
    /***************************************************************
        
        Here is a request of AUTH
        
    *****************************************************************/    
    //pr($_SESSION['AUTH']);
    //echo $a['STATUS'];
    //pr($_SESSION['AUTH']);
    if(
       ($loginRequired && $loginRequired_SET && $_SESSION['AUTH'][$ID_AUTH][$LOGIN_ID_SET_field]!=$a['route']['login_set'])
       OR
       ($loginRequired && !$_SESSION['AUTH'][$ID_AUTH])
       
    )
    {
        
        //echo'YES!';
        if($_SESSION['AUTH'][$ID_AUTH]) $a['ALERT'].="Different Permission Required on <b>".$LOGIN_ID_SET_field."</b> Field of table: \"<b>".$ID_AUTH."</b>\"<br />";
        $a['STATUS']="401";
        $a['VIEW']=_CORE::lookingForView($a,"401.php");
        
    }    
        
        
        
    if(isset($a['GET_DATA']['logout']))
    {
        //echo'A';exit;
        //echo $ID_AUTH;
        //pr($_SESSION['AUTH']);
        $a=AUTH::logout($a,$ID_AUTH);
        //echo $a['GET_DATA']['url'];
        //unset($_SESSION['AUTH']);
        //setcookie("AUTH", '', 1,"/");
        //Header("location: ".rootWWW."".$a['GET_DATA']['url']);exit;
    }