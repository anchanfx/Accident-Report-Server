<?php
header('Content-Type: text/html; charset=utf-8');
require_once('DB.php');
require_once('Time.php');
require_once('AccidentPolling.php');

function run() {
	if(isset($_GET['imei']) && isset($_GET['accidentID'])) {
		$db = new DB();
		$timeThai = new Time();
		$dateTime = $timeThai->getThailandTime();
		$imei = $_GET['imei'];
		$accidentID = $_GET['accidentID'];
		$pull = 0;
		$accidentPolling = new AccidentPolling($dateTime, $imei, 
			$accidentID, $pull);

		$db->connect();
		$db->insertAccidentPolling($accidentPolling);
		$db->closeDB();
		echo 'Success??';
	}
}
	
run();
?>