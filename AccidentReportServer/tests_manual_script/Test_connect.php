<?php
header('Content-Type: text/html; charset=utf-8');
require_once('DB.php');

$conn = new DB();
$conn->connect();
echo " Test Connection (Empty means No Error) = ".mysqli_error($conn->con);
$conn->closeDB();
?>