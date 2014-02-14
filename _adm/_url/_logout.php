<?php
//
$htmlHelper=new htmlHelper();
$htmlHelper->setFlash('sample','logout'); 
unset($_SESSION['admin']);
header("location: ".$rootBaseAdmin);
?>
