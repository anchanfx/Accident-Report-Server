<?php
header('Content-Type: text/html; charset=utf-8');
require_once('accidentReport.php');
$jsonString = file_get_contents('php://input');
$jsonObj = json_decode($jsonString);
$acknowledge = array();

if(!empty($jsonObj)) {
	$latitude = $jsonObj->AccidentData->Position->Latitude;
	$longitude = $jsonObj->AccidentData->Position->Longitude;
	$accidentType = $jsonObj->AccidentData->AdditionalInfo->AccidentType;
	$amountOfInjured = $jsonObj->AccidentData->AdditionalInfo->AmountOfInjured;
	$amountOfDead = $jsonObj->AccidentData->AdditionalInfo->AmountOfDead;
	$trafficBlocked = $jsonObj->AccidentData->AdditionalInfo->TrafficBlocked;
	$message = $jsonObj->AccidentData->AdditionalInfo->Message;

        // เปลี่ยน False จากเก็บเป็น null ให้เก็บเป็น 0
	if(empty($trafficBlocked))
	{
		$trafficBlocked = 0;
	}

	// ดึงเวลาจาก TimeZone ของประเทศไทย
	$date = new DateTime();
	$date->setTimezone(new DateTimeZone('Asia/Bangkok'));
	$dateTime = $date->format('Y-m-d H:i:s');

	
	$accidentReport = new AccidentReport($longitude,$latitude,$accidentType,
			$amountOfDead,$amountOfInjured,$trafficBlocked,$message,$dateTime);
	
        session_start();
 	$_SESSION['accidentReport'] = $accidentReport;
        

	//call saveToDB.php file
	include ('saveToDB.php');

	//call saveToLog.php file
	include ('saveToLog.php');

	$acknowledge['AcknowledgeInfo']['Message'] = 'Report Acknowledged';
	echo json_encode($acknowledge);
}
?>