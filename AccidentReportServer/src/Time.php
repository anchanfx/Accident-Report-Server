<?php
class Time{
	function getThailandTime() {
		$date = new DateTime();
		$date->setTimezone(new DateTimeZone('Asia/Bangkok'));
		$dateTime = $date->format('Y-m-d H:i:s');
	
		return $dateTime;
	}
}
?>