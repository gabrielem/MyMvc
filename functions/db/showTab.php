<?php
function showTab($db,$settings=null){
$myCon=connect($settings);
	$a=array();
	$sql = "SHOW TABLES FROM $db";
	//echo $sql;
	$result = mysql_query($sql,$myCon);
	if(!$result) {echo '<p>'.mysql_error().'</p>';}
	while ($row = mysql_fetch_row($result)) {
	$a[]=$row[0];
	}
	
	return $a;
}

function showFields($t,$settings=null){
//pr($settings);
$myCon=connect($settings);
	
	$a=array();
        //echo pr($t);
	for($i=0;$i<count($t);$i++) {		

/*
$result = mysql_query("SELECT * FROM ".$t[$i]."");
$fields = mysql_num_fields($result);
$rows   = mysql_num_rows($result);
$table  = mysql_field_table($result, 0);
echo "Your '" . $table . "' table has " . $fields . " fields and " . $rows . " record(s)\n";
echo "The table has the following fields:\n";
for ($ii=0; $ii < $fields; $ii++) {
    $type  = mysql_field_type($result, $ii);
    $name  = mysql_field_name($result, $ii);
    $len   = mysql_field_len($result, $ii);
    $flags = mysql_field_flags($result, $ii);

$a[$t[$i]][$ii]['type']=$type;
$a[$t[$i]][$ii]['name']=$name;
$a[$t[$i]][$ii]['len']=$len;
$a[$t[$i]][$ii]['flags']=$flags;

  //  echo $type . " " . $name . " " . $len . " " . $flags . "\n";
}



*/
		$sql = "SHOW COLUMNS FROM ".$t[$i];
		//echo $sql ;
                $result = mysql_query($sql);
                if(!$result) pr(mysql_error());
			$count='0';
		while ($row = mysql_fetch_row($result)) {
		//echo " ".$row[0]." ";
		//echo " ".$row[1]." ";
			//echo '<pre>AAA';
			//print_r($row);
			//echo '</pre>';
		$a[$t[$i]][$count]['Field']=$row[0];
		$a[$t[$i]][$count]['Type']=$row[1];
		$a[$t[$i]][$count]['Null']=$row[2];
		$a[$t[$i]][$count]['Key']=$row[3];
		$a[$t[$i]][$count]['Default']=$row[4];
		$a[$t[$i]][$count]['Extra']=$row[5];
                    $onlyFields[]=$row[0];
			$count++;
		}

	}
            if($settings['ONLY_FNAME'])
            {
                return $onlyFields;
            }
	return $a;

}
?>
