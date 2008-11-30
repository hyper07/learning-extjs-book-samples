<?php

$start     = ($_REQUEST['start'] != '') ? $_REQUEST['start'] : 0;
$limit     = ($_REQUEST['limit'] != '') ? $_REQUEST['limit'] : 3;

$dir       = ($_REQUEST['dir']   != '') ? $_REQUEST['dir']   : 'asc';
$sort      = ($_REQUEST['sort']  != '') ? $_REQUEST['sort']  : 'title';

Include('../cfg/db.php');

$count_sql = "SELECT * FROM movies ORDER BY ".$sort." ".$dir;
$sql = $count_sql . " LIMIT ".$start.", ".$limit;
$arr = array();

If (!$rs = mysql_query($sql)) {

	Echo '{success:false}';

}else{
	
	$rs_count = mysql_query($count_sql);
	$results = mysql_num_rows($rs_count);
	
	while($obj = mysql_fetch_object($rs)){
		$arr[] = $obj;
	}

	Echo '{success:true,results:'.$results.',rows:'.json_encode($arr).'}';

}

?>
