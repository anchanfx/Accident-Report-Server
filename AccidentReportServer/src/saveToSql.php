<?php
$host="fdb7.runhosting.com";
$username="1679495_dbacc";
$pass_word="tot_1288";
$DB="1679495_dbacc";

// connect database
$con=mysqli_connect( $host,$username,$pass_word,$DB) or die ("�Դ��� Mysql ����� ");

//receive variavles from receiveFromApp.php file
session_start();
$latitude			= $_SESSION['latitude'];
$longitude			= $_SESSION['longitude'];
$accidentType		= $_SESSION['accidentType'];
$amountOfInjured	= $_SESSION['amountOfInjured'];
$amountOfDead		= $_SESSION['amountOfDead'];
$trafficBlocked		= $_SESSION['trafficBlocked'];
$message			= $_SESSION['message'];
$date				= $_SESSION['date'];

// PHP �ͧ��� True=1 False=NULL ����� MySQL ERROR ��µ�ͧ��˹������ 0
if(empty($trafficBlocked))
{
	$trafficBlocked = 0;
}

// �� Insert ��ҹ��ҧⴹ SQL Injection ��
// �ӻ�ͧ�ѹ SQL Injection �Ըյ����駴�ҹ��ҧ
// http://stackoverflow.com/questions/60174/how-can-i-prevent-sql-injection-in-php
mysqli_query($con,"INSERT INTO infoFromApp (Latitude,Longtitude,AccidentType,
AmountOfInjured,AmountOfDead,TrafficBlocked,Message,Date)
VALUES ($latitude, $longitude,'$accidentType',$amountOfInjured,$amountOfDead,
$trafficBlocked,'$message','$date')");