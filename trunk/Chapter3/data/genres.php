<?php

Include('../../cfg/db.php');

$sql = "SELECT * FROM genres";
$arr = array();

If (!$rs = mysql_query($sql)) {

	Echo '{success:false}';

}else{
	
	while($obj = mysql_fetch_object($rs)){
		$arr[] = $obj;
	}

	Echo '{success:true,rows:'.json_encode($arr).'}';

}

?>
