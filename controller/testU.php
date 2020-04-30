<?php
	/*
	SELECT
		to_char(max(invitetime),'YYYY-MM-DD HH24:MI:SS') from od_call2
		where invitetime>sysdate-1/6
	*/
$db_charset = 'AL32UTF8';
	$conn = oci_connect('UNI_TRAFFIC', '123456oracle', "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.21.64.190)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = 
	UFMS)))",$db_charset);

	$stid = ociparse($conn, "
		select *  from sip_log
		where logdate > sysdate -1/24
");
	
	$data = [];

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
	
	var_dump($data);
?>
