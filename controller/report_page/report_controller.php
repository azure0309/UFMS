<?php

	$from = $_POST["from_date"];
	$to = $_POST["to_date"];

	header('Content-type:application/json');

	$db_charset = 'AL32UTF8';
	$conn = oci_connect('UNI_TRAFFIC', '123456oracle', "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.21.64.190)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = 
	UFMS)))",$db_charset);
	$stid = oci_parse($conn, "CALL PHPREPORT(:from_date, :to_date)");
	$stid2 = oci_parse($conn, "CALL PHPREPORT2(:from_date, :to_date)");
	oci_bind_by_name($stid, ':from_date', $from);
	oci_bind_by_name($stid, ':to_date', $to);
	oci_bind_by_name($stid2, ':from_date', $from);
	oci_bind_by_name($stid2, ':to_date', $to);



	oci_execute($stid);
	oci_execute($stid2);


	oci_free_statement($stid);
	oci_free_statement($stid2);
	oci_close($conn);
	
	print "done";
?>
