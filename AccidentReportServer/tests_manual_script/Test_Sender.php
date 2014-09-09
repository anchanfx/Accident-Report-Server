<?php
header('Content-Type: text/html; charset=utf-8');
require_once('Sender.php');
function callReportAcknowledge($msg) {
	Acknowledge($msg);
}
//return message from input
callReportAcknowledge('0000');
echo "<br>";
callReportAcknowledge('Hi!');
?>