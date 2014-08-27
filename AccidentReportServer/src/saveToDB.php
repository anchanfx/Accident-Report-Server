<?php
require_once('AccidentReport.php');
require('connect.php');
$con->set_charset("utf8");

session_start();
$accidentReport	= $_SESSION['accidentReport'];

$query="INSERT INTO AccidentReport (Longitude,Latitude,AccidentType,
AmountOfDead,AmountOfInjured,TrafficBlocked,Message,DateTime)
VALUES (?,?,?,?,?,?,?,?)";
$stmt = $con->prepare($query);
$stmt->bind_param("ddsiiiss", 
                $accidentReport->longitude,$accidentReport->latitude,$accidentReport->accidentType,
		$accidentReport->amountOfDead,$accidentReport->amountOfInjured,
		$accidentReport->trafficBlocked,$accidentReport->message,$accidentReport->dateTime);
$stmt->execute();
mysqli_close($con);
?>