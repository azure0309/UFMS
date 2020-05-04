<?php
function func1() {echo 'Hello from 1';}
function func2() {echo 'Hello from 2';}
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




