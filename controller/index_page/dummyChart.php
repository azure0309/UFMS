<?php
	header('Content-type:application/json');

	$db_charset = 'AL32UTF8';
	$conn = oci_connect('UNI_TRAFFIC', '123456oracle', "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.21.64.190)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = 
	UFMS)))",$db_charset);
	$stid = oci_parse($conn, "SELECT TRUNK_ID,TRUNK_OUT, TRUNK_OUT_ATTEMPT, TRUNK_IN, TRUNK_IN_ATTEMPT, TO_CHAR(TRUNK_DATE, 'MM-DD-YYYY HH24:MI:SS') TRUNK_DATE FROM OD_GENERAL_TRUNK WHERE TRUNK_DATE > SYSDATE - 1/4 ORDER BY TRUNK_ID ASC");
	$data = array();
	$returnArray = array();

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
	
	$length = count($data);

	if($length > 23){
		for($o = $length - 24; $o < $length; $o++){
			$returnArray[] = $data[$o];
		}
		print json_encode($returnArray);
	}
	else{
		print json_encode($data);
	}
?>
