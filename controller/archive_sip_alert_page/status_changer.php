<?php

	$id = $_POST["id"];
	$toggle = $_POST["toggle"];
	header('Content-type:application/json');

	$db_charset = 'AL32UTF8';
	$conn = oci_connect('UNI_TRAFFIC', '123456oracle', "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.21.64.190)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = 
	UFMS)))",$db_charset);
	if($toggle == 'action'){
		$stid = oci_parse($conn, "UPDATE SIP_ALERT SET STATUS = 1 WHERE ALERT_ID = ".$id."");
	}	
	else if($toggle == 'reverse'){
		$stid = oci_parse($conn, "UPDATE SIP_ALERT SET STATUS = 0 WHERE ALERT_ID = ".$id."");
	}
	oci_execute($stid);
	oci_free_statement($stid);
	oci_close($conn);
	
?>
