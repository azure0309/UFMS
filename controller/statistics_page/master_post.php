<?php
	
	set_time_limit(300); 
	$from_date = $_POST["from_date"];
	$to_date = $_POST["to_date"];
	$src_ip = $_POST["src_ip"];
	$dst_ip = $_POST["dst_ip"];
	$call_from = $_POST["call_from"];
	$call_to = $_POST["call_to"];
	$ring = $_POST["ring"];
	$answer = $_POST["answer"];
	$bye = $_POST["bye"];
	$min_dur = $_POST["min_dur"];
	$max_dur = $_POST["max_dur"];

	// $from_date = '12-01-2015 12:04';
	// $to_date = '12-03-2015 12:04';
	// $call_from = '';
	// $call_to = 'null';

	// $src_ip = '';
	// $dst_ip = '';
	// $ring = '(RING IS NULL OR RING IS NOT NULL)';
	// $answer = '(ANSWER IS NULL OR ANSWER IS NOT NULL)';
	// $bye = '(BYE IS NULL OR BYE IS NOT NULL)';
	// $min_dur = '';
	// $max_dur = '';

	$db_charset = 'AL32UTF8';
	$conn = oci_connect('UNI_TRAFFIC', '123456oracle', "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.21.64.190)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = 
	UFMS)))",$db_charset);

	if($call_to == 'null' && $call_from == 'null'){
		if(empty($min_dur) && empty($max_dur)){
			$sql = "SELECT  CALL_ID_SIP, CALL_ID, SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
			TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
			FROM OD_CALL2 
			WHERE ".$ring." AND ".$answer." AND ".$bye." AND SRC LIKE '%".$src_ip."%' AND DST LIKE '%".$dst_ip."%' AND CALLFROM IS NULL AND 
			CALLTO IS NULL AND 
			INVITETIME BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY CALL_ID DESC";
			
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':from_date', $from_date);
			oci_bind_by_name($stid, ':to_date', $to_date);
		}
		else if(!empty($min_dur) && empty($max_dur)){
			$sql = "SELECT  CALL_ID_SIP, CALL_ID, SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
			TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
			FROM OD_CALL2 
			WHERE ".$ring." AND ".$answer." AND ".$bye." AND SRC LIKE '%".$src_ip."%' AND DST LIKE '%".$dst_ip."%' AND CALLFROM IS NULL AND 
			CALLTO IS NULL AND DURATION > ".$min_dur." AND
			INVITETIME BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY CALL_ID DESC";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':from_date', $from_date);
			oci_bind_by_name($stid, ':to_date', $to_date);
		}
		else if(empty($min_dur) && !empty($max_dur)){
			$sql = "SELECT  CALL_ID_SIP, CALL_ID, SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
			TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
			FROM OD_CALL2 
			WHERE ".$ring." AND ".$answer." AND ".$bye." AND SRC LIKE '%".$src_ip."%' AND DST LIKE '%".$dst_ip."%' AND CALLFROM IS NULL AND 
			CALLTO IS NULL AND DURATION < ".$max_dur." AND
			INVITETIME BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY CALL_ID DESC";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':from_date', $from_date);
			oci_bind_by_name($stid, ':to_date', $to_date);
		}
		else{
			$sql = "SELECT  CALL_ID_SIP, CALL_ID, SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
			TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
			FROM OD_CALL2 
			WHERE ".$ring." AND ".$answer." AND ".$bye." AND SRC LIKE '%".$src_ip."%' AND DST LIKE '%".$dst_ip."%' AND CALLFROM IS NULL AND 
			CALLTO IS NULL AND DURATION < ".$max_dur." AND DURATION > ".$min_dur." AND
			INVITETIME BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY CALL_ID DESC";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':from_date', $from_date);
			oci_bind_by_name($stid, ':to_date', $to_date);	
		}
	}
	else if($call_to != 'null' && $call_from == 'null'){
		if(empty($min_dur) && empty($max_dur)){
			$sql = "SELECT  CALL_ID_SIP, CALL_ID, SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
			TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
			FROM OD_CALL2 
			WHERE ".$ring." AND ".$answer." AND ".$bye." AND SRC LIKE '%".$src_ip."%' AND DST LIKE '%".$dst_ip."%' AND CALLFROM IS NULL AND 
			CALLTO LIKE '%".$call_to."%' AND 
			INVITETIME BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY CALL_ID DESC";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':from_date', $from_date);
			oci_bind_by_name($stid, ':to_date', $to_date);
		}
		else if(!empty($min_dur) && empty($max_dur)){
			$sql = "SELECT  CALL_ID_SIP, CALL_ID, SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
			TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
			FROM OD_CALL2 
			WHERE ".$ring." AND ".$answer." AND ".$bye." AND SRC LIKE '%".$src_ip."%' AND DST LIKE '%".$dst_ip."%' AND CALLFROM IS NULL AND 
			CALLTO LIKE '%".$call_to."%' AND DURATION > ".$min_dur." AND
			INVITETIME BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY CALL_ID DESC";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':from_date', $from_date);
			oci_bind_by_name($stid, ':to_date', $to_date);
		}
		else if(empty($min_dur) && !empty($max_dur)){
			$sql = "SELECT  CALL_ID_SIP, CALL_ID, SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
			TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
			FROM OD_CALL2 
			WHERE ".$ring." AND ".$answer." AND ".$bye." AND SRC LIKE '%".$src_ip."%' AND DST LIKE '%".$dst_ip."%' AND CALLFROM IS NULL AND 
			CALLTO LIKE '%".$call_to."%' AND DURATION < ".$max_dur." AND
			INVITETIME BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY CALL_ID DESC";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':from_date', $from_date);
			oci_bind_by_name($stid, ':to_date', $to_date);
		}
		else{
			$sql = "SELECT  CALL_ID_SIP, CALL_ID, SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
			TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
			FROM OD_CALL2 
			WHERE ".$ring." AND ".$answer." AND ".$bye." AND SRC LIKE '%".$src_ip."%' AND DST LIKE '%".$dst_ip."%' AND CALLFROM IS NULL AND 
			CALLTO LIKE '%".$call_to."%' AND DURATION < ".$max_dur." AND DURATION > ".$min_dur." AND
			INVITETIME BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY CALL_ID DESC";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':from_date', $from_date);
			oci_bind_by_name($stid, ':to_date', $to_date);	
		}
	}
	else if($call_to == 'null' && $call_from != 'null'){
		if(empty($min_dur) && empty($max_dur)){
			$sql = "SELECT  CALL_ID_SIP, CALL_ID, SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
			TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
			FROM OD_CALL2 
			WHERE ".$ring." AND ".$answer." AND ".$bye." AND SRC LIKE '%".$src_ip."%' AND DST LIKE '%".$dst_ip."%' AND CALLFROM LIKE '%".$call_from."%' AND 
			CALLTO IS NULL AND 
			INVITETIME BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY CALL_ID DESC";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':from_date', $from_date);
			oci_bind_by_name($stid, ':to_date', $to_date);
			//echo $sql;
		}
		else if(!empty($min_dur) && empty($max_dur)){
			$sql = "SELECT  CALL_ID_SIP, CALL_ID, SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
			TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
			FROM OD_CALL2 
			WHERE ".$ring." AND ".$answer." AND ".$bye." AND SRC LIKE '%".$src_ip."%' AND DST LIKE '%".$dst_ip."%' AND CALLFROM LIKE '%".$call_from."%' AND 
			CALLTO IS NULL AND DURATION > ".$min_dur." AND
			INVITETIME BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY CALL_ID DESC";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':from_date', $from_date);
			oci_bind_by_name($stid, ':to_date', $to_date);
		}
		else if(empty($min_dur) && !empty($max_dur)){
			$sql = "SELECT  CALL_ID_SIP, CALL_ID, SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
			TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
			FROM OD_CALL2 
			WHERE ".$ring." AND ".$answer." AND ".$bye." AND SRC LIKE '%".$src_ip."%' AND DST LIKE '%".$dst_ip."%' AND CALLFROM LIKE '%".$call_from."%' AND 
			CALLTO IS NULL AND DURATION < ".$max_dur." AND
			INVITETIME BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY CALL_ID DESC";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':from_date', $from_date);
			oci_bind_by_name($stid, ':to_date', $to_date);
		}
		else{
			$sql = "SELECT  CALL_ID_SIP, CALL_ID, SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
			TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
			FROM OD_CALL2 
			WHERE ".$ring." AND ".$answer." AND ".$bye." AND SRC LIKE '%".$src_ip."%' AND DST LIKE '%".$dst_ip."%' AND CALLFROM LIKE '%".$call_from."%' AND 
			CALLTO IS NULL AND DURATION < ".$max_dur." AND DURATION > ".$min_dur." AND
			INVITETIME BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY CALL_ID DESC";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':from_date', $from_date);
			oci_bind_by_name($stid, ':to_date', $to_date);	
		}
	}
	else{
		if(empty($min_dur) && empty($max_dur)){
			$sql = "SELECT  CALL_ID_SIP, CALL_ID, SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
			TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
			FROM OD_CALL2 
			WHERE ".$ring." AND ".$answer." AND ".$bye." AND SRC LIKE '%".$src_ip."%' AND DST LIKE '%".$dst_ip."%' AND CALLFROM LIKE '%".$call_from."%' AND 
			CALLTO LIKE '%".$call_to."%' AND 
			INVITETIME BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY CALL_ID DESC";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':from_date', $from_date);
			oci_bind_by_name($stid, ':to_date', $to_date);
		}
		else if(!empty($min_dur) && empty($max_dur)){
			$sql = "SELECT  CALL_ID_SIP, CALL_ID, SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
			TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
			FROM OD_CALL2 
			WHERE ".$ring." AND ".$answer." AND ".$bye." AND SRC LIKE '%".$src_ip."%' AND DST LIKE '%".$dst_ip."%' AND CALLFROM LIKE '%".$call_from."%' AND 
			CALLTO LIKE '%".$call_to."%' AND DURATION > ".$min_dur." AND
			INVITETIME BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY CALL_ID DESC";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':from_date', $from_date);
			oci_bind_by_name($stid, ':to_date', $to_date);
		}
		else if(empty($min_dur) && !empty($max_dur)){
			$sql = "SELECT  CALL_ID_SIP, CALL_ID, SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
			TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
			FROM OD_CALL2 
			WHERE ".$ring." AND ".$answer." AND ".$bye." AND SRC LIKE '%".$src_ip."%' AND DST LIKE '%".$dst_ip."%' AND CALLFROM LIKE '%".$call_from."%' AND 
			CALLTO LIKE '%".$call_to."%' AND DURATION < ".$max_dur." AND
			INVITETIME BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY CALL_ID DESC";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':from_date', $from_date);
			oci_bind_by_name($stid, ':to_date', $to_date);
		}
		else{
			$sql = "SELECT  CALL_ID_SIP, CALL_ID, SRC, DST, CALLFROM, CALLTO, RING, ANSWER, BYE, TO_CHAR(INVITETIME,'MM-DD-YYYY HH24:MI:SS') INVITETIME, TO_CHAR(ANSWERTIME,'MM-DD-YYYY HH24:MI:SS') ANSWERTIME,
			TO_CHAR(BYETIME,'MM-DD-YYYY HH24:MI:SS') BYETIME, DURATION, STATUS
			FROM OD_CALL2 
			WHERE ".$ring." AND ".$answer." AND ".$bye." AND SRC LIKE '%".$src_ip."%' AND DST LIKE '%".$dst_ip."%' AND CALLFROM LIKE '%".$call_from."%' AND 
			CALLTO LIKE '%".$call_to."%' AND DURATION < ".$max_dur." AND DURATION > ".$min_dur." AND
			INVITETIME BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY CALL_ID DESC";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':from_date', $from_date);
			oci_bind_by_name($stid, ':to_date', $to_date);	
		}
	}

	

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
		}
	}
	
	oci_free_statement($stid);
	oci_close($conn);

	print json_encode($data);	
	

?>
