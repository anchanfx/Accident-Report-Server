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
			$stmt->bind_result($id, $imei, $longitude,$latitude,$accidentType,
                                        $amountOfDead,$amountOfInjured,
		                        $trafficBlocked,$message,$dateTime, $serverDateTime, $resolve);
	
			$stmt->fetch();
			$stmt->close();
	
			$result = new AccidentReport($longitude,$latitude,$accidentType,
	                    $amountOfDead,$amountOfInjured,
						$trafficBlocked,$message,$dateTime);
                        $result->imei = $imei;
			$result->serverDateTime = $serverDateTime;
			$result->resolve = $resolve;
			
			return $result;
		}
	
		function insertAccidentData($data){
			$conn = $this->con;
			$query="INSERT INTO AccidentReport (IMEI, Longitude,Latitude,AccidentType,
			AmountOfDead,AmountOfInjured,TrafficBlocked,Message,DateTime,ServerDateTime,Resolve)
			VALUES (?,?,?,?,?,?,?,?,?,?,?)";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("sddsiiisssi",$data->imei,
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
			(ServerDateTime, IMEI,AccidentID,RescueState,AssignDateTime,DateTime,Message)
			VALUES (?,?,?,?,?,?,?)";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("ssiisss", 
					$data->ServerDateTime,
					$data->IMEI, $data->AccidentID, $data->RescueState,
					$data->AssignDateTime,$data->DateTime,$data->Message);
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
                
                function insertAccidentReporterMessagePolling($data){
			$conn = $this->con;
			$query= "INSERT INTO AccidentReporterMessagePolling 
			(DateTime, AccidentID, Message, Pull)
			VALUES (?,?,?,?)";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("sisi",
					$data->DateTime, $data->AccidentID, 
					$data->Message, $data->Pull);
			$stmt->execute();
			$stmt->close();
		}
                
		function rescueUpdate($info){
			$conn = $this->con;
			$query="INSERT INTO RescueUnit (Longitude,Latitude,Online,Available,IMEI)
					VALUES (?,?,?,?,?) ON DUPLICATE KEY 
					UPDATE Longitude=?,Latitude=?,Online=?,Available=?";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("ddiisddii",
					$info->longitude,$info->latitude,$info->online,$info->available,$info->imei,
					$info->longitude,$info->latitude,$info->online,$info->available);
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
	
		function updatePullInAccidentPolling($accidentPolling, $pull) {
			$con = $this->con;
			$queryString = "UPDATE AccidentPolling SET Pull=? 
							WHERE DateTime=? AND IMEI=? AND AccidentID=?";
							
			$stmt = $con->prepare($queryString);
			$stmt->bind_param("issi", $pull, 
				$accidentPolling->DateTime, $accidentPolling->IMEI, 
				$accidentPolling->AccidentID);
                        $stmt->execute();
                        $stmt->close();
		}
                
        function selectAccidentReporterMessagePollingThatsNotYetPulled($imei) {
			$accidentReporterMessagePollings = array();
			$queryString = "SELECT ARMP.DateTime, ARMP.AccidentID, ARMP.Message, ARMP.Pull
                                        FROM AccidentReporterMessagePolling AS ARMP 
                                                JOIN AccidentReport AS AR
                                                ON ARMP.AccidentID = AR.ID
                                        WHERE AR.IMEI=? AND Pull=0
                                        ORDER BY DateTime ASC";
			$con = $this->con;
	
			$stmt = $con->prepare($queryString);
			$stmt->bind_param("s", $imei);
			$stmt->execute();
	
			$stmt->bind_result($dateTime, $accidentID, $message, $pull);
	
			while ($stmt->fetch()) { 
				$singleData = new AccidentReporterMessagePolling($dateTime, $accidentID, $message, $pull);
				array_push($accidentReporterMessagePollings, $singleData);
			}
	
			$stmt->close();
	
			return $accidentReporterMessagePollings;
		}
                
        function updatePullInAccidentReporterMessagePolling($accidentReporterMessage, $pull) {
			$con = $this->con;
			$queryString = "UPDATE AccidentReporterMessagePolling SET Pull=? 
							WHERE DateTime=? AND AccidentID=?";
							
			$stmt = $con->prepare($queryString);
			$stmt->bind_param("isi", $pull, 
				$accidentReporterMessage->DateTime, $accidentReporterMessage->AccidentID);
                        $stmt->execute();
                        $stmt->close();
		}
		
		function updateAccidentResolve($resolve, $accidentID){
			$con = $this->con;
			$query = "UPDATE AccidentReport SET Resolve=? WHERE ID=?";
				
			$stmt = $con->prepare($query);
			$stmt->bind_param("ii", $resolve, $accidentID);
			$stmt->execute();
			$stmt->close();
		}
	}
?>