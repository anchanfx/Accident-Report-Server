<?php
	require_once('JSONObjectAdapter.php');
	require_once('DB.php');

	function run(){
		$jsonString = file_get_contents('php://input');
		
		if(!empty($jsonString)) {
			$jsonObj = new JSONObjectAdapter();
			$rescueUnit = $jsonObj->extractRescueUnit($jsonString);
			
			$db = new DB();
			$db->connect();
			$db->rescueUpdate($rescueUnit);
			$db->closeDB();
		}	
	}

	run();
?>