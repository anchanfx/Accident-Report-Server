<?php
require_once('AccidentReport.php');
$log_file = 'log';

session_start();
$accidentReport	= $_SESSION['accidentReport'];

file_put_contents($log_file,
        "Longitude = ".$accidentReport->longitude.
        ", Latitude = ".$accidentReport->latitude.
        ", AccidentType = ".$accidentReport->accidentType.
        ", AmountOfDead = ".$accidentReport->amountOfDead.
        ", AmountOfInjured = ".$accidentReport->amountOfInjured.
        ", TrafficBlocked = ".$accidentReport->trafficBlocked.
        ", Message = ".$accidentReport->message.
        ", Date = ".$accidentReport->dateTime.
        "<br />"."\n",
        FILE_APPEND);
?>        