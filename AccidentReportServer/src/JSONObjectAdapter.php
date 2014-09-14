<?php
require_once('AccidentReport.php');

class JSONObjectAdapter{
	function extractReportData($jsonString) {
		$jsonObj = json_decode($jsonString);
		$latitude = $jsonObj->AccidentData->Position->Latitude;
		$longitude = $jsonObj->AccidentData->Position->Longitude;
		$accidentType = $jsonObj->AccidentData->AdditionalInfo->AccidentType;
		$amountOfInjured = $jsonObj->AccidentData->AdditionalInfo->AmountOfInjured;
		$amountOfDead = $jsonObj->AccidentData->AdditionalInfo->AmountOfDead;
		$trafficBlocked = $jsonObj->AccidentData->AdditionalInfo->TrafficBlocked;
		$message = $jsonObj->AccidentData->AdditionalInfo->Message;
	
	
		if(empty($trafficBlocked)) $trafficBlocked = 0;
		else $trafficBlocked = 1;
	
		$accidentReport = new AccidentReport($longitude,$latitude,$accidentType,
				$amountOfDead,$amountOfInjured,$trafficBlocked,$message,'');
	
		return $accidentReport;
	}
	
	function packReportAcknowledge($msg) {
		$acknowledge = array();
	
		$acknowledge['AcknowledgeData']['Message'] = $msg;
		$jsonObject = json_encode($acknowledge);
	
		return $jsonObject;
	}
}
?>