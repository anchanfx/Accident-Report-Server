<?php
define('TIME_FORMAT', 'Y-m-d H:i:s');
define('TIME_ZONE', 'Asia/Bangkok');
date_default_timezone_set(TIME_ZONE);

class Time{

	function getThailandTime() {
		$date = new DateTime();
		$dateTime = $date->format(TIME_FORMAT);
	
		return $dateTime;
	}

	function getTimeStamp($dateTime) {
		$newDate = DateTime::createFromFormat(TIME_FORMAT, $dateTime);
		$timeStamp = $newDate->getTimestamp();
		
		return $timeStamp;
	}
}
?>