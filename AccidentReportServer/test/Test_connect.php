<?php
header('Content-Type: text/html; charset=utf-8');
require_once('connect.php');
function callConnect() {

        return connect();
}

$con = callConnect();
echo " Test Connection (Empty means No Error) = ".mysqli_error($con);
mysqli_close($con) or die("Can't Close Connection");
?>