<?php
$v = $_GET['user_num'];

$output = shell_exec('(echo "LGI:OP=\"ufms\",PWD =\"Monitor_9009\";";sleep 5; echo "USE ME:MEID=5;";sleep 5; echo "ADD CALLPRICHK: CSCNAME=\"ALL\", PFX=K\'EEEEEEEE, CPFX=K\''.$v.', PCDN=\"INVALID\", PT=INHIBITED, FCC=CV203;"; sleep 5) | telnet 10.132.0.160 6000');
//echo "<pre>$output</pre>";
echo $output;
?>




