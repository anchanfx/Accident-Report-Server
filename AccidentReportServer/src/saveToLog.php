<?php
header('Content-Type: text/html; charset=utf-8');
require_once('accidentReport.php');
$log_file = 'log';

//receive variavles from receiveFromApp.php file
session_start();
$accidentReport	= $_SESSION['accidentReport'];

// write (append) the data to the file
	file_put_contents($log_file,
	"Longitude = ".$accidentReport->longitude.
	", Latitude = ".$accidentReport->latitude.
	", AccidentType = ".$accidentReport->accidentType.
	", AmountOfDead = ".$accidentReport->amountOfDead.
	", AmountOfInjured = ".$accidentReport->amountOfInjured.
	", TrafficBlocked = ".$accidentReport->trafficBlocked.
	", Message = ".$accidentReport->message.
	", Date = ".$accidentReport->dateTime.
	"<br />",
	FILE_APPEND);
?>        