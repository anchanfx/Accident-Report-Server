<?php
require_once('AccidentReport.php');
require_once('RescueUnit.php');
require_once('AccidentPolling.php');
require_once ('MissionReport.php');

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

	function extractMissionReport($jsonString) {
		$jsonObj = json_decode($jsonString);
		$imei = $jsonObj->MissionReport->IMEI;
		$accidentID = $jsonObj->MissionReport->AccidentID;
		$rescueState = $jsonObj->MissionReport->RescueState;
		$dateTime = '0';
		$message = $jsonObj->MissionReport->Message;

		$missionReport = new MissionReport($imei, $accidentID,
			$rescueState, $dateTime, $message);
		return $missionReport;
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

	function packAccidentData($accidentReport) {
		$accidentData = array();
		$accidentData['AccidentData']['Position']['Latitude'] = $accidentReport->latitude;
		$accidentData['AccidentData']['Position']['Longitude'] = $accidentReport->longitude;
		$accidentData['AccidentData']['AdditionalInfo']['AccidentType'] = $accidentReport->accidentType;
		$accidentData['AccidentData']['AdditionalInfo']['AmountOfInjured'] = $accidentReport->amountOfInjured;
		$accidentData['AccidentData']['AdditionalInfo']['AmountOfDead'] = $accidentReport->amountOfDead;
		$accidentData['AccidentData']['AdditionalInfo']['TrafficBlocked'] = $accidentReport->trafficBlocked;
		$accidentData['AccidentData']['AdditionalInfo']['Message'] = $accidentReport->message;

		$jsonObject = json_encode($accidentData);
	
		return $jsonObject;
	}
}
?>