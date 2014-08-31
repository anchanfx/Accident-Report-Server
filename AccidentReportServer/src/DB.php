<?php
require_once('AccidentReport.php');

function selectMessage($con,$code){
	$stmt = $con->prepare("SELECT description FROM Message WHERE code = ?");
	$stmt->bind_param("s",$code);
	$stmt->execute();
	$stmt->bind_result($result);
	$stmt->fetch();
	$stmt->close();
	return $result;
}

function insertAccidentData($con,$data){

	$query="INSERT INTO AccidentReport (Longitude,Latitude,AccidentType,
			AmountOfDead,AmountOfInjured,TrafficBlocked,Message,DateTime)
			VALUES (?,?,?,?,?,?,?,?)";
	$stmt = $con->prepare($query);
	$stmt->bind_param("ddsiiiss",
			$data->longitude,$data->latitude,$data->accidentType,
			$data->amountOfDead,$data->amountOfInjured,
			$data->trafficBlocked,$data->message,$data->dateTime);
	$stmt->execute();
	$stmt->close();
}
?>