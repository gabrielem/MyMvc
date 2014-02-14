<?php
if(isset($_POST['adminLogin']))
{
//echo '111';exit; 
$myCon=connect();
//$urlCorrente
$sel="SELECT * FROM $TAB_admin_users WHERE email='".$_POST['email']."' AND password='".$_POST['password']."' ";
$res=mysql_query($sel,$myCon);
	if(mysql_num_rows($res)){
	$row=mysql_fetch_array($res);
	
        //pr($row);exit;
        $_SESSION['admin']=$row['id'];
	$_SESSION['admin_level']=$row['admin'];
	//$HTTP_SESSION_VARS['msg']=''.$MSG_admin_login_riuscito.'';



$htmlHelper->setFlash('msg',$lang['MSG_login_OK']); 
	} else {
	//$HTTP_SESSION_VARS['msg']=''.$MSG_admin_login_non_riuscito.'';


$htmlHelper->setFlash('msg',$lang['MSG_login_NO']); 

	}
	header("location: ".$urlCorrente);
exit;
}
?>
