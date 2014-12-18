<?php
header('Content-Type: text/html; charset=utf-8');
require_once ('DB.php');
require_once ('AccidentReporterMessagePolling.php');
require_once ('JSONObjectAdapter.php');

function run(){
	$jsonString = file_get_contents('php://input');

	if(!empty($jsonString))
	{
		$jsonAdapter = new JSONObjectAdapter();
		$imei = $jsonAdapter->extractIMEI($jsonString);
		$db = new DB();
		$db->connect();
		$accidentReporterMessagePollings = $db->selectAccidentReporterMessagePollingThatsNotYetPulled($imei);
		$db->closeDB();

		if (count($accidentReporterMessagePollings) >= 1) {
                        $accidentReporterMessage = $accidentReporterMessagePollings[0];

                        $db->connect();
                        $db->updatePullInAccidentReporterMessagePolling($accidentReporterMessage, 1);
                        $db->closeDB();

                        echo $jsonAdapter->packReportAcknowledge($accidentReporterMessage->Message);
		} else {
			echo "";
		}
	}
}

run();
?>