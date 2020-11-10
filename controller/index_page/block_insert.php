<?php

$id = $_POST["id"];
$toggle = $_POST["toggle"];

$c_type = $_POST["c_type"];
$callfrom= $_POST["callfrom"];
$callto = $_POST["callto"];
$pfx = $_POST["pfx"];
$cpfx = $_POST["cpfx"];
$pcdn = $_POST["pcdn"];
$pt = $_POST["pt"];


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

    $sql = 'INSERT INTO od_alert_cmd(type,arg1,arg2,arg3,arg4,arg5,arg6) '.
        'VALUES(:c_type, :callfrom, :callto, :pfx, :cpfx, :pcdn, :pt)';

    $stid = oci_parse($conn, $sql);

//    oci_bind_by_name($stid, ':url', $url_name);
    oci_bind_by_name($stid, ':c_type', $c_type);
    oci_bind_by_name($stid, ':callfrom', $callfrom);
    oci_bind_by_name($stid, ':callto', $callto);
    oci_bind_by_name($stid, ':pfx', $pfx);
    oci_bind_by_name($stid, ':cpfx', $cpfx);
    oci_bind_by_name($stid, ':pcdn', $pcdn);
    oci_bind_by_name($stid, ':pt', $pt);

//    oci_bind_by_name($mml_cmd, ':mml_cmd', $mml_cmd);

}
else if($toggle == 'reverse'){
//    $stid = oci_parse($conn, "UPDATE OD_ALERT SET STATUS = 0 WHERE ALERT_ID = ".$id."");
}

oci_execute($stid);
oci_free_statement($stid);
oci_close($conn);

?>
