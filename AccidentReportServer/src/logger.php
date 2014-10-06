<?php
require_once('AccidentReport.php');
class logger{
	function logAccidentReport($log_file,$data){
	
		file_put_contents($log_file,
				"Longitude = ".$data->longitude.
				", Latitude = ".$data->latitude.
				", AccidentType = ".$data->accidentType.
				", AmountOfDead = ".$data->amountOfDead.
				", AmountOfInjured = ".$data->amountOfInjured.
				", TrafficBlocked = ".$data->trafficBlocked.
				", Message = ".$data->message.
				", Date = ".$data->dateTime.
				", ServerDate = ".$data->serverDateTime.
				", Resolve = ".$data->resolve.
				"<br />"."\n",
				FILE_APPEND);
	}
}
?>