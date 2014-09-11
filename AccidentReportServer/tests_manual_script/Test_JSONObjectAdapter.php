<?php
require_once('AccidentReport.php');
require_once('JSONObjectAdapter.php');

function Test1_extractReportData() {
	$accidentReport = array();
	$accidentReport['AccidentData']['Position']['Latitude'] = 5.432;
	$accidentReport['AccidentData']['Position']['Longitude'] = 2.435;
	$accidentReport['AccidentData']['AdditionalInfo']['AccidentType'] = 'Test1';
	$accidentReport['AccidentData']['AdditionalInfo']['AmountOfInjured'] = 100;
	$accidentReport['AccidentData']['AdditionalInfo']['AmountOfDead'] = 0;
	$accidentReport['AccidentData']['AdditionalInfo']['TrafficBlocked'] = false;
	$accidentReport['AccidentData']['AdditionalInfo']['Message'] = 'TestData1';
	$jsonObj = json_encode($accidentReport);
    
	$jsonTest = new JSONObjectAdapter();
	$result = $jsonTest->extractReportData($jsonObj);
        
	echoAccidentReport($result);
}

function Test2_extractReportData() {
	$accidentReport = array();
	$accidentReport['AccidentData']['Position']['Latitude'] = 2.435;
	$accidentReport['AccidentData']['Position']['Longitude'] = 5.432;
	$accidentReport['AccidentData']['AdditionalInfo']['AccidentType'] = 'Test2';
	$accidentReport['AccidentData']['AdditionalInfo']['AmountOfInjured'] = 0;
	$accidentReport['AccidentData']['AdditionalInfo']['AmountOfDead'] = 100;
	$accidentReport['AccidentData']['AdditionalInfo']['TrafficBlocked'] = true;
	$accidentReport['AccidentData']['AdditionalInfo']['Message'] = 'TestData2';
        $jsonObj = json_encode($accidentReport);
    
    $jsonTest = new JSONObjectAdapter();
	$result = $jsonTest->extractReportData($jsonObj);
        
	echoAccidentReport($result);
}

function echoAccidentReport($accidentReport) {
	echo $accidentReport->latitude.", ".
			$accidentReport->longitude.", ".
			$accidentReport->accidentType.", ".
			$accidentReport->amountOfInjured.", ".
			$accidentReport->amountOfDead.", ".
			$accidentReport->trafficBlocked.", ".
			$accidentReport->message."<br />";
}

function Test_packReportAcknowledge() {
	$jsonTest = new JSONObjectAdapter();
	$result = $jsonTest->packReportAcknowledge("TEST MESSAGE");
        echo $result;
}

Test1_extractReportData();
Test2_extractReportData();
Test_packReportAcknowledge();
?>