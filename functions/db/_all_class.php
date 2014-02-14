<?php

class dbAction
{

    function dbConnection($settings=null) 
    {
	//pr($settings);
	$DB_CONFIG=_defineArray(DB_CONFIG); 
	if($settings['DB_CONFIG'])
	{
            //
	    $DB_CONFIG=$settings['DB_CONFIG'];
	}
	//pr($settings['DB_CONFIG']);
	//global $DATABASE_NAME; $user="root"; $pw="12341234"; $db_host="localhost";
	$n=$DB_CONFIG['n'];
	$u=$DB_CONFIG['u'];
	$p=$DB_CONFIG['p'];
	$h=$DB_CONFIG['h'];
	
	
	
    //pr($n);
	if($settings['bu'])
	{
	$a=array('u'=>$u,'n'=>$n,'p'=>$p,'h'=>$h);
	return $a;    
	}
	 setlocale(LC_ALL, $langSuff.'.utf8');
	 $con = mysql_connect($h, $u, $p);
	 if(!$con){//trigger_error("Problem connecting to server");
	 }	
	 $db =  mysql_select_db($n, $con);
	  if(!$db){//trigger_error("Problem selecting database");
	 }
    return $con;
    }



    /*
	Exec a SQL query
    */
    function _shell_query($a)
    {
	// Two way to call it: 
	//_shell_query(array('SQL'=>$SQL))
	//_shell_query(array('SQL_FILE'=>$SQL_FILE))
		
	    $settings=array('bu'=>true);
	    if($a['DB_CONFIG']){$settings=array('bu'=>true,'DB_CONFIG'=>$a['DB_CONFIG']);}
		
	//pr($a);
	$db_data=connect($settings);
	//pr($db_data);exit;
	
	    if($a['DUMP'])
	    {
		if($a['DATA_ONLY'])
		{
		    //$ADD_DATA_ONLY=" --skip-triggers --compact --no-create-info ";
		    $ADD_DATA_ONLY=" --skip-triggers --no-create-info ";
		}
		$C="mysqldump  -h ".$db_data['h']." -u ".$db_data['u']." -p".$db_data['p']." ".$db_data['n']." ".$a['TABLE']." ".$ADD_DATA_ONLY." > ".$a['SQL_FILE'];
		//pr('AAAAA');
		//pr($C);
		//pr('AAAAA');
		
	    }
	    elseif(isset($a['SQL_FILE']))
	    {
		$C="mysql ".$db_data['n']." -h ".$db_data['h']." -u ".$db_data['u']." -p".$db_data['p']." < ".$a['SQL_FILE'];
	    }
	    elseif(isset($a['SQL']))
	    {
		$C="mysql ".$db_data['n']." -h ".$db_data['h']." -u ".$db_data['u']." -p".$db_data['p'].' -e "'.$a['SQL'].'"';
	    }
	    else
	    {
		echo'<p>Must Pass SQL var or SQL_FILE</p>';
		return false;
	    }
		
	    if($a['echo'])
	    {
		pr($C);
	    }
		
	system($C);
    }
	
	
	
    function _exec($a)
    {
	//pr($a);
	$mysql_access = connect();
        mysql_query("SET character_set_client=utf8", $mysql_access);
        mysql_query("SET character_set_connection=utf8", $mysql_access);
        mysql_query('set names utf8', $mysql_access);
	$resR=mysql_query($a['sql'],$mysql_access);
	if($resR){
		if($a['return_result'])
		{
		    return $resR;
		}
		return true;
	    }
	else{if($a['echo']) {echo '<p style="background:#ffffff;padding:5px;font-size:10px;">'.$a['sql'].'<br /><tt style="font-size:12px;color:red;">'.mysql_error()."</tt></p>";}return false;}
    }
    
    
    /***************************************************************************
     
     
     
     _record
	
	
	
    ****************************************************************************
    ****************************************************************************
    ****************************************************************************/
    
        
    function _record($a){
	//pr($a);
	
	
	
	//array('tab'=>'','field'=>'','value'=>'','add_w'=>'','set_w'=>'','echo'=>'')	
        if(empty($a['tab'])) echo '';
        if(empty($a['field'])) $a['field']="id";
        if(empty($a['value'])) echo '';
        if(empty($a['add_w'])) echo '';
        if(empty($a['set_w'])) echo '';
        if(!isset($a['relations'])) $a['relations']=true;
        
	
        $TAB_RECORD=$a['tab'];
	$ID_RECORD_CAMPO=$a['field'];
	$ID_RECORD=$a['value'];
	$ADD_WHERE_RECORD=$a['add_w'];
	$SET_WHERE_RECORD=$a['set_w'];
	
	$relations=$a['relations']; //Default true
	
	
	$TAB2=$a['tab2'];
	
	
	//echo $TAB_RECORD;
        $echo=$a['echo'];
        
	//echo "<p>a".$TAB_RECORD."</p>";
        $CAMPI_RECORD=campiTab($TAB_RECORD);
	if($a['LOAD_FIELDS']){$SETT=$a;$SETT['ONLY_FNAME']=true;$CAMPI_RECORD=showFields(array($TAB_RECORD),$SETT);}
	    
	//if(!empty($echo)) echo $TAB_RECORD;
        if(!$CAMPI_RECORD || empty($CAMPI_RECORD )){
            if(!empty($echo)){echo'<p>table not set OR schema not updated</p>';}
            //return false;
        }
	/*
	else {
	    //Make loop of table field
	    $virgola="";
	    foreach($CAMPI_RECORD as $k=>$v)
	    {
		$SELECT_FIELDS.=$virgola.$TAB_RECORD.'.'.$v.' AS '.$v.'';
		$virgola=',';
	    }
	}
	*/
	$SELECT_FIELDS="*";
	    /*
		Setting $TAB_RECORD if TAB2 is set
		so if it is, $TAB_RECORD became a var whit 2 tab
		like this: (tab1,tab2)
	    */
		
		if(!empty($TAB2))
		{
		    /*
		     
			Set the tab rel, is {tab1}_{tab2}
			
		    */
		    $TAB_REL=$TAB_RECORD."_".$TAB2;
		    $TAB_RECORD=" ".$TAB_RECORD.", ".$TAB_REL." ";
		}
		
        $mysql_access = connect($a);
        
        mysql_query("SET character_set_client=utf8", $mysql_access);
        mysql_query("SET character_set_connection=utf8", $mysql_access);
        mysql_query('set names utf8', $mysql_access);
        
        /*
	 
	    make recordset
	    
	*/
	    if(!empty($SET_WHERE_RECORD)){
	    $selR="SELECT $SELECT_FIELDS FROM $TAB_RECORD $SET_WHERE_RECORD ".$a['orderby']." LIMIT 1";
	    }
	    else
	    {
	    $selR="SELECT $SELECT_FIELDS FROM $TAB_RECORD WHERE ".$ID_RECORD_CAMPO."='".$ID_RECORD."' ".$ADD_WHERE_RECORD." ".$a['orderby']." LIMIT 1";
	    }
		
	    $resR=mysql_query($selR,$mysql_access);
		
		
		
		
	    
	    if(!$resR){
		//echo mysql_errno();
		$ERR_NUM=mysql_errno();
		//pr($ERR_NUM);
		if(!empty($echo)) echo "<p style='color:red;'>".$selR."<br/>".mysql_error()."</p>";
	    }
	    else{
		if(!empty($echo)) echo "<p>".$selR."</p>";
	    }
	    
            
            
        //set array
        if($resR && mysql_num_rows($resR)){
	    
        $r=array();
            
	$rowR=mysql_fetch_array($resR);
	$NOME_ARRAY_CAMPI="CAMPI_".$TAB_RECORD;
	$arrayCAMPI=$CAMPI_RECORD;
		for($i=0;$i<count($arrayCAMPI);$i++){
		$r[$arrayCAMPI[$i]]=$rowR[$arrayCAMPI[$i]];
		}
	    
	$r=_CORE::checkDbFiles($r,$a['tab'],$a);    
	
	if($a['relations'])
	{
	    $r=_CORE::setRelationData($r,$a['tab'],$a);
	}
	
	
        $r['TAB_NAME']=$TAB_RECORD;
        return $r;
	} else {
	    if($a['_ERR_NUM_'])
	    {
		return $ERR_NUM;
	    }
	    return false;
	}
        
        
    }//end f. _record


    
    
    
    
    
    
    
    /***************************************************************************
     
     
     
     _loop
	
	
	
    ****************************************************************************
    ****************************************************************************
    ****************************************************************************/
    
    
    function _loop($a,$A=null){
    $mysql_access = connect($a);
    
    //if($a['echo'])pr($a);
    if(!isset($a['relations'])) {$a['relations']=true;}
    
    
    //array('tab'=>'','where'=>'','orderby'=>'','limit'=>'','echo'=>'')
	    
	//Some other array value: 
	//$a['SELECT_FIELDS']
	//$a['add_tab_name']
	    
	    
	    
	//pr($a);
	
    $TAB1=$a['tab'];
    $LOOP_WHERE=$a['where'];
    $LOOP_ORDERBY=$a['orderby'];
    $LOOP_LIMIT=$a['limit'];
	
	
	//echo'<p>'.$LOOP_WHERE.'</p>';
	//if(empty($LOOP_LIMIT)) $LOOP_LIMIT=" LIMIT 0,1000 ";
	
    $tab2=$a['tab2'];
	$LOOP_TAB=$TAB1;
	if(!empty($tab2)) $LOOP_TAB=$TAB1.", ".$tab2;
	
	//echo'<p>'.$LOOP_TAB.'</p>';
	
    $echo=$a['echo'];
	
    $records_for_pag=$a['records_for_pag'];
    $current_page = (!$a['current_page']) ? 1 : (int)$a['current_page']; 
    $pagSuff=$a['pagSuff'];
    
    $url_pagination=$a['url_pagination'];
	
	//Setting $LOOP_LIMIT if $records_for_pag is set
	if($records_for_pag!="")
	{
	$START_LIMIT=($records_for_pag*$current_page)-$records_for_pag;
	$LOOP_LIMIT=" LIMIT ".$START_LIMIT.",".$records_for_pag." ";
	    
	    /*
		
		Count of records
		
	    */
	    
	//$s="SELECT COUNT(*) ".$LOOP_TAB." ".$LOOP_WHERE." ";
	$s="SELECT COUNT(*) FROM ".$LOOP_TAB." ".$LOOP_WHERE." ";
	//pr($s);
	$count=mysql_query($s,$mysql_access);
	//if(!$count){echo'ERR'.mysql_error();}
	
	$tot_records="0";
	if($count){
	$tot_records=mysql_fetch_assoc($count);
	//$tot_records=mysql_result($count);
	//pr($tot_records);
	//echo "<p>".$tot_records['COUNT(*)']."</p>";
	$tot_records=$tot_records['COUNT(*)'];
	$tot_pages=ceil($tot_records / $records_for_pag);
	}	
		
		/*
		
		    Setting data paginations
		
		*/
		
	    $pagination_data=array(
	    'url_pagination'=>$url_pagination,
	    'tot_pages'=>$tot_pages,
	    'tot_records'=>$tot_records,
	    'current_page'=>$current_page,
	    'query_recover_pagination'=>$a['query_recover_pagination'],
	    'pagSuff'=>$pagSuff
	    );
	    
	    /*
		class makePagination {}
		makePagination CLASS is located in _core/functions/makePagination.php
		
		
	    */
	    $makePagination=New makePagination();
		//pr($a);
		
		/*
		    
		    Init Pagination Data
		    
		*/
		
            $pagination_data=$makePagination->_init($pagination_data);
		
		
		/*
		    
		    Check if current_page is in tot_pages 
		    
		*/
		if($pagination_data['current_page']>$pagination_data['tot_pages'] && $tot_records!="0")
		{ 
		    //echo 'A';
		    $loop[0]['pagination_data']=$pagination_data;
		    $return=$loop;
		    //return $loop;
		}
		
		
	}
	    
	    //pr($pagination_data);
	    
    	if(!empty($echo)) echo '<p><b><i>TAB: '.$LOOP_TAB.'</i></b></p>';
	
	//echo "".$tab2;
	
//global $TAB_slug;
	
	
	
$LOOP_CAMPI=campiTab($TAB1);
if($a['LOAD_FIELDS']){$SETT=$a;$SETT['ONLY_FNAME']=true;$LOOP_CAMPI=showFields(array($TAB1),$SETT);}
//pr($LOOP_CAMPI);
	
	//$LOOP_ORDERBY DEFAULT
    if(is_array($LOOP_CAMPI))
    {
	if(empty($LOOP_ORDERBY) && in_array("posizione", $LOOP_CAMPI))
	{
	$LOOP_ORDERBY=" ORDER BY posizione ";
	}
    }
	
    if(!$LOOP_CAMPI || !is_array($LOOP_CAMPI))
	{
	if($a['echo']) echo'<p style="color:red;">LOOP FIELDS NOT EXISTS.<br />TRY Update DB Schema</p>';
	return false;
	}
	
    
    $SELECT_FIELDS=$a['SELECT_FIELDS'];
    //echo $SELECT_FIELDS;
    if(empty($a['SELECT_FIELDS']))
    {
	//Make loop of table field
	$virgola="";
	foreach($LOOP_CAMPI as $k=>$v)
	{
	    $SELECT_FIELDS.=$virgola.$TAB1.'.'.$v.' AS '.$v.'';
	    $virgola=',';
	}
    }
	
	
	
	
	if($TAB1!="" && !isset($return)) {
        
        
        mysql_query("SET character_set_client=utf8", $mysql_access);
        mysql_query("SET character_set_connection=utf8", $mysql_access);
        mysql_query('set names utf8', $mysql_access);
	    
	    
	    
	    
	    
        $sel="SELECT ".$SELECT_FIELDS." FROM ".$LOOP_TAB." ".$LOOP_WHERE." ".$LOOP_ORDERBY." ".$LOOP_LIMIT;
	
	//pr($a);
	    //echo "<p>".$sel."</p>";
	    if(!empty($echo)) echo "<div style=\"border:3px #afafaf solid;background:#ffffcc;padding:9\">".$sel."</div>";
        
        $res=mysql_query($sel,$mysql_access);
                if(!$res){echo '<p style="color:red;">'.mysql_error().'<br/><tt>'.$sel.'</tt></p>';}
                if(mysql_num_rows($res)) {
        $loop=array();	
        $c=0;
        $conto="1";
			while($row=mysql_fetch_array($res)){
                        $NOME_ARRAY_CAMPI="CAMPI_".$TAB_RECORD;
                        $arrayCAMPI=$LOOP_CAMPI;
				
				if(empty($a['SELECT_FIELDS']))
				{
				    for($i=0;$i<count($arrayCAMPI);$i++){
					    $virgola=',';
				    $loop[$c][$arrayCAMPI[$i]]=$row[$arrayCAMPI[$i]];
					
					    
				    }
				}	
				    
				/*
				    
				    Adding fields for DbFiles
				    
				*/
				$loop[$c]=_CORE::checkDbFiles($loop[$c],$TAB1,$a); 
				//echo $TAB1;
				//pr($loop[$c]);
				
				if($a['relations']){
				echo'';
				$loop[$c]=_CORE::setRelationData($loop[$c],$TAB1);
				}   
				    
                                //aggiungo un campo per la classe delle righe alterne
                                
                                if($conto=="1")
                                {
                                $tr_class="uno";
                                }
                                else
                                {
                                $tr_class="due";
                                $conto="0";
                                }
                                $conto++;
                                $loop[$c]['tr_class']=$tr_class;
				    
				if($a['add_tab_name'])
				{
				    $loop[$c]['_TABLE_']=$LOOP_TAB;
				}
				    
				    
        
        
        
        
        
                        $c++;
                        }
			//pr($loop);
		    // ADD $pagination_data  ARRAY
		    //In the first item of array
		    //Insert if there is the pagination array
		    if(is_array($pagination_data))
		    {
		    $loop[0]['pagination_data']=$pagination_data;
		    }
		
                //return $loop;
                $return=$loop;
		} else {
                $return=false;
                //return false;
                }
		
		
		
		
		
        }
	
	
	
	/*
		
		$return
		    
	*/
	if(isset($A) && is_array($A))
	{
	    $STORE_IN=$TAB1;
	    if(isset($a['store_in']))
	    {
		$STORE_IN=$a['store_in'];
	    }
		if($echo)
		{
		    //echo '<p>::STORE_IN:'.$STORE_IN.'</p>';
		//pr($return);
		}
		
	$A['LOOP'][$STORE_IN]=$return;
	$A['LOOP_CONFIG'][$STORE_IN]=$a;
	return $A;
	}
	else
	{
	return $return;
	}
	
    }//end f. _loop
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /***************************************************************************
     
     
     
     _insert
	
	
	
    ****************************************************************************
    ****************************************************************************
    ****************************************************************************/
	
	
    function _insert($a){
    $mysql_access = connect($a);
	    
	/*
	    
	    Set the data
	    array('tab'=>$tab,'data'=>$data,'only_this_fileds'=>$only_this_fileds,'echo'=>'0');
	    
	*/
	    
	$tab=$a['tab'];
	$data=$a['data'];
	    //pr($data);
	    
	$only_this_fileds=$a['only_this_fileds'];
	$echo=$a['echo'];
	    
	/*
	    
	    $only_this_fileds
	    Forcing only some fileds in the insert action
	    
	    this var set the loop of the fields from the table
	    
	*/
	if(!empty($only_this_fileds))
	{
	    foreach($only_this_fileds as $C)
	    {
		$campi[]['Field']=$C;
	    }
	    
	    //$campi=$only_this_fileds;
	    
	}
	else
	{
	$campi=campiTab($tab,1);
	}
	    
	    
	    
	/*
	 
	    Set up the slug if necessesary
	    
	*/
	
	$data=dbAction::slug($a,$campi,$data,$tab);    
	    if(!$data)
	    {
		return false;
	    }
	/*
	    
	    Set the fields loop
	    
	*/
	//pr("A");  
	foreach($campi as $k=>$v)
	{
		if(strtolower($v['Field'])!='id' && strtolower($v['Extra'])!='auto_increment')
		{
			//echo " a - ".$v['Field'].'<br />';
			$CAMPI_ALL.=$separatore1b."".$v['Field'].""; 
			$separatore1b=",";
			    
			if(isset($data[$v['Field']]))
			{
			$CAMPI.=$separatore1."".$v['Field'].""; 
			$separatore1=",";
			    
			$VALUES.=$separatore2."'".pulisciDati($data[$v['Field']])."'"; 
			$separatore2=",";
			}
		}
	}
	    
	    
	    
	//echo $VALUES;
	//pr($dati);
	//pr($campi);
	mysql_query("SET character_set_client=utf8", $mysql_access);
	mysql_query("SET character_set_connection=utf8", $mysql_access);
	$insert=" INSERT INTO $tab (".$CAMPI.") VALUES (".$VALUES.")";
	    if($echo) { echo $insert; }
	    
	$res=mysql_query($insert,$mysql_access);
	    
	/*
	    
	    Recovering last ID
	    
	*/    
	if($res)
	{
	    
	$query = "SELECT LAST_INSERT_ID()";
	$result = mysql_query($query,$mysql_access);
	 
	 if ($result) {
	 $nrows = mysql_num_rows($result);
	 $row = mysql_fetch_row($result);
	 $lastID = $row[0];




	    /*
		
		dbAction::_relations()
		
		Check for related tab to insert/update
		all relarted data only for many-to-may rel type
		that need to operate whit a second table {tab1}_{tab2}
		
	    */
	    
	    $relations=dbAction::_relations(array('tab'=>$tab,'id'=>$lastID,'data'=>$data));
		if(!$relations) return false;





	 }
	return $lastID;
	}
	    
	return false;
	    
    } //END f. _insert






    
    
    
    
    
    
    
    
    /***************************************************************************
     
     
     
     _update
	
	
	
    ****************************************************************************
    ****************************************************************************
    ****************************************************************************/
	
	
    function _update($a){
    $mysql_access = connect($a);    
	/*
	    
	    Set the data
	    array('tab'=>$tab,'id'=>$id,'data'=>$data,'only_this_fileds'=>$only_this_fileds,'where'=>'','echo'=>'0','DEMO'=>false);
	    
	    other vars:
	    $a['make_slug_from']
	*/
	   //pr($a); 
	$tab=$a['tab'];
	    if(empty($tab)) { echo'<p><b>tab</b> var is required</p>';return false; }
	$id=$a['id'];
	    if(empty($id)) { echo'<p><b>id</b> var is required</p>';return false; }
	    /********************************************************************
	    *									*
	    *	N O T E 							*
	    *	If id is required, $where as no meaning				*
	    *									*
	    *	---								*
	    *									*
	    *	U P D A T E   R E Q U I R E D 					*
	    *	need an _update function for bulk update...			*
	    *	set a WHERE for update multiple rows				*
	    *									*
	    *									*
	    *									*
	    *********************************************************************/
	    
	$data=$a['data'];
	    
	$where=$a['where'];
	$echo=$a['echo'];
	
	$DEMO=$a['DEMO'];
	$only_this_fileds=$a['only_this_fileds'];
	    
	    
	/*
	    
	    $only_this_fileds
	    Forcing only some fileds in the insert action
	    
	    this var set the loop of the fields from the table
	    
	*/
	$campi=campiTab($tab,1);
	    
	if(!empty($only_this_fileds))
	{
	//$campi=$only_this_fileds;
	//pr($campi);
	    /*
		
		Recreation of array
		only for $only_this_fileds
		
	    */
	    foreach($campi as $K=>$V)
	    {
		if(!in_array($K,$only_this_fileds))
		{
		unset($campi[$K]);
		}
	    }
	}
	 
	/*
	 
	    Set up the slug if necessesary
	    
	*/    
	$data=dbAction::slug($a,$campi,$data,$tab,$id);
	    if(!$data)
	    {
		return false;
	    }

	    
	/*
	    
	    Set the fields loop
	    
	*/
	
	    //pr($campi);
	foreach($campi as $k=>$v){
		if(strtolower($v['Field'])!='id' && strtolower($v['Extra'])!='auto_increment'){
			if(isset($data[$v['Field']]))
			{
			$DATA.=$separatore1."".$v['Field']."='".pulisciDati($data[$v['Field']])."'"; 
			$separatore1=",";
			}
		}
	}
	
	//pr($a);
	//pr($DATA);
	    
	
    /*
	
	Setting the Where
	1. if $where is set put on it
	2. other side if $id is set using it
	3. set error: no ID or WHERE are set!
	
    */
	
	
    if(!empty($where))
    {
    $W=$where;
    }
    else if(!empty($id))
    {
    $W=" WHERE id='".$id."' ";
    }
    else
    {
	if($echo) echo'<p>no ID or WHERE are present</p>';
	return false;
    }
        
	
    mysql_query("SET character_set_client=utf8", $mysql_access);
    mysql_query("SET character_set_connection=utf8", $mysql_access);
	
    $update=" UPDATE $tab SET ".$DATA." ".$W." ";
	if(!$DEMO && !empty($DATA))
	{
    $res=mysql_query($update,$mysql_access); 
	}
	    
	if($echo)echo "<p>".$update."</p>";
	    
	    /*******************************************************************
		
		dbAction::_relations()
		
		Check for related tab to insert/update
		all relarted data only for many-to-many rel type
		that need to operate whit a second table {tab1}_{tab2}
		
	    *******************************************************************/
	    $rel_array_config=array('tab'=>$tab,'id'=>$id,'data'=>$data);
	    //pr($rel_array_config);
	    $relations=dbAction::_relations($rel_array_config);
		    
		if(!$relations) return false;
		    
		    
		    
	if(empty($DATA) && $relations)
	{
	    /*
		
		This case is when update only relations data
		
	    */
	    $risposta=true;
	    
	}
	elseif($res)
	{
	$risposta=true;
	//$risposta['msg']=$lang['MSG_record_aggiornato'];
	}
	else
	{
	$risposta=false;
	if($echo)echo "<p style='color:red;'>".$update.mysql_error()."</p>";
	    
	
	//$risposta['msg']=$lang['MSG_record_non_aggiornato'];
	}
    return $risposta;    
    } //end f. _update
    
    
    
    
    
    
    
    
    



    


    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /***************************************************************************
     
     
     
     _delete
	
	
	
    ****************************************************************************
    ****************************************************************************
    ****************************************************************************/
	
	
    function _delete($a)
    {
    $tab=$a['tab'];
    $id=$a['id'];
    $where=$a['where'];
    $echo=$a['echo'];
    //echo'DELETE';
	
    global $RELATIONS_DB_ARRAY;    
	
    /*
	
	Take record data
	
    */
	if(!empty($id))
	{
	    $r=dbAction::_record(array('tab'=>$tab,'value'=>$id));
	    if(!$r)
	    {
		echo'<p>Data not valid, no <b>'.$id.'</b> in table: <b>'.$tab.'</b></p>';
		return false;
	    }
	}
	
	/*
              
            _ D E L E T E
		
		Checking Relations & file_db
		Only for single ID delteion
		    
		    ::::: F U T U R E   I M P R O V M E N T :::::
		    In future this function can also delete
		    if $where is set all the relations
		    but need improvment.
		    
		
            For this I need to:
                
            1. Check if USE_TAB is set, i will delete only from this table
            2. Check if there are some relation tab in many-to-may relations
                and if htere are, delete all the associations for the record
            3. Check if there are some file, setup from the data in db_files 
                
        */
	    
        if(isset($tab) && !empty($id))
        {
	    /*************************************************
                
                T A B   R E L A T E D   D E L E T I O N S
                
                Get all Many To Many tabs related
                
            *************************************************/
            $tabs_rel_manyToMany=_CORE::getManyToManyTabs($RELATIONS_DB_ARRAY[$tab]);
            if($tabs_rel_manyToMany)
            {
                /*
                    
                    Loop and delete all related data
                    
                */
                foreach($tabs_rel_manyToMany AS $k=>$v)
                {
                    //echo'<p>'.$v.'</p>';
                    $tabRel=$tab."_".$v;
		    $id_tab1="id_".$tab;
		    $W_delRel=" WHERE ".$id_tab1."='".$id."'";
                    //echo($W_delRel);
		    _delete($tabRel,"",$W_delRel);
                    
                }
            }
	    
	    
	    
	    
	    /*************************************************
                
                D B   F I L E S    D E L E T I O N S 
                
                Looking for all db_files
                only if $db_files_CONFIG exists
                
            *************************************************/
	    
	    //$db_files_CONFIG=rootDOC."_config/_db_files/".$tab.".php";
	    $DELETE_FILES=_CORE::delete_db_files($r,null);
	    //if(!$DELETE_FILES){$a['ALERT'];}
	    
	    
	}   
	    
	    /***************************************************
		
		
		END OF SPECIAL CHECKING: file_db & db_relations
		
		
	    ***************************************************/
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	/*
	    
	    Normal delte, for the tab
	    
	    here the code for a single delete
	    
	*/
	$mysql_access = connect($a);
	    
	if(!empty($where))
	{
	$delete=" DELETE FROM $tab ".$where.""; 
	}
	else
	{
	$delete=" DELETE FROM $tab WHERE id='".$id."'"; 
	}
	
    $res=mysql_query($delete,$mysql_access); 
    if($echo)echo $delete;
	if($res)
	{
	$return=true;
	}
	else
	{
	$return=false;
	}
    return $return;
    } // end f _delete
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /***************************************************************************
     
     
     
     _relations
	
	
	
    ****************************************************************************
    ****************************************************************************
    ****************************************************************************/
	
	
    function _relations($a)
    {
	
	$mysql_access = connect($a);
	global $RELATIONS_DB_ARRAY;
	
	/*
	    
	    VARS
	    
	*/
	$tab=$a['tab'];
	$id=$a['id'];
	$data=$a['data'];
	//pr($data);
	    
	/*
	    
	    Looking on the $RELATIONS_DB_ARRAY
	    1. find all ManyToMany rel
	    2. check if there is a id_{tab2} array ijn the data
	    3. if there is:
		A) Delete all the id_{tab1} in tab: {tab1}_{tab2}
		B) Insert all new relations in tab: {tab1}_{tab2}
	*/
	    
	//pr($RELATIONS_DB_ARRAY);
	    
	if(is_array($RELATIONS_DB_ARRAY[$tab]) && !empty($RELATIONS_DB_ARRAY[$tab]))
	{
	    $relTAB=$RELATIONS_DB_ARRAY[$tab];
	    //pr($relTAB);
	    for($i=0;$i<count($relTAB);$i++)
	    {
		//echo'<p><b>'.$relTAB[$i][rel].'</b> -  '.$relTAB[$i][tab].'</p>';
		if($relTAB[$i][rel]=="many-to-many")
		{
		    $TAB2=$relTAB[$i][tab];
		    $TAB2_ID="id_".$TAB2;
		    $TAB1_ID="id_".$tab;
		    $ARRAY_ID_FOR_REL_TAB=$data[$TAB2_ID];
			
			
			//pr($ARRAY_ID_FOR_REL_TAB);
			
			
		    
		    //echo'<p>'.$relTAB[$i][tab].' - '.$TAB2_ID.'</p>';
		    /***********************************************************
		    *
		    *	M a n y  -  T o  -  M a n y
		    *	
		    *	Here it is a many-to-many REL
		    *	Let's check if there is an array for the $TAB2_ID
		    *
		    *	
		    *	
		    ***********************************************************/
			//pr($data[$TAB2_ID]);
			if(is_array($ARRAY_ID_FOR_REL_TAB))
			{
			    /*
				
				In this case need $id
				
			    */
				
			    if(empty($id))
			    {
				echo '<p>ERROR: an <b>id</b> must be set! on: <i>dbAction::_update</i> </p>';
				return false;
			    }
				
			    $TAB_REL=$tab."_".$TAB2;
			    //$ARRAY_ID_FOR_REL_TAB=$data[$TAB2_ID];
			    /*
			        
			    a) Delete all rel for $TAB1_ID
				
			    */
			    //echo '<p>delete from '.$TAB_REL.' WHERE '.$TAB1_ID.'='.$id.' </p>';
			    _delete($TAB_REL,"1"," WHERE ".$TAB1_ID."='".$id."'");
				
				
			    for($ii=0;$ii<count($ARRAY_ID_FOR_REL_TAB);$ii++)
			    {
				if(!empty($ARRAY_ID_FOR_REL_TAB[$ii]))
				{
				//echo'<p>INSERT into '.$TAB_REL.'  ('.$TAB1_ID.','.$TAB2_ID.') VALUES (\''.$id.'\', \''.$ARRAY_ID_FOR_REL_TAB[$ii].'\'); </p>';
				//array('tab'=>$tab,'id'=>$id,'data'=>$data,'only_this_fileds'=>$only_this_fileds,'echo'=>'0');
				$insRel=dbAction::_insert(array('tab'=>$TAB_REL,'data'=>array($TAB1_ID=>$id,$TAB2_ID=>$ARRAY_ID_FOR_REL_TAB[$ii]),'echo'=>'0'));
				if(!$insRel) return false;
				}
			    }
			}
			
		}
	    }
	    
	}	
	return true;
    } //End F. _relations





    
    
    
    
    
    
    
    
    
    
    function slug($a,$campi,$data,$tab,$id=null)
    {
		/*
	    S L U G 
	    Special Function for Slug
	    * * *
	    
	    Looking first if 'slug' field is in the field for the table
	    and second if isset on data if is not make a new slug
	    checking for existing one...
	*/
	    //If slug is in campi
	    //pr($campi);
	    if(isset($campi['slug']))
	    {
		if(empty($data['slug']))
		{
		    //ERROR IF make_slug_from is empty
		    if(empty($a['make_slug_from']))
		    {
			if($a['echo'])
			{
			    echo'<p>no ID or WHERE are present</p>';
			    echo '<p><b>make_slug_from</b> var can not be empty</p>';
			}
			return false;
		    }
		    
		    /*
			Creating a new slug
			---
			1. check for possible duplicated key
		    */
			if(empty($data['slug']))
			{
			    if(is_array($a['make_slug_from']))
			    {
				
				$make_slug_from_VAR="";
				foreach($a['make_slug_from'] as $msfI=>$msfV)
				{
				    //pr($msfI.'-'.$msfV);
				    //Check if is field or text
				    if(substr($msfV,0,1)=="#")
				    {
					//IS FIELDS
					$msfV=str_replace("#","",$msfV);
				        $make_slug_from_VAR.=$data[$msfV];
				    }
				    else
				    {
					//IS JUST TEXT
					$make_slug_from_VAR.=$msfV;
				    }
				}
				//pr($make_slug_from_VAR);
				//pr($a['make_slug_from']);exit;
			    }
			    else
			    {
				$make_slug_from_VAR=$data[$a['make_slug_from']];
			    }
			    //pr($slug);exit;
			    $slug=slug($make_slug_from_VAR);
			}
			else
			{
			    $slug=slug($data['slug']);
			}
			//echo 'AAA '.$slug;
			for($i=0;$i>-1;$i++)
			{
				
			    // Set $slug_to_check whit a numeric progressive add "_$i"
			    $slug_to_check=$slug;
			    if($i!="0") $slug_to_check=$slug."_".$i;
			/*
			    
			    Check if the slug exists
			    
			*/
			    
			if(!empty($id)) { $ADD_W=" AND id!='".$id."' "; } else {$ADD_W="";}
			    
			$slug_exists=dbAction::_record(array('tab'=>$tab,'field'=>'slug','value'=>$slug_to_check,'add_w'=>$ADD_W,'echo'=>'0'));
			    /*
				
				So, if not exists, set $slug_to_use 
				aninsert a break;
				
			    */
			    if(!$slug_exists)
			    {
				$slug_to_use=$slug_to_check;
				break;
			    }
			}
		    //Here i have a $slug_to_use var
		    //Lets init for the _update
		    $data['slug']=$slug_to_use;
			
		}
	    }
	return $data;
    } //End f slug

}
?>