<?php
header('Content-Type: text/html; charset=utf-8');
require_once('DB.php');
require_once('Time.php');
require_once('AccidentReporterMessagePolling.php');

function run() {
	if(isset($_GET['accidentID']) && isset($_GET['message'])) {
		$db = new DB();
		$timeThai = new Time();
		$dateTime = $timeThai->getThailandTime();
		$message = $_GET['message'];
		$accidentID = $_GET['accidentID'];
		$pull = 0;
		$accidentReporterMessage = new AccidentReporterMessagePolling($dateTime, $accidentID, 
			$message, $pull);

		$db->connect();
		$db->insertAccidentReporterMessagePolling($accidentReporterMessage);
		$db->closeDB();
		echo 'Success??';
	}
}
	
run();
?>