<?php
header('Content-Type: text/html; charset=utf-8');
require_once('AccidentReport.php');
$host="fdb7.runhosting.com";
$username="1679495_dbacc";
$pass_word="tot_1288";
$DB="1679495_dbacc";

// connect database
$con=mysqli_connect( $host,$username,$pass_word,$DB) or die ("ติดต่อ Mysql ไม่ได้ ");

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