<?php
	$whichOne = $_POST['from'];
	$iorc = $_POST['iorc'];
	// $whichOne = "to";
	// $iorc = "call";

	$db_charset = 'AL32UTF8';
	$conn = oci_connect('UNI_TRAFFIC', '123456oracle', "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.21.64.190)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = 
	UFMS)))",$db_charset);

	if($whichOne == "src" && $iorc == "ip_addr"){
		$compiled = oci_parse($conn, "SELECT DISTINCT SRC FROM SIP_CALL ORDER BY SRC ASC");
	}else if($whichOne == "dst" && $iorc == "ip_addr"){
		$compiled = oci_parse($conn, "SELECT DISTINCT DST FROM SIP_CALL ORDER BY DST ASC");
	}
	
	$returnData = array();
	$data = array();

	if (!$conn) {
	   $m = error_reporting(E_ALL);
	   echo $m['message'], "\n";
	   exit;
	}
	else {
	   	oci_execute($compiled);
		while ($row = oci_fetch_array($compiled, OCI_ASSOC+OCI_RETURN_NULLS)) {
		    $data[] = $row;
		}
	}
	
	oci_free_statement($compiled);
	oci_close($conn);
	// $returnData = array_unique($data, SORT_REGULAR);
	// $renumbered = array_merge($returnData, array());
	
	print json_encode($data);	

?>
