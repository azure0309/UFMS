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
$created_date = $_POST["created_date"];
$blocked_date = $_POST["blocked_date"];



header('Content-type:application/json');

$db_charset = 'AL32UTF8';
$conn = oci_connect('UNI_TRAFFIC', '123456oracle', "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.21.64.190)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = 
	UFMS)))",$db_charset);
if($toggle == 'action'){
//    $stid = oci_parse($conn, "UPDATE OD_ALERT SET STATUS = 1 WHERE ALERT_ID = ".$id."");

//    $sql = 'INSERT INTO od_alert_cmd(type,callfrom,callto,pfx,cpfx,pcdn,pt,CREATED) '.
//        'VALUES(:c_type, :callfrom, :callto, :pfx, :cpfx, :pcdn, :pt, to_date(:created_date, "DD-MM-YYYY HH24:MI:SS"))';

     $sql =    "INSERT INTO od_alert_cmd (type,callfrom,callto,pfx,cpfx,pcdn,pt,BLOCKED)
            VALUES (:c_type, :callfrom, :callto, :pfx, :cpfx, :pcdn, :pt, to_date(:blocked_date, 'YYYY-MM-DD HH24:MI:SS'))";

    // 11-10-2020 08:40:00

    $stid = oci_parse($conn, $sql);

//    oci_bind_by_name($stid, ':url', $url_name);
    oci_bind_by_name($stid, ':c_type', $c_type);
    oci_bind_by_name($stid, ':callfrom', $callfrom);
    oci_bind_by_name($stid, ':callto', $callto);
    oci_bind_by_name($stid, ':pfx', $pfx);
    oci_bind_by_name($stid, ':cpfx', $cpfx);
    oci_bind_by_name($stid, ':pcdn', $pcdn);
    oci_bind_by_name($stid, ':pt', $pt);
    oci_bind_by_name($stid, ':created_date', $created_date);
    oci_bind_by_name($stid, ':blocked_date', $blocked_date);

//    oci_bind_by_name($mml_cmd, ':mml_cmd', $mml_cmd);

}
else if($toggle == 'reverse'){
//    $stid = oci_parse($conn, "UPDATE OD_ALERT SET STATUS = 0 WHERE ALERT_ID = ".$id."");
}

oci_execute($stid);
oci_free_statement($stid);
oci_close($conn);

?>
