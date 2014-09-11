<?php
header('Content-Type: text/html; charset=utf-8');
require_once('Sender.php');
function callReportAcknowledge($msg) {
	$ack = new Sender();
	return $ack->Acknowledge($msg);
}
//return message from input
echo callReportAcknowledge('0000');
echo "<br>";
echo callReportAcknowledge('Hi!');
?>