<?php
	require_once('AccidentReport.php');
	require_once('RescueUnit.php');
	require_once('AccidentPolling.php');
	require_once('config.php');
	
	class DB{
		var $con;
	
		function connect(){
			$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
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
		
		function selectAccidentReport($id)
		{
			$conn = $this->con;
			$stmt = $conn->prepare("SELECT * FROM AccidentReport WHERE ID = ?");
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($id, $longitude,$latitude,$accidentType,
		                        $amountOfDead,$amountOfInjured,
		                        $trafficBlocked,$message,$dateTime, $serverDateTime, $resolve);
	
			$stmt->fetch();
			$stmt->close();
	
			$result = new AccidentReport($longitude,$latitude,$accidentType,
	                    $amountOfDead,$amountOfInjured,
						$trafficBlocked,$message,$dateTime);
			$result->serverDateTime = $serverDateTime;
			$result->resolve = $resolve;
			
			return $result;
		}
	
		function insertAccidentData($data){
			$conn = $this->con;
			$query="INSERT INTO AccidentReport (Longitude,Latitude,AccidentType,
			AmountOfDead,AmountOfInjured,TrafficBlocked,Message,DateTime,ServerDateTime,Resolve)
			VALUES (?,?,?,?,?,?,?,?,?,?)";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("ddsiiisssi",
					$data->longitude,$data->latitude,$data->accidentType,
					$data->amountOfDead,$data->amountOfInjured,
					$data->trafficBlocked,$data->message,$data->dateTime,
					$data->serverDateTime,$data->resolve);
			$stmt->execute();
			$stmt->close();
		}
		
		function insertMissionReport($data){
			$conn = $this->con;
			$query="INSERT INTO MissionReport 
			(ServerDateTime, IMEI,AccidentID,RescueState,DateTime,Message)
			VALUES (?,?,?,?,?,?)";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("ssiiss", 
					$data->ServerDateTime,
					$data->IMEI, $data->AccidentID, $data->RescueState,
					$data->DateTime,$data->Message);
			$stmt->execute();
			$stmt->close();
		}

		function insertAccidentPolling($data){
			$conn = $this->con;
			$query="INSERT INTO AccidentPolling 
			(DateTime, IMEI, AccidentID, Pull)
			VALUES (?,?,?,?)";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("ssii",
					$data->DateTime, $data->IMEI, 
					$data->AccidentID, $data->Pull);
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
	
		function updatePullInAccidentPolling($dateTime, $pull) {
			$con = $this->con;
			$queryString = "UPDATE AccidentPolling SET Pull=? 
							WHERE DateTime=?";
							
			$stmt = $con->prepare($queryString);
			$stmt->bind_param("is", $pull, $dateTime);
	        $stmt->execute();
	        $stmt->close();
		}
	}
?>