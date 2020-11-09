<?php

$id = $_POST["id"];
$toggle = $_POST["toggle"];

$callfrom= $_POST["callfrom"];
$callto = $_POST["callto"];


header('Content-type:application/json');

$db_charset = 'AL32UTF8';
$conn = oci_connect('UNI_TRAFFIC', '123456oracle', "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.21.64.190)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = 
	UFMS)))",$db_charset);
if($toggle == 'action'){
//    $stid = oci_parse($conn, "UPDATE OD_ALERT SET STATUS = 1 WHERE ALERT_ID = ".$id."");
//    $stid = oci_parse($conn, "UPDATE OD_ALERT SET STATUS = 1 WHERE ALERT_ID = ".$id."");

//    $sql = "INSERT INTO od_alert_cmd(arg2,arg4) '.
//        'VALUES('$callfrom', '$callto')";

//    $sql = 'INSERT INTO od_alert_cmd(type) '.
//        'VALUES(:callfrom)';

//    $sql="insert into od_alert_cmd(type,arg2,arg4) VALUES('".'{callfrom}'."','".'{callto}'."','".'{callto}'."')";

    $sql = 'INSERT INTO od_alert_cmd(type,arg2,arg4) '.
        'VALUES(9, :callfrom, :callto)';

    $stid = oci_parse($conn, $sql);

//    oci_bind_by_name($stid, ':url', $url_name);
    oci_bind_by_name($stid, ':callfrom', $callfrom);
    oci_bind_by_name($stid, ':callto', $callto);

}
else if($toggle == 'reverse'){
//    $stid = oci_parse($conn, "UPDATE OD_ALERT SET STATUS = 0 WHERE ALERT_ID = ".$id."");
}

oci_execute($stid);
oci_free_statement($stid);
oci_close($conn);

?>
