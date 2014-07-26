<?php
header('Content-Type: text/html; charset=utf-8');
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
	
        if(empty($trafficBlocked))
        {
                $trafficBlocked = 0;
        }
        
        // ดึงเวลาจาก TimeZone ของประเทศไทย
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('Asia/Bangkok'));
        $dateTime = $date->format('Y-m-d H:i:s');
        
	//Pass variables
	session_start();
	$_SESSION['latitude'] 		= $latitude;
	$_SESSION['longitude'] 		= $longitude;
	$_SESSION['accidentType'] 	= $accidentType;
	$_SESSION['amountOfInjured'] 	= $amountOfInjured;
	$_SESSION['amountOfDead'] 	= $amountOfDead;
	$_SESSION['trafficBlocked'] 	= $trafficBlocked;
	$_SESSION['message'] 		= $message;
	$_SESSION['dateTime'] 		= $dateTime;
        
	//call saveToDB.php file
	include ('saveToDB.php');
	
        //call saveToLog.php file
        include ('saveToLog.php');
    
	$acknowledge['AcknowledgeInfo']['Message'] = 'Report Acknowledged';
	echo json_encode($acknowledge);
}
?>