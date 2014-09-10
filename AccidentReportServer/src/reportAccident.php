<?php
header('Content-Type: text/html; charset=utf-8');
require_once('AccidentReport.php');
require_once('Time.php');
require_once('JSONObjectAdapter.php');
require_once('logger.php');
require_once('Sender.php');
require_once('DB.php');
require_once ('connect.php');

function run(){
	$jsonString = file_get_contents('php://input');
	$log_file = 'log';

	if(!empty($jsonString)) {
		$jsonObj = new JSONObjectAdapter();
		$timeThai = new Time();
		$accidentReport = $jsonObj->extractReportData($jsonString);
		$accidentReport->dateTime = $timeThai->getThailandTime();
		 
		//save data To MySQL
		$con = connect();
		$db = new DB();
		$db->insertAccidentData($con,$accidentReport);
		$con->close();
		//save data To log file
		$log = new logger();
		$log->logAccidentReport($log_file,$accidentReport);
		//respond from server to android
		$con1 = connect();
		$msg = $db->selectMessage($con1,'0000');
		$msgJson = $jsonObj->packReportAcknowledge($msg);
		$Ack = new Sender();
		echo $Ack->Acknowledge($msgJson);
		$con1->close();
	}
}

run();
?>