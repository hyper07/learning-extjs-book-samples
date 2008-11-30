<?php

Include('../cfg/db.php');

$action  = ($_REQUEST['action'] != '') ? $_REQUEST['action'] : 'update';

Switch ($action){
	Case 'update':
		$sql = "UPDATE movies SET ".$_REQUEST['field']." = '".$_REQUEST['value']."' WHERE id = ".$_REQUEST['id'];
	Break;
	Case 'insert':
		$sql = "INSERT INTO movies (id,title,director,genre,tagline) VALUES (0,'".$_REQUEST['title']."','',0,'')";
	Break;
	Case 'delete':
		$sql = "DELETE FROM movies WHERE id = ".$_REQUEST['id'];
	Break;
}

If (!$rs = mysql_query($sql)) {

	Echo '{success:false}';

}else{
	
	if ($_REQUEST['action'] == 'insert'){
		Echo '{success:true,insert_id:'.mysql_insert_id().'}';
	}else{
		Echo '{success:true}';
	}
	
}

?>
