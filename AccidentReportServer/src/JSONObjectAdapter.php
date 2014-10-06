<?php
require_once('AccidentReport.php');
require_once('RescueUnit.php');
require_once('AccidentPolling.php');
require_once ('MissionReport.php');
require_once('JSONKeys.php');
require_once('Time.php');

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
		$dateTime = date(TIME_FORMAT, $jsonObj->DateTime);
	
		if(empty($trafficBlocked)) $trafficBlocked = 0;
		else $trafficBlocked = 1;
	
		$accidentReport = new AccidentReport($longitude,$latitude,$accidentType,
				$amountOfDead,$amountOfInjured,$trafficBlocked,$message,$dateTime);
	
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
		$dateTime = date(TIME_FORMAT, $jsonObj->MissionReport->DateTime);
		$message = $jsonObj->MissionReport->Message;

		$missionReport = new MissionReport($imei, $accidentID,
			$rescueState, $dateTime, $message);
		return $missionReport;
	}

	function packReportAcknowledge($msg) {
		$acknowledge = array();
	
		$acknowledge[JSON_ACKNOWLEDGE_DATA][MESSAGE] = $msg;
		$jsonObject = json_encode($acknowledge);
	
		return $jsonObject;
	}

	function packAccidentPolling($accidentPolling) {
		$jsonObject = json_encode($accidentPolling);
	
		return $jsonObject;
	}

	function packAccidentData($accidentPolling, $accidentReport) {
		$time = new Time();
		$timeStamp = $time->getTimeStamp($accidentReport->dateTime);
		$serverTimeStamp = $time->getTimeStamp($accidentReport->serverDateTime);
		$assignTimeStamp = $time->getTimeStamp($accidentPolling->DateTime);
		
		$accidentData = array();
		$accidentData[JSON_ACCIDENT_DATA][ACCIDENT_ID] = $accidentPolling->AccidentID;
		$accidentData[JSON_ACCIDENT_DATA][JSON_POSITION][LATITUDE] = $accidentReport->latitude;
		$accidentData[JSON_ACCIDENT_DATA][JSON_POSITION][LONGITUDE] = $accidentReport->longitude;
		$accidentData[JSON_ACCIDENT_DATA][JSON_ADDITIONAL_INFO][ACCIDENT_TYPE] = $accidentReport->accidentType;
		$accidentData[JSON_ACCIDENT_DATA][JSON_ADDITIONAL_INFO][AMOUNT_OF_INJURED] = $accidentReport->amountOfInjured;
		$accidentData[JSON_ACCIDENT_DATA][JSON_ADDITIONAL_INFO][AMOUNT_OF_DEAD] = $accidentReport->amountOfDead;
		$accidentData[JSON_ACCIDENT_DATA][JSON_ADDITIONAL_INFO][TRAFFIC_BLOCKED] = $accidentReport->trafficBlocked;
		$accidentData[JSON_ACCIDENT_DATA][JSON_ADDITIONAL_INFO][MESSAGE] = $accidentReport->message;
		$accidentData[JSON_ACCIDENT_DATA][DATE_TIME] = $timeStamp;
		$accidentData[JSON_ACCIDENT_DATA][SERVER_DATE_TIME] = $serverTimeStamp;
		$accidentData[JSON_ACCIDENT_DATA][RESOLVE] = $accidentReport->resolve;
		$accidentData[ASSIGN_DATE_TIME] = $assignTimeStamp;

		$jsonObject = json_encode($accidentData);
	
		return $jsonObject;
	}
}
?>