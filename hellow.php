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

//echo 'hello world '.time();
$fileOutput="/var/www/libraio/_core/hellow.txt";
sleep(5);
write($fileOutput,"A ".time());

?>