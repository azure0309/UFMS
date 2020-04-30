<?php

	header('Content-type:application/json');

	$db_charset = 'AL32UTF8';
	$conn = oci_connect('UNI_TRAFFIC', '123456oracle', "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.21.64.190)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = 
	UFMS)))",$db_charset);
	$stid = oci_parse($conn, "SELECT ALERT_ID,STATUS,TYPE, ARG1, ARG2, ARG3, ARG4, ARG5, ARG6, CONTENT, TO_CHAR(CREATED,'MM-DD-YYYY HH24:MI:SS') CREATED, LVL FROM SIP_ALERT WHERE CREATED > SYSDATE - 1  ORDER BY ALERT_ID DESC");
	$data = array();
	$returnArray = array();
	
	$splittedArg1 = array();
	$splittedArg2 = array();

	$dataSrc = array();	
	$dataDst = array();	

	$counter = 0;

	if (!$conn) {
	   $m = error_reporting(E_ALL);
	   echo $m['message'], "\n";
	   exit;
	}
	else {
	   	oci_execute($stid);
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
		    
		    $data[] = $row;

		}

	}
	oci_free_statement($stid);
	oci_close($conn);
	
	// print json_encode($data);
	// print json_encode($dataSrc);
	// print json_encode($dataDst);

	print json_encode($data);

?>
