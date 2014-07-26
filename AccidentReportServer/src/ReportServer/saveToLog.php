<?php
header('Content-Type: text/html; charset=utf-8');
$log_file = 'log';

//receive variavles from receiveFromApp.php file
session_start();
$latitude		= $_SESSION['latitude'];
$longitude		= $_SESSION['longitude'];
$accidentType		= $_SESSION['accidentType'];
$amountOfInjured	= $_SESSION['amountOfInjured'];
$amountOfDead		= $_SESSION['amountOfDead'];
$trafficBlocked		= $_SESSION['trafficBlocked'];
$message		= $_SESSION['message'];
$dateTime		= $_SESSION['dateTime'];

// write (append) the data to the file
	file_put_contents($log_file,
	"Latitude = ".$latitude.
	", Longtitude = ".$longitude.
	", AccidentType = ".$accidentType.
	", AmountOfInjured = ".$amountOfInjured.
	", AmountOfDead = ".$amountOfDead.
	", TrafficBlocked = ".$trafficBlocked.
	", Message = ".$message.
	", Date = ".$dateTime.
	"<br />",
	FILE_APPEND);
?>        