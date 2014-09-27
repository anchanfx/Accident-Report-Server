<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once ('DB.php');
	require_once ('JSONObjectAdapter.php');
	require_once ('MissionReport.php');
	require_once ('Time.php');

	function run(){
		$jsonString = file_get_contents('php://input');

		if(!empty($jsonString))
		{
			$db = new DB();
			$jsonObj = new JSONObjectAdapter();
			$timeThai = new Time();
			$jsonAdapter = new JSONObjectAdapter();
			$missionReport = $jsonAdapter->extractMissionReport($jsonString);
			$missionReport->DateTime = $timeThai->getThailandTime();
			
			$db->connect();
			$db->insertMissionReport($missionReport);
			$msg = $db->selectMessage('0000');
			$db->closeDB();

			$msgJson = $jsonAdapter->packReportAcknowledge($msg);
			echo $msgJson;
		}
	}

	run();
?>