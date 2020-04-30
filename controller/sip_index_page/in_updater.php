<?php

	header('Content-type:application/json');

	$db_charset = 'AL32UTF8';
	$conn = oci_connect('UNI_TRAFFIC', '123456oracle', "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.21.64.190)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = 
	UFMS)))",$db_charset);
	$stid = oci_parse($conn, "SELECT TRUNK_ID, TRUNK_IN, TRUNK_OUT, ISCHECKED_IN,TO_CHAR(TRUNK_DATE,'MM-DD-YYYY HH24:MI:SS') TRUNK_DATE, TRUNK_OUT_ATTEMPT, TRUNK_IN_ATTEMPT FROM SIP_GENERAL_TRUNK WHERE ISCHECKED_IN = 'N' ORDER BY TRUNK_ID ASC");
	$data = array();

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
	// for($i = 0; $i < count($data); $i++){
	// 	if(strcmp($data[$i]["ISCHECKED_IN"],'N') == 0){
	// 		$stid = oci_parse($conn, "UPDATE OD_GENERAL_TRUNK SET ISCHECKED_IN = 'Y' WHERE TRUNK_ID = :t_id");
	// 		oci_bind_by_name($stid, ':t_id', $data[$i]["TRUNK_ID"]);
	// 		oci_execute($stid, OCI_COMMIT_ON_SUCCESS);
	// 		oci_free_statement($stid);
	// 	}
	// }
	oci_close($conn);


	print json_encode($data);

?>
