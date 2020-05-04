<?php
 $name = $_POST['v_number'];
 echo $name;

function fetchShell($v) {

 $any = '(echo "LGI:OP=\"tuguldur\",PWD =\"Azure_0309\";";sleep 5; echo "USE ME:MEID=5;";sleep 5; echo "ADD CALLPRICHK: CSCNAME=\"UNITEL\", PFX=K\'00825761080898, CPFX=K\'EEEEEEEE, PCDN=\"INVALID\", PT=INHIBITED, FCC=CV45;"; sleep 5) | telnet 10.132.0.160 6000 > /home/core/log/'.$v.'_$(date +%Y-%m-%d_%H:%M).log';

 #$output = shell_exec('(echo "LGI:OP=\"vlrdata\",PWD =\"!QAZ2wsx\";";sleep 5; echo "USE ME:MEID=5;";sleep 5; echo "LST CNACLD: RSNAME=\"NEW_KT\", QR=LOCAL;";sleep 5) | telnet 10.132.0.160 6000 > /home/core/log/$(date +%Y-%m-%d_%H:%M).log');
 $output = shell_exec($any);
 # echo "<pre>$output </pre>";
}

function fetchLog($v) {
 $data = file("log/$v",FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); //read the entire file to array by ignoring new lines and spaces

 # echo "<pre/>";print_r($data);
 echo print_r($data).PHP_EOL;

 $retcode = print_r($data[18]);
 echo print_r($retcode).PHP_EOL;
 echo print_r($data[19]);
}

$user_num = "124312341243";
$exec_date = date("Y-m-d_H:i");

#echo($exec_date);
fetchShell($user_num);

$b = $user_num .'_'. $exec_date . '.log';
#echo($b);
fetchLog($b);

?>


