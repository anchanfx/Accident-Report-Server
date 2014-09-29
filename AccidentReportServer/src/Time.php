<?php
define('TIME_FORMAT', 'Y-m-d H:i:s');

class Time{

	function getThailandTime() {
		$date = new DateTime();
		$date->setTimezone(new DateTimeZone('Asia/Bangkok'));
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