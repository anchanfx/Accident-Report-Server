<?php
header('Content-Type: text/html; charset=utf-8');
require_once('AccidentReport.php');
require_once('Time.php');
require_once ('DB.php');

function callSaveToDB($data) {
		$conn = new DB();
		$con = $conn->connect();
        $conn->insertAccidentData($data);
        $conn->closeDB($con);
}

function callSelectMsg($code){
		$conn = new DB();
		$con = $conn->connect();
		$result = $conn->selectMessage($code);
		if($result == null){
			return 'NULL';
		}
		return $result;
		$conn->closeDB($con);
}
$timeThai = new Time();
$dateTime = $timeThai->getThailandTime();
$accidentReport1 = new AccidentReport(1.010, 2.202, 'Test', 10, 20, 0, 'Test Accident1', $dateTime);
$accidentReport2 = new AccidentReport(100.001,10.111,'Test', 0, 0, 1,'Test Accident2',$dateTime);
$accidentReport3 = new AccidentReport(100.001,10.111,'เทสไทย', 0, 0, 1,'เทสไทย3',$dateTime);
callSaveToDB($accidentReport1);
callSaveToDB($accidentReport2);
callSaveToDB($accidentReport3);

$code1 = '0000';
$code2 = '0001';
$code3 = 'Hi!';
echo callSelectMsg($code1); 
echo "<br>";
echo callSelectMsg($code2); 
echo "<br>";
echo callSelectMsg($code3);
?>