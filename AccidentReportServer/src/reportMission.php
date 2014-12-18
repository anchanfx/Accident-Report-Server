 <?php
	header('Content-Type: text/html; charset=utf-8');
	require_once ('DB.php');
	require_once ('JSONObjectAdapter.php');
	require_once ('MissionReport.php');
	require_once ('Time.php');
        require_once ('AccidentReporterMessagePolling.php');
        
	function run(){
		$jsonString = file_get_contents('php://input');

		if(!empty($jsonString))
		{
			$db = new DB();
			$jsonObj = new JSONObjectAdapter();
			$timeThai = new Time();
			$jsonAdapter = new JSONObjectAdapter();
			$missionReport = $jsonAdapter->extractMissionReport($jsonString);
			$missionReport->ServerDateTime = $timeThai->getThailandTime();
			
			$db->connect();
			$db->insertMissionReport($missionReport);
			$msg = $db->selectMessage('0000');
			$db->closeDB();
                        processMissionReport($missionReport);
                        
			$msgJson = $jsonAdapter->packReportAcknowledge($msg);
			echo $msgJson;
		}
	}
        
        function processMissionReport($missionReport) {
                $state = $missionReport->RescueState;
                $accept = 1;
                $reject = -1;
                $complete = 100;
                
                switch ($state) {
                        case $accept:
                                processMissionAcceptance($missionReport);
                                break;
                        case $reject:
                                // ??
                                break;
                        case $complete:
                                resolveAccident($missionReport);
                                break;
                        default:
                }
        }
        
        function processMissionAcceptance($missionReport) {
                $db = new DB();
                $db->connect();
		$msg = $db->selectMessage('sr01');
                $db->closeDB();
                
                storeAccidentReporterMessage($missionReport, $msg);
        }
        
        function storeAccidentReporterMessage($missionReport, $message) {
                $pull = 0;
                
                $data = new AccidentReporterMessagePolling(
                        $missionReport->ServerDateTime,
                        $missionReport->AccidentID,
                        $message,
                        $pull);
                $db = new DB();
                $db->connect();
		$db->insertAccidentReporterMessagePolling($data);
                $db->closeDB();
        }
        
        function resolveAccident($missionReport){
                $resolve = 1;
                
        	$db = new DB();
        	$db->connect();
                $db->updateAccidentResolve($resolve, $missionReport->AccidentID);
        	$db->closeDB();
        }
        
	run();
?>