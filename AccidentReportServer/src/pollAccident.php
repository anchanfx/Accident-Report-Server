<?php
header('Content-Type: text/html; charset=utf-8');
require_once ('DB.php');
require_once ('AccidentPolling.php');
require_once ('JSONObjectAdapter.php');

function run(){
	$jsonString = file_get_contents('php://input');

	if(!empty($jsonString))
	{
		$jsonAdapter = new JSONObjectAdapter();
		$imei = $jsonAdapter->extractIMEI($jsonString);
		$db = new DB();
		$db->connect();
		$accidentPollings = $db->selectAccidentPollingThatsNotYetPulled($imei);
		$db->closeDB();

		if (count($accidentPollings) >= 1) {
     		$accidentPolling = $accidentPollings[0];

     		$db->connect();
     		$accidentReport = $db->selectAccidentReport($accidentPolling->AccidentID);
     		$db->updatePullInAccidentPolling($accidentPolling, 1);
     		$db->closeDB();

     		echo $jsonAdapter->packAccidentData($accidentPolling, $accidentReport);
		} else {
			echo "";
		}
	}
}

run();

	
?>