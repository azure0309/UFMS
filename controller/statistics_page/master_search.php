<?php
	
	$db_charset = 'AL32UTF8';
	$conn = oci_connect('UNI_TRAFFIC', '123456oracle', "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.21.64.190)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = 
	UFMS)))",$db_charset);

	$stid = oci_parse($conn, "SELECT SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, 
		TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
		TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
		FROM OD_CALL2 WHERE INVITETIME > SYSDATE - 1/24/60 ORDER BY DST DESC");

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

		    $splittedArg1 = explode(".", $row["SRC"]);
			$splittedArg2 = explode(".", $row["DST"]);
			$ipNumberArg1 = $splittedArg1[0]*16777216 + $splittedArg1[1]*65536 + $splittedArg1[2]*256 + $splittedArg1[3];
			$ipNumberArg2 = $splittedArg2[0]*16777216 + $splittedArg2[1]*65536 + $splittedArg2[2]*256 + $splittedArg2[3];
			
			/*CLEAR ARRAY!*/
			unset($splittedArg1);
			unset($splittedArg2);
			$splittedArg1 = array();
			$splittedArg2 = array();

		    $sql = "SELECT country_code, country_name FROM geoipcountry WHERE :ipNumberArg1 BETWEEN begin_ip_num AND end_ip_num";
			$compiled = oci_parse($conn, $sql);

			oci_bind_by_name($compiled, ':ipNumberArg1', $ipNumberArg1);
			oci_execute($compiled);

			while ($row = oci_fetch_array($compiled, OCI_ASSOC+OCI_RETURN_NULLS)) {
			    $dataSrc[] = $row;
			}
			oci_free_statement($compiled);

			$sql = "SELECT country_code, country_name FROM geoipcountry WHERE :ipNumberArg2 BETWEEN begin_ip_num AND end_ip_num";
			$compiled = oci_parse($conn, $sql);

			oci_bind_by_name($compiled, ':ipNumberArg2', $ipNumberArg2);
			oci_execute($compiled);

			while ($row = oci_fetch_array($compiled, OCI_ASSOC+OCI_RETURN_NULLS)) {
			    $dataDst[] = $row;
			}
			oci_free_statement($compiled);
		}
	}
	
	oci_free_statement($stid);
	oci_close($conn);
	
	for($i = 0; $i < count($data); $i++){
		$returnArray[] = array(
			"SRC" => $data[$i]["SRC"], "DST" => $data[$i]["DST"], 
			"CALLFROM" => $data[$i]["CALLFROM"], "CALLTO" => $data[$i]["CALLTO"], "RING" => $data[$i]["RING"], 
			"ANSWER" => $data[$i]["ANSWER"], "BYE", $data[$i]["BYE"], "INVITETIME" => $data[$i]["INVITETIME"], 
			"ANSWERTIME" => $data[$i]["ANSWERTIME"], "BYETIME" => $data[$i]["BYETIME"], "DURATION" => $data[$i]["DURATION"],"STATUS" => $data[$i]["STATUS"],
			"SOURCE_COUNTRY_NAME" => $dataSrc[$i]["COUNTRY_NAME"], "DST_COUNTRY_NAME" => $dataDst[$i]["COUNTRY_NAME"],
			"SOURCE_COUNTRY_CODE" => $dataSrc[$i]["COUNTRY_CODE"], "DST_COUNTRY_CODE" => $dataDst[$i]["COUNTRY_CODE"]
		); 
		$country = $i;
	}

	print json_encode($returnArray);	
	//print json_encode($country);

?>
