<?php

$id = $_POST["v_number"];


header('Content-type:application/json');


function fetchShell($v) {

//    $any = '(echo "LGI:OP=\"tuguldur\",PWD =\"Azure_0309\";";sleep 5; echo "USE ME:MEID=5;";sleep 5; echo "ADD CALLPRICHK: CSCNAME=\"UNITEL\", PFX=K\'00825761080898, CPFX=K\'EEEEEEEE, PCDN=\"INVALID\", PT=INHIBITED, FCC=CV45;"; sleep 5) | telnet 10.132.0.160 6000 > /var/www/html/Test/log/'.$v.'_$(date +%Y-%m-%d_%H:%M).log';

    $output = shell_exec('(echo "LGI:OP=\"vlrdata\",PWD =\"!QAZ2wsx\";";sleep 5; echo "USE ME:MEID=5;";sleep 5; echo "LST CNACLD: RSNAME=\"NEW_KT\", QR=LOCAL;";sleep 5) | telnet 10.132.0.160 6000 > test.log');
//    $output = shell_exec($any);
    echo "<pre>$output </pre>";
}


$user_num = "124312341243";
$exec_date = date("Y-m-d_H:i");
fetchShell($user_num);


?>
