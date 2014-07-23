<?php
header('Content-Type: text/html; charset=utf-8');
$jsonString = file_get_contents('php://input');
$jsonObj = json_decode($jsonString);
$acknowledge = array();

// specify the file where we will save the contents of the variable message
$filename="json_messages.html";

$host="fdb7.runhosting.com";
$username="1679495_dbacc";
$pass_word="tot_1288";
$DB="1679495_dbacc";

// connect database
$con=mysqli_connect( $host,$username,$pass_word,$DB) or die ("ติดต่อ Mysql ไม่ได้ ");

if( !empty($jsonObj)) {

	$latitude = $jsonObj->AccidentReportData->Position->Latitude;
	$longitude = $jsonObj->AccidentReportData->Position->Longitude;
	$accidentType = $jsonObj->AccidentReportData->AdditionalInfo->AccidentType;
	$amountOfInjured = $jsonObj->AccidentReportData->AdditionalInfo->AmountOfInjured;
	$amountOfDead = $jsonObj->AccidentReportData->AdditionalInfo->AmountOfDead;
	$trafficBlocked = $jsonObj->AccidentReportData->AdditionalInfo->TrafficBlocked;
	$message = $jsonObj->AccidentReportData->AdditionalInfo->Message;
	$date = $jsonObj->AccidentReportData->Date->Date;
        
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
                
	// write (append) the data to the file
	file_put_contents($filename,
	"Latitude = ".$latitude.
	", Longtitude = ".$longitude.
	", AccidentType = ".$accidentType.
	", AmountOfInjured = ".$amountOfInjured.
	", AmountOfDead = ".$amountOfDead.
	", TrafficBlocked = ".$trafficBlocked.
	", Message = ".$message.
	", Date = ".$date.
	"<br />",
	FILE_APPEND);

	$acknowledge['AcknowledgeInfo']['Message'] = 'Report Acknowledged';
	echo json_encode($acknowledge);
        
	exit();
}

// load the contents of the file to a variable
$androidmessages=file_get_contents($filename);

// display the contents of the variable (which has the contents of the file)
echo $androidmessages;

?>