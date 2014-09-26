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
     		$data = $accidentPollings[0];

     		$db->connect();
     		$db->updatePullInAccidentPolling($data->DateTime, $data->IMEI, $data->AccidentID, 1);
     		$db->closeDB();

     		echo $jsonAdapter->packAccidentPolling($data);
		} else {
			echo "";
		}
	}
}

run();

	
?>