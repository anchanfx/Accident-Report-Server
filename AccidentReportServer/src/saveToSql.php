<?php
$host="fdb7.runhosting.com";
$username="1679495_dbacc";
$pass_word="tot_1288";
$DB="1679495_dbacc";

// connect database
$con=mysqli_connect( $host,$username,$pass_word,$DB) or die ("ติดต่อ Mysql ไม่ได้ ");

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

// PHP มองค่า True=1 False=NULL ทำให้ MySQL ERROR เลยต้องกำหนดให้เป็น 0
if(empty($trafficBlocked))
{
	$trafficBlocked = 0;
}

// โค้ด Insert ด้านล่างโดน SQL Injection ได้
// ทำป้องกัน SQL Injection วิธีตามลิ้งด้านล่าง
// http://stackoverflow.com/questions/60174/how-can-i-prevent-sql-injection-in-php
mysqli_query($con,"INSERT INTO infoFromApp (Latitude,Longtitude,AccidentType,
AmountOfInjured,AmountOfDead,TrafficBlocked,Message,Date)
VALUES ($latitude, $longitude,'$accidentType',$amountOfInjured,$amountOfDead,
$trafficBlocked,'$message','$date')");