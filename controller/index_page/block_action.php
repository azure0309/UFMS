<?php
function func2() {
    $output = shell_exec('(echo "LGI:OP=\"vlrdata\",PWD =\"edc$RFV3\";";sleep 5; echo "USE ME:MEID=5;";sleep 5; echo "LST CNACLD: RSNAME=\"NEW_KT\", QR=LOCAL;";sleep 5) | telnet 10.132.0.160 6000 > /home/core/log/$(date +%Y-%m-%d_%H:%M).log');
    echo "<pre>$output </pre>";
}

$v = $_GET['user_num'];

$output = shell_exec('(echo "LGI:OP=\"ufms\",PWD =\"edc$RFV3\";";sleep 5; echo "USE ME:MEID=5;";sleep 5; echo "ADD CALLPRICHK: CSCNAME=\"ALL\", PFX=K\''.$v.', CPFX=K\'EEEEEEEE, PCDN=\"INVALID\", PT=INHIBITED, FCC=CV203;"; sleep 5) | telnet 10.132.0.160 6000');
echo "<pre>$output</pre>";

?>




