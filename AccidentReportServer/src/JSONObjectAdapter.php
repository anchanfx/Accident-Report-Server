<?php
require_once('AccidentReport.php');
require_once('RescueUnit.php');
require_once('AccidentPolling.php');

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
	
	function extractRescueInfo($jsonString) {
		$jsonObj = json_decode($jsonString);
		$latitude = $jsonObj->SelfUpdateData->Position->Latitude;
		$longitude = $jsonObj->SelfUpdateData->Position->Longitude;
		$status = $jsonObj->SelfUpdateData->RescueUnitStatus->Status;
		$imei = $jsonObj->SelfUpdateData->IMEI->IMEI;
	
		$accidentReport = new AccidentReport($longitude,$latitude,$status,$imei,'');
	
		return $accidentReport;
	}
	
	function extractIMEI($jsonString) {
		$jsonObj = json_decode($jsonString);
		$imei = $jsonObj->IMEI;
		return $imei;
	}

	function packReportAcknowledge($msg) {
		$acknowledge = array();
	
		$acknowledge['AcknowledgeData']['Message'] = $msg;
		$jsonObject = json_encode($acknowledge);
	
		return $jsonObject;
	}

	function packAccidentPolling($accidentPolling) {
		$jsonObject = json_encode($accidentPolling);
	
		return $jsonObject;
	}
}
?>