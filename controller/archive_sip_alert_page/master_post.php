<?php
	
	set_time_limit(300); 
	$from_date = $_POST["from_date"];
	$to_date = $_POST["to_date"];
	$type = $_POST["type"];

	$db_charset = 'AL32UTF8';
	$conn = oci_connect('UNI_TRAFFIC', '123456oracle', "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.21.64.190)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = 
	UFMS)))",$db_charset);

	$sql = "SELECT ALERT_ID,STATUS,LVL,TYPE, ARG1, ARG2, ARG3, ARG4, ARG5, ARG6, CONTENT, TO_CHAR(CREATED,'MM-DD-YYYY HH24:MI:SS') CREATED
		FROM SIP_ALERT 
		WHERE TYPE LIKE '%".$type."%' AND
		CREATED BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY ALERT_ID DESC";
	$stid = oci_parse($conn, $sql);
	oci_bind_by_name($stid, ':from_date', $from_date);
	oci_bind_by_name($stid, ':to_date', $to_date);

	$returnData = array();
	$data = array();

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

		 //    $splittedArg1 = explode(".", $row["ARG1"]);
			// $splittedArg2 = explode(".", $row["ARG2"]);
			// $ipNumberArg1 = $splittedArg1[0]*16777216 + $splittedArg1[1]*65536 + $splittedArg1[2]*256 + $splittedArg1[3];
			// $ipNumberArg2 = $splittedArg2[0]*16777216 + $splittedArg2[1]*65536 + $splittedArg2[2]*256 + $splittedArg2[3];
			
			// /*CLEAR ARRAY!*/
			// unset($splittedArg1);
			// unset($splittedArg2);
			// $splittedArg1 = array();
			// $splittedArg2 = array();

		 //    $sql = "SELECT country_code, country_name FROM geoipcountry WHERE :ipNumberArg1 BETWEEN begin_ip_num AND end_ip_num";
			// $compiled = oci_parse($conn, $sql);

			// oci_bind_by_name($compiled, ':ipNumberArg1', $ipNumberArg1);
			// oci_execute($compiled);

			// while ($row = oci_fetch_array($compiled, OCI_ASSOC+OCI_RETURN_NULLS)) {
			//     $dataSrc[] = $row;
			// }
			// oci_free_statement($compiled);

			// $sql = "SELECT country_code, country_name FROM geoipcountry WHERE :ipNumberArg2 BETWEEN begin_ip_num AND end_ip_num";
			// $compiled = oci_parse($conn, $sql);

			// oci_bind_by_name($compiled, ':ipNumberArg2', $ipNumberArg2);
			// oci_execute($compiled);

			// while ($row = oci_fetch_array($compiled, OCI_ASSOC+OCI_RETURN_NULLS)) {
			//     $dataDst[] = $row;
			// }
			// oci_free_statement($compiled);

		}
	}
	
	oci_free_statement($stid);
	oci_close($conn);

	// for($i = 0; $i < count($data); $i++){
	// 	$returnArray[] = array(
	// 		"TYPE" => $data[$i]["TYPE"], "SOURCE_IP" => $data[$i]["ARG1"], 
	// 		"DST_IP" => $data[$i]["ARG2"], "CALLFROM" => $data[$i]["ARG4"], "CALLTO" => $data[$i]["ARG5"], 
	// 		"ARG6" => $data[$i]["ARG6"], "CONTENT", $data[$i]["CONTENT"], "CREATED" => $data[$i]["CREATED"], 
	// 		"SOURCE_COUNTRY_NAME" => $dataSrc[$i]["COUNTRY_NAME"], "DST_COUNTRY_NAME" => $dataDst[$i]["COUNTRY_NAME"],
	// 		"SOURCE_COUNTRY_CODE" => $dataSrc[$i]["COUNTRY_CODE"], "DST_COUNTRY_CODE" => $dataDst[$i]["COUNTRY_CODE"]
	// 	); 
	// 	$country = $i;
	// }

	print json_encode($data);	
	

?>
