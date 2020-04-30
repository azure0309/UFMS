<?php
	
	$from = $_POST["from_date"];
	$to = $_POST["to_date"];

	header('Content-type:application/json');

	$db_charset = 'AL32UTF8';
	$conn = oci_connect('UNI_TRAFFIC', '123456oracle', "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.21.64.190)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = 
	UFMS)))",$db_charset);
	$stid = oci_parse($conn, "SELECT TRUNK_ID, TRUNK_IN, TRUNK_OUT,TO_CHAR(TRUNK_DATE,'MM-DD-YYYY HH24:MI:SS') TRUNK_DATE, TRUNK_IN_ATTEMPT, TRUNK_OUT_ATTEMPT, nvl((TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') - TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI')) * 86400,'0') DIFF 
		FROM SIP_GENERAL_TRUNK 
		WHERE TRUNK_DATE BETWEEN TO_DATE(:from_date, 'MM-DD-YYYY HH24:MI') AND TO_DATE(:to_date, 'MM-DD-YYYY HH24:MI') ORDER BY TRUNK_ID ASC");
	oci_bind_by_name($stid, ':from_date', $from);
	oci_bind_by_name($stid, ':to_date', $to);
	$data = array();
	$returnArray = array();

	$in_counter = 0;
	$out_counter = 0;
	$in_attempt_counter = 0;
	$out_attempt_counter = 0;

	$howMany_loop = 0;

	$howMany = 0;

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
	


	if($data[0]["DIFF"] > 300 && $data[0]["DIFF"] <= 10800){
		//0 to 3 hours
		$howMany = round($data[0]["DIFF"] / 300);
		if($howMany > count($data)){
			for($i = 0; $i< $howMany - count($data); $i++){
				array_push($returnArray, array('TRUNK_ID' => null ,'TRUNK_IN' => null, 'TRUNK_OUT' => null, 'TRUNK_DATE' => null, 'TRUNK_IN_ATTEMPT' => null, 'TRUNK_OUT_ATTEMPT' => null));
			}
			for($i = $howMany - count($data); $i < count($data); $i++){
				array_push($returnArray, $data[$i]);
			}
		}
		else if($howMany < count($data)){
			for($i = count($data) - $howMany; $i < count($data); $i++){
				array_push($returnArray, $data[$i]);
			}
		}
		else{
			for($i = 0; $i < count($data); $i++){
				array_push($returnArray, $data[$i]);
			}
		}
		print json_encode($returnArray);
	}
	else if($data[0]["DIFF"] > 10800 && $data[0]["DIFF"] <= 21600){
		//3 to 6 hours
		$howMany = round($data[0]["DIFF"] / 300);
		// if($howMany > count($data)){
		// 	for($i = 0; $i< $howMany - count($data); $i++){
		// 		if($i%2 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_ID' => null ,'TRUNK_IN' => null, 'TRUNK_OUT' => null, 'TRUNK_DATE' => null, 'TRUNK_IN_ATTEMPT' => null, 'TRUNK_OUT_ATTEMPT' => null));
		// 		}
		// 	}
		// 	for($i = $howMany - count($data); $i < count($data); $i++){
		// 		$in_counter += $data[$i]["TRUNK_IN"];
		// 		$out_counter += $data[$i]["TRUNK_OUT"];
		// 		$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
		// 		$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
		// 		if($i%2 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
		// 			$in_counter = 0;
		// 			$out_counter = 0;
		// 			$in_attempt_counter = 0;
		// 			$out_attempt_counter = 0;
		// 		}
		// 	}
		// }
		if($howMany < count($data)){
			for($i = count($data) - $howMany; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%2 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		else{
			for($i = 0; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%2 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		print json_encode($returnArray);
	}
	else if($data[0]["DIFF"] > 21600 && $data[0]["DIFF"] <= 43200){
		//6 to 12 hours
		$howMany = round($data[0]["DIFF"] / 300);
		// if($howMany > count($data)){
		// 	for($i = 0; $i< $howMany - count($data); $i++){
		// 		if($i%4 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_ID' => null ,'TRUNK_IN' => null, 'TRUNK_OUT' => null, 'TRUNK_DATE' => null, 'TRUNK_IN_ATTEMPT' => null, 'TRUNK_OUT_ATTEMPT' => null));
		// 		}
		// 	}
		// 	for($i = $howMany - count($data); $i < count($data); $i++){
		// 		$in_counter += $data[$i]["TRUNK_IN"];
		// 		$out_counter += $data[$i]["TRUNK_OUT"];
		// 		$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
		// 		$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
		// 		if($i%4 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
		// 			$in_counter = 0;
		// 			$out_counter = 0;
		// 			$in_attempt_counter = 0;
		// 			$out_attempt_counter = 0;
		// 		}
		// 	}
		// }
		if($howMany < count($data)){
			for($i = count($data) - $howMany; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%4 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		else{
			for($i = 0; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%4 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		print json_encode($returnArray);
	}
	else if($data[0]["DIFF"] > 43200 && $data[0]["DIFF"] <= 86400){
		//12 to 24 hours
		$howMany = round($data[0]["DIFF"] / 300);
		// if($howMany > count($data)){
		// 	for($i = 0; $i< $howMany - count($data); $i++){
		// 		if($i%6 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_ID' => null ,'TRUNK_IN' => null, 'TRUNK_OUT' => null, 'TRUNK_DATE' => null, 'TRUNK_IN_ATTEMPT' => null, 'TRUNK_OUT_ATTEMPT' => null));
		// 		}
		// 	}
		// 	for($i = $howMany - count($data); $i < count($data); $i++){
		// 		$in_counter += $data[$i]["TRUNK_IN"];
		// 		$out_counter += $data[$i]["TRUNK_OUT"];
		// 		$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
		// 		$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
		// 		if($i%6 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
		// 			$in_counter = 0;
		// 			$out_counter = 0;
		// 			$in_attempt_counter = 0;
		// 			$out_attempt_counter = 0;
		// 		}
		// 	}
		// }
		if($howMany < count($data)){
			for($i = count($data) - $howMany; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%6 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		else{
			for($i = 0; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%6 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		print json_encode($returnArray);
	}
	else if($data[0]["DIFF"] > 86400 && $data[0]["DIFF"] <= 172800){
		//1 to 2 days
		$howMany = $data[0]["DIFF"] / 300;
		// if($howMany > count($data)){
		// 	for($i = 0; $i< $howMany - count($data); $i++){
		// 		if($i%12 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_ID' => null ,'TRUNK_IN' => null, 'TRUNK_OUT' => null, 'TRUNK_DATE' => null, 'TRUNK_IN_ATTEMPT' => null, 'TRUNK_OUT_ATTEMPT' => null));
		// 		}
		// 	}
		// 	for($i = $howMany - count($data); $i < count($data); $i++){
		// 		$in_counter += $data[$i]["TRUNK_IN"];
		// 		$out_counter += $data[$i]["TRUNK_OUT"];
		// 		$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
		// 		$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
		// 		if($i%12 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
		// 			$in_counter = 0;
		// 			$out_counter = 0;
		// 			$in_attempt_counter = 0;
		// 			$out_attempt_counter = 0;
		// 		}
		// 	}
		// }
		if($howMany < count($data)){
			for($i = count($data) - $howMany; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%12 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		else{
			for($i = 0; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%12 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		print json_encode($returnArray);
	}
	else if($data[0]["DIFF"] > 172800 && $data[0]["DIFF"] <= 259200){
		//2 to 3 days
		$howMany = round($data[0]["DIFF"] / 300);
		// if($howMany > count($data)){
		// 	for($i = 0; $i< $howMany - count($data); $i++){
		// 		if($i%24 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_ID' => null ,'TRUNK_IN' => null, 'TRUNK_OUT' => null, 'TRUNK_DATE' => null, 'TRUNK_IN_ATTEMPT' => null, 'TRUNK_OUT_ATTEMPT' => null));
		// 		}
		// 	}
		// 	for($i = $howMany - count($data); $i < count($data); $i++){
		// 		$in_counter += $data[$i]["TRUNK_IN"];
		// 		$out_counter += $data[$i]["TRUNK_OUT"];
		// 		$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
		// 		$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
		// 		if($i%24 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
		// 			$in_counter = 0;
		// 			$out_counter = 0;
		// 			$in_attempt_counter = 0;
		// 			$out_attempt_counter = 0;
		// 		}
		// 	}
		// }
		if($howMany < count($data)){
			for($i = count($data) - $howMany; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%24 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		else{
			for($i = 0; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%24 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		print json_encode($returnArray);
	}else if($data[0]["DIFF"] > 259200 && $data[0]["DIFF"] <= 432000){
		//3 to 5 days
		$howMany = round($data[0]["DIFF"] / 300);
		// if($howMany > count($data)){
		// 	for($i = 0; $i< $howMany - count($data); $i++){
		// 		if($i%36 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_ID' => null ,'TRUNK_IN' => null, 'TRUNK_OUT' => null, 'TRUNK_DATE' => null, 'TRUNK_IN_ATTEMPT' => null, 'TRUNK_OUT_ATTEMPT' => null));
		// 		}
		// 	}
		// 	for($i = $howMany - count($data); $i < count($data); $i++){
		// 		$in_counter += $data[$i]["TRUNK_IN"];
		// 		$out_counter += $data[$i]["TRUNK_OUT"];
		// 		$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
		// 		$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
		// 		if($i%36 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
		// 			$in_counter = 0;
		// 			$out_counter = 0;
		// 			$in_attempt_counter = 0;
		// 			$out_attempt_counter = 0;
		// 		}
		// 	}
		// }
		if($howMany < count($data)){
			for($i = count($data) - $howMany; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%36 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		else{
			for($i = 0; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%36 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		print json_encode($returnArray);
	}else if($data[0]["DIFF"] > 432000 && $data[0]["DIFF"] <= 604800){
		//5 to 7 days
		$howMany = round($data[0]["DIFF"] / 300);
		// if($howMany > count($data)){
		// 	for($i = 0; $i< $howMany - count($data); $i++){
		// 		if($i%72 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_ID' => null ,'TRUNK_IN' => null, 'TRUNK_OUT' => null, 'TRUNK_DATE' => null, 'TRUNK_IN_ATTEMPT' => null, 'TRUNK_OUT_ATTEMPT' => null));
		// 		}
		// 	}
		// 	for($i = $howMany - count($data); $i < count($data); $i++){
		// 		$in_counter += $data[$i]["TRUNK_IN"];
		// 		$out_counter += $data[$i]["TRUNK_OUT"];
		// 		$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
		// 		$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
		// 		if($i%72 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
		// 			$in_counter = 0;
		// 			$out_counter = 0;
		// 			$in_attempt_counter = 0;
		// 			$out_attempt_counter = 0;
		// 		}
		// 	}
		// }
		if($howMany < count($data)){
			for($i = count($data) - $howMany; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%72 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		else{
			for($i = 0; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%72 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		print json_encode($returnArray);
	}else if($data[0]["DIFF"] > 604800 && $data[0]["DIFF"] <= 1209600){
		//7 to 14 days
		$howMany = round($data[0]["DIFF"] / 300);
		// if($howMany > count($data)){
		// 	for($i = 0; $i< $howMany - count($data); $i++){
		// 		if($i%144 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_ID' => null ,'TRUNK_IN' => null, 'TRUNK_OUT' => null, 'TRUNK_DATE' => null, 'TRUNK_IN_ATTEMPT' => null, 'TRUNK_OUT_ATTEMPT' => null));
		// 		}
		// 	}
		// 	for($i = $howMany - count($data); $i < count($data); $i++){
		// 		$in_counter += $data[$i]["TRUNK_IN"];
		// 		$out_counter += $data[$i]["TRUNK_OUT"];
		// 		$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
		// 		$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
		// 		if($i%144 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
		// 			$in_counter = 0;
		// 			$out_counter = 0;
		// 			$in_attempt_counter = 0;
		// 			$out_attempt_counter = 0;
		// 		}
		// 	}
		// }
		if($howMany < count($data)){
			for($i = count($data) - $howMany; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%144 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		else{
			for($i = 0; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%144 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		print json_encode($returnArray);
	}else if($data[0]["DIFF"] > 1209600 && $data[0]["DIFF"] <= 2592000){
		//14 to 30 days
		$howMany = round($data[0]["DIFF"] / 300);
		// if($howMany > count($data)){
		// 	for($i = 0; $i< $howMany - count($data); $i++){
		// 		if($i%288 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_ID' => null ,'TRUNK_IN' => null, 'TRUNK_OUT' => null, 'TRUNK_DATE' => null, 'TRUNK_IN_ATTEMPT' => null, 'TRUNK_OUT_ATTEMPT' => null));
		// 		}
		// 	}
		// 	for($i = $howMany - count($data); $i < count($data); $i++){
		// 		$in_counter += $data[$i]["TRUNK_IN"];
		// 		$out_counter += $data[$i]["TRUNK_OUT"];
		// 		$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
		// 		$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
		// 		if($i%288 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
		// 			$in_counter = 0;
		// 			$out_counter = 0;
		// 			$in_attempt_counter = 0;
		// 			$out_attempt_counter = 0;
		// 		}
		// 	}
		// }
		if($howMany < count($data)){
			for($i = count($data) - $howMany; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%288 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		else{
			for($i = 0; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%288 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		print json_encode($returnArray);
	}else if($data[0]["DIFF"] > 2592000 && $data[0]["DIFF"] <= 7776000){
		//1 to 3 months
		$howMany = round($data[0]["DIFF"] / 300);
		// if($howMany > count($data)){
		// 	for($i = 0; $i< $howMany - count($data); $i++){
		// 		if($i%864 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_ID' => null ,'TRUNK_IN' => null, 'TRUNK_OUT' => null, 'TRUNK_DATE' => null, 'TRUNK_IN_ATTEMPT' => null, 'TRUNK_OUT_ATTEMPT' => null));
		// 		}
		// 	}
		// 	for($i = $howMany - count($data); $i < count($data); $i++){
		// 		$in_counter += $data[$i]["TRUNK_IN"];
		// 		$out_counter += $data[$i]["TRUNK_OUT"];
		// 		$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
		// 		$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
		// 		if($i%864 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
		// 			$in_counter = 0;
		// 			$out_counter = 0;
		// 			$in_attempt_counter = 0;
		// 			$out_attempt_counter = 0;
		// 		}
		// 	}
		// }
		if($howMany < count($data)){
			for($i = count($data) - $howMany; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%864 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		else{
			for($i = 0; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%864 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		print json_encode($returnArray);
	}else if($data[0]["DIFF"] > 7776000 && $data[0]["DIFF"] <= 15552000){
		//3 to 6 months
		$howMany = round($data[0]["DIFF"] / 300);
		// if($howMany > count($data)){
		// 	for($i = 0; $i< $howMany - count($data); $i++){
		// 		if($i%2016 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_ID' => null ,'TRUNK_IN' => null, 'TRUNK_OUT' => null, 'TRUNK_DATE' => null, 'TRUNK_IN_ATTEMPT' => null, 'TRUNK_OUT_ATTEMPT' => null));
		// 		}
		// 	}
		// 	for($i = $howMany - count($data); $i < count($data); $i++){
		// 		$in_counter += $data[$i]["TRUNK_IN"];
		// 		$out_counter += $data[$i]["TRUNK_OUT"];
		// 		$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
		// 		$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
		// 		if($i%2016 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
		// 			$in_counter = 0;
		// 			$out_counter = 0;
		// 			$in_attempt_counter = 0;
		// 			$out_attempt_counter = 0;
		// 		}
		// 	}
		// }
		if($howMany < count($data)){
			for($i = count($data) - $howMany; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%2016 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		else{
			for($i = 0; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%2016 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		print json_encode($returnArray);
	}else if($data[0]["DIFF"] > 15552000 && $data[0]["DIFF"] <= 31536000){
		//6 to 12 months
		$howMany = round($data[0]["DIFF"] / 300);
		// if($howMany > count($data)){
		// 	for($i = 0; $i< $howMany - count($data); $i++){
		// 		if($i%8640 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_ID' => null ,'TRUNK_IN' => null, 'TRUNK_OUT' => null, 'TRUNK_DATE' => null, 'TRUNK_IN_ATTEMPT' => null, 'TRUNK_OUT_ATTEMPT' => null));
		// 		}
		// 	}
		// 	for($i = $howMany - count($data); $i < count($data); $i++){
		// 		$in_counter += $data[$i]["TRUNK_IN"];
		// 		$out_counter += $data[$i]["TRUNK_OUT"];
		// 		$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
		// 		$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
		// 		if($i%8640 == 0 || $i == count($data) - 1){
		// 			array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
		// 			$in_counter = 0;
		// 			$out_counter = 0;
		// 			$in_attempt_counter = 0;
		// 			$out_attempt_counter = 0;
		// 		}
		// 	}
		if($howMany < count($data)){
			for($i = count($data) - $howMany; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%8640 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		else{
			for($i = 0; $i < count($data); $i++){
				$in_counter += $data[$i]["TRUNK_IN"];
				$out_counter += $data[$i]["TRUNK_OUT"];
				$in_attempt_counter += $data[$i]["TRUNK_IN_ATTEMPT"];
				$out_attempt_counter += $data[$i]["TRUNK_OUT_ATTEMPT"];
				if($i%8640 == 0 || $i == count($data) - 1){
					array_push($returnArray, array('TRUNK_IN' => $in_counter, 'TRUNK_OUT' => $out_counter, 'TRUNK_DATE' => $data[$i]["TRUNK_DATE"], 'TRUNK_IN_ATTEMPT' => $in_attempt_counter, 'TRUNK_OUT_ATTEMPT' => $out_attempt_counter));
					$in_counter = 0;
					$out_counter = 0;
					$in_attempt_counter = 0;
					$out_attempt_counter = 0;
				}
			}
		}
		print json_encode($returnArray);
	}

?>
