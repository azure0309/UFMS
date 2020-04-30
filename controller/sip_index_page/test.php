<?php
	
	$in_or_out = $_POST["io"];
	$global_id = $_POST["id"];

	$db_charset = 'AL32UTF8';
	$conn = oci_connect('UNI_TRAFFIC', '123456oracle', "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.21.64.190)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = 
	UFMS)))",$db_charset);

	$stid = oci_parse($conn, "SELECT * FROM OD_DETAILED_TRUNK WHERE TRUNK_ID = :global_id");
	oci_bind_by_name($stid, ':global_id', $global_id);
	$data = [];
	$in = [];
	$out = [];	

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
	
	for($i = 0; $i < sizeof($data); $i++){
		if($data[$i]["TRUNK_IN"] != 0){
			array_push($in, array('TRUNK_NAME' => $data[$i]["TRUNK_NAME"],'TRUNK_IN' => $data[$i]["TRUNK_IN"]));
		}
		if($data[$i]["TRUNK_OUT"] != 0){
			array_push($out, array('TRUNK_NAME' => $data[$i]["TRUNK_NAME"],'TRUNK_OUT' => $data[$i]["TRUNK_OUT"]));
		}
	}

	//echo $data[2]["TRUNK_ID"];

	if(strcmp($in_or_out, 'in') == 0){
		print json_encode($in);
	}
	else{
		print json_encode($out);
	}
?>
