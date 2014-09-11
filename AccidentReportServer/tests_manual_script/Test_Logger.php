<?php
header('Content-Type: text/html; charset=utf-8');
require_once('AccidentReport.php');
require_once('Time.php');
require_once('logger.php');

function callSaveToLog($data) {
		$lo = new logger();
		$log_file = 'log';
        $lo->logAccidentReport($log_file,$data);
}
$timeThai = new Time();
$dateTime = $timeThai->getThailandTime();
$accidentReport1 = new AccidentReport(1.010, 2.202, 'Test', 10, 20, 0, 'Test Accident1', $dateTime);
$accidentReport2 = new AccidentReport(100.001,10.111,'Test', 0, 0, 1,'Test Accident2',$dateTime);
$accidentReport3 = new AccidentReport(100.001,10.111,'เทสไทย', 0, 0, 1,'เทสไทย3',$dateTime);
callSaveToLog($accidentReport1);
callSaveToLog($accidentReport2);
callSaveToLog($accidentReport3);
?>