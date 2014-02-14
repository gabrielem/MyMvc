<?php
function write($path_file,$content,$mode='w'){
$fp = fopen ($path_file, $mode);
fwrite($fp,   $content );

	if($fp) 
	{ 
	fclose($fp); 
	return true; 
	} 
	return false;
}
?>
