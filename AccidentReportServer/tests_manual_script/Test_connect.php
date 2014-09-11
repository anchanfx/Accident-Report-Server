<?php
header('Content-Type: text/html; charset=utf-8');
require_once('DB.php');
function callConnect() {
		$conn = new DB();
        return $conn->connect();
}

function callClose(){
		$conn = new DB();
		return $conn->closeDB();
}

$con = callConnect();
echo " Test Connection (Empty means No Error) = ".mysqli_error($con);
//mysqli_close($con) or die("Can't Close Connection");
echo '<br/>';
echo "close connect (Empty means No Error) = ".callClose();

?>