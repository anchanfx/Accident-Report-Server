<?php
header('Content-Type: text/html; charset=utf-8');
require_once('AccidentReport.php');
require_once('Time.php');

function callSaveToDB($data) {
        session_start();
        $_SESSION['accidentReport'] = $data;
        include('saveToDB.php');
}

$dateTime = getThailandTime();
$accidentReport1 = new AccidentReport(1.010, 2.202, 'Test', 10, 20, 0, 'Test Accident1', $dateTime);
$accidentReport2 = new AccidentReport(100.001,10.111,'Test', 0, 0, 1,'Test Accident2',$dateTime);
$accidentReport3 = new AccidentReport(100.001,10.111,'เทสไทย', 0, 0, 1,'เทสไทย3',$dateTime);
callSaveToDB($accidentReport1);
callSaveToDB($accidentReport2);
callSaveToDB($accidentReport3);
?>