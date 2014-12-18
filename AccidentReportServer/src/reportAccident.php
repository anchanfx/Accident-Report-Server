<?php
header('Content-Type: text/html; charset=utf-8');
require_once('AccidentReport.php');
require_once('Time.php');
require_once('JSONObjectAdapter.php');
require_once('logger.php');
require_once('DB.php');

function run(){
	$jsonString = file_get_contents('php://input');
	$log_file = 'log';

	if(!empty($jsonString)) {
		$jsonObj = new JSONObjectAdapter();
		$time = new Time();
		$accidentReport = $jsonObj->extractReportData($jsonString);
		$accidentReport->serverDateTime = $time->getThailandTime();
		$accidentReport->resolve = 0;
		 
		//save data To MySQL
		$db = new DB();
		$db->connect();
		$db->insertAccidentData($accidentReport);
		$db->closeDB();
		
		//save data To log file
		$log = new logger();
		$log->logAccidentReport($log_file,$accidentReport);
		
		//respond from server to android
		$db->connect();
		$msg = $db->selectMessage('0000');
                $db->closeDB();
		$msgJson = $jsonObj->packReportAcknowledge($msg);
		echo $msgJson;
		
	}
}

run();
?>