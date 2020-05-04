<?php
function func1() {echo 'Hello from 1';}
function func2() {
    $v = 123;
    $any = '(echo "LGI:OP=\"tuguldur\",PWD =\"Azure_0309\";";sleep 5; echo "USE ME:MEID=5;";sleep 5; echo "ADD CALLPRICHK: CSCNAME=\"UNITEL\", PFX=K\'00825761080898, CPFX=K\'EEEEEEEE, PCDN=\"INVALID\", PT=INHIBITED, FCC=CV45;"; sleep 5) | telnet 10.132.0.160 6000 > /home/core/log/'.$v.'_$(date +%Y-%m-%d_%H:%M).log';
    $output = shell_exec($any);
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




