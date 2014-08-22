<?php
header('Content-Type: text/html; charset=utf-8');
require_once('AccidentReport.php');
include_once 'connect.php';
$con->set_charset("utf8");

//receive variavles from reportAccident.php file
session_start();
$accidentReport	= $_SESSION['accidentReport'];

// http://stackoverflow.com/questions/60174/how-can-i-prevent-sql-injection-in-php
$query="INSERT INTO AccidentReport (Longitude,Latitude,AccidentType,
AmountOfDead,AmountOfInjured,TrafficBlocked,Message,DateTime)
VALUES (?,?,?,?,?,?,?,?)";
$stmt = $con->prepare($query);
$stmt->bind_param("ddsiibss", 
                $accidentReport->longitude,$accidentReport->latitude,$accidentReport->accidentType,
		$accidentReport->amountOfDead,$accidentReport->amountOfInjured,
		$accidentReport->trafficBlocked,$accidentReport->message,$accidentReport->dateTime);
$stmt->execute();
?>