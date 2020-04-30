<?php

	$first = $_POST["first"];
	$last = $_POST["last"];
	$from = $_POST["from"];

	$data = array();
	$trunkNames = array();

	header('Content-type:application/json');

	$db_charset = 'AL32UTF8';
	$conn = oci_connect('UNI_TRAFFIC', '123456oracle', "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.21.64.190)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = 
	UFMS)))",$db_charset);
	if (!$conn) {
	   $m = error_reporting(E_ALL);
	   echo $m['message'], "\n";
	   exit;
	}

	$dist = oci_parse($conn, "SELECT DISTINCT NAME FROM OD_TRUNK");
	oci_execute($dist);

	while($row = oci_fetch_array($dist, OCI_ASSOC+OCI_RETURN_NULLS)){
		array_push($trunkNames, array('NAME' => $row["NAME"], 'SUCCESS' => 0, 'ATTEMPT' => 0));
	}
	
	oci_free_statement($dist);	
	if($from == 'IN'){
		//Do Something
		$stid = oci_parse($conn, "SELECT TRUNK_NAME, TRUNK_IN, TRUNK_IN_ATTEMPT 
		FROM OD_DETAILED_TRUNK 
		WHERE TRUNK_ID BETWEEN :first AND :last ORDER BY TRUNK_ID ASC");
		oci_bind_by_name($stid, ':first', $first);
		oci_bind_by_name($stid, ':last', $last);
	}
	else if($from == 'OUT'){
		//Do Something else
		$stid = oci_parse($conn, "SELECT TRUNK_NAME, TRUNK_OUT, TRUNK_OUT_ATTEMPT 
		FROM OD_DETAILED_TRUNK 
		WHERE TRUNK_ID BETWEEN :first AND :last ORDER BY TRUNK_ID ASC");
		oci_bind_by_name($stid, ':first', $first);
		oci_bind_by_name($stid, ':last', $last);
	}

	oci_execute($stid);
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
		for($i = 0; $i < count($trunkNames); $i++){
			if($trunkNames[$i]["NAME"] == $row["TRUNK_NAME"] && $from == 'IN'){
				$trunkNames[$i]["SUCCESS"] += $row["TRUNK_IN"];
				$trunkNames[$i]["ATTEMPT"] += $row["TRUNK_IN_ATTEMPT"];
			}
			else if($trunkNames[$i]["NAME"] == $row["TRUNK_NAME"] && $from == 'OUT'){
				$trunkNames[$i]["SUCCESS"] += $row["TRUNK_OUT"];
				$trunkNames[$i]["ATTEMPT"] += $row["TRUNK_OUT_ATTEMPT"];
			}				
		}
	}

	oci_free_statement($stid);
	oci_close($conn);

	print json_encode($trunkNames);

?>
