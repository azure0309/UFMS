<?php
function func1() {echo 'Hello from 1';}
function func2() {
    $output = shell_exec('(echo "LGI:OP=\"vlrdata\",PWD =\"!QAZ2wsx\";";sleep 5; echo "USE ME:MEID=5;";sleep 5; echo "LST CNACLD: RSNAME=\"NEW_KT\", QR=LOCAL;";sleep 5) | telnet 10.132.0.160 6000 > /home/core/log/$(date +%Y-%m-%d_%H:%M).log');
    echo "<pre>$output </pre>";
//    echo 'Hello from 2';
}
function func3() {echo 'Hello from 3';}
switch($_GET['func']) {
    case '1':
        func1();
        break;
    case '2':
        func2();
        break;
    case '3':
        func3();
        break;
    default:
        // Do nothing?
}
?>




