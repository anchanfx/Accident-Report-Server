<?php
header('Content-Type: text/html; charset=utf-8');
$jsonString = file_get_contents('php://input');
$jsonObj = json_decode($jsonString);
$acknowledge = array();

// specify the file where we will save the contents of the variable message
$filename="json_messages.html";


if( !empty($jsonObj)) {

	$latitude = $jsonObj->AccidentData->Position->Latitude;
	$longitude = $jsonObj->AccidentData->Position->Longitude;
	$accidentType = $jsonObj->AccidentData->AdditionalInfo->AccidentType;
	$amountOfInjured = $jsonObj->AccidentData->AdditionalInfo->AmountOfInjured;
	$amountOfDead = $jsonObj->AccidentData->AdditionalInfo->AmountOfDead;
	$trafficBlocked = $jsonObj->AccidentData->AdditionalInfo->TrafficBlocked;
	$message = $jsonObj->AccidentData->AdditionalInfo->Message;
	
        // ดึงเวลาจาก Server ของ TimeZone ประเทศไทย
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('Asia/Bangkok'));
        $dateTime = $date->format('Y-m-d H:i:s');
        
	//Pass variables
	session_start();
	$_SESSION['latitude'] 			= $latitude;
	$_SESSION['longitude'] 			= $longitude;
	$_SESSION['accidentType'] 		= $accidentType;
	$_SESSION['amountOfInjured'] 	= $amountOfInjured;
	$_SESSION['amountOfDead'] 		= $amountOfDead;
	$_SESSION['trafficBlocked'] 	= $trafficBlocked;
	$_SESSION['message'] 			= $message;
	$_SESSION['dateTime'] 		= $dateTime;
        
	//call saveToSql.php file
	include ('saveToSql.php');
	
	// write (append) the data to the file
	file_put_contents($filename,
	"Latitude = ".$latitude.
	", Longtitude = ".$longitude.
	", AccidentType = ".$accidentType.
	", AmountOfInjured = ".$amountOfInjured.
	", AmountOfDead = ".$amountOfDead.
	", TrafficBlocked = ".$trafficBlocked.
	", Message = ".$message.
	", Date = ".$dateTime.
	"<br />",
	FILE_APPEND);

	$acknowledge['AcknowledgeInfo']['Message'] = 'Report Acknowledged';
	echo json_encode($acknowledge);
        
	exit();
}

// load the contents of the file to a variable
$androidmessages=file_get_contents($filename);

// display the contents of the variable (which has the contents of the file)
echo $androidmessages;

?>