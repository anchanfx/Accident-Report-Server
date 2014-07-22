<?php
$jsonString = file_get_contents('php://input');
$jsonObj = json_decode($jsonString);
$acknowledge = array();

// specify the file where we will save the contents of the variable message
$filename="json_messages.html";

if( !empty($jsonObj)) {

	$latitude = $jsonObj->AccidentReportData->Position->Latitude;
	$longitude = $jsonObj->AccidentReportData->Position->Longitude;

	$accidentType = $jsonObj->AccidentReportData->AdditionalInfo->AccidentType;
	$amountOfInjured = $jsonObj->AccidentReportData->AdditionalInfo->AmountOfInjured;
	$amountOfDead = $jsonObj->AccidentReportData->AdditionalInfo->AmountOfDead;
	$trafficBlocked = $jsonObj->AccidentReportData->AdditionalInfo->TrafficBlocked;
	$message = $jsonObj->AccidentReportData->AdditionalInfo->Message;

	$date = $jsonObj->AccidentReportData->Date->Date;

	// write (append) the data to the file
	file_put_contents($filename,
	"Latitude : ".$latitude.
	", Longtitude : ".$longitude.
	", AccidentType : ".$accidentType.
	", AmountOfInjured : ".$amountOfInjured.
	", AmountOfDead : ".$amountOfDead.
	", TrafficBlocked : ".$trafficBlocked.
	", Message : ".$message.
	", Date : ".$date.
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