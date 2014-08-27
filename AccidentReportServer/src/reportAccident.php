<?php
header('Content-Type: text/html; charset=utf-8');
require_once('AccidentReport.php');
require_once('Time.php');
require_once('JSONObjectAdapter.php');

$jsonString = file_get_contents('php://input');

if(!empty($jsonString)) {
	$accidentReport = extractReportData($jsonString);
	$accidentReport->dateTime = getThailandTime();
        
        session_start();
        $_SESSION['accidentReport'] = $accidentReport;
        
	require('saveToDB.php'); 
	require('saveToLog.php'); 
	require('reportAcknowledge.php');
}
?>