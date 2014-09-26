<?php
require_once('AccidentReport.php');
require_once('RescueUnit.php');
require_once('AccidentPolling.php');

class DB{
	var $con;

	function connect(){
		$host = "fdb7.runhosting.com";
		$user = "1679495_dbacc";
		$pass = "tot_1288";
		$name = "1679495_dbacc";
	
		$conn = mysqli_connect($host, $user, $pass, $name);
		$conn->set_charset("utf8");
	
		if (mysqli_connect_error()) {
			echo "Fail to connect to mysql: " . mysqli_connect_error();
		}
		$this->con = $conn;
	}
	
	function closeDB(){
		mysqli_close($this->con) or die("Can't Close Connection");
	}
	
	function selectMessage($code){
		$conn = $this->con;
		$stmt = $conn->prepare("SELECT description FROM Message WHERE code = ?");
		$stmt->bind_param("s",$code);
		$stmt->execute();
		$stmt->bind_result($result);
		$stmt->fetch();
		$stmt->close();
		return $result;
	}
	
	function insertAccidentData($data){
		$conn = $this->con;
		$query="INSERT INTO AccidentReport (Longitude,Latitude,AccidentType,
		AmountOfDead,AmountOfInjured,TrafficBlocked,Message,DateTime)
		VALUES (?,?,?,?,?,?,?,?)";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("ddsiiiss",
				$data->longitude,$data->latitude,$data->accidentType,
				$data->amountOfDead,$data->amountOfInjured,
				$data->trafficBlocked,$data->message,$data->dateTime);
		$stmt->execute();
		$stmt->close();
	}
	
	function rescueUpdate($info){
		$conn = $this->con;
		$query="INSERT INTO RescueUnit (IMEI,Longitude,Latitude,Online,Available)
		VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("siiii",
				$info->imei,$info->longitude,$info->latitude,$info->status,$info->available);
		$stmt->execute();
		$stmt->close();
	}
        
	function selectAccidentPollingThatsNotYetPulled($imei) {
		$accidentPollings = array();
		$queryString = "SELECT * 
						FROM AccidentPolling 
						WHERE IMEI=? AND Pull=0
						ORDER BY DateTime ASC";
		$con = $this->con;

		$stmt = $con->prepare($queryString);
		$stmt->bind_param("s", $imei);
		$stmt->execute();

		$stmt->bind_result($dateTime, $imei, $accidentID, $pull);

		while ($stmt->fetch()) { 
			$singleData = new AccidentPolling($dateTime, $imei, $accidentID, $pull);
			array_push($accidentPollings, $singleData);
		}

		$stmt->close();

		return $accidentPollings;
	}

	function updatePullInAccidentPolling($dateTime, $imei, $accidentID, $pull) {
		$con = $this->con;
		$queryString = "UPDATE AccidentPolling SET Pull=? 
						WHERE DateTime=? AND IMEI=? AND AccidentID=?";
						
		$stmt = $con->prepare($queryString);
		$stmt->bind_param("issi", $pull, $dateTime, $imei, $accidentID);
        $stmt->execute();
        $stmt->close();
	}
}
?>