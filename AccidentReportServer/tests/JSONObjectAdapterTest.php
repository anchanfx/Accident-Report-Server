<?php

// FAX
require_once 'C:\Users\AnchanFX\Workspace\Git\Accident-Report-Server\AccidentReportServer\src\JSONObjectAdapter.php';
// GUN
//
// DEUAN
//

/**
 * Test class for JSONObjectAdapter.
 * Generated by PHPUnit on 2014-09-11 at 17:46:46.
 */
class JSONObjectAdapterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var JSONObjectAdapter
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new JSONObjectAdapter;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers JSONObjectAdapter::extractReportData
     */
    public function testExtractReportData()
    {
    	$accidentReport = array();
    	$accidentReport['AccidentData']['Position']['Latitude'] = 5.432;
    	$accidentReport['AccidentData']['Position']['Longitude'] = 2.435;
    	$accidentReport['AccidentData']['AdditionalInfo']['AccidentType'] = 'Test1';
    	$accidentReport['AccidentData']['AdditionalInfo']['AmountOfInjured'] = 100;
    	$accidentReport['AccidentData']['AdditionalInfo']['AmountOfDead'] = 0;
    	$accidentReport['AccidentData']['AdditionalInfo']['TrafficBlocked'] = false;
    	$accidentReport['AccidentData']['AdditionalInfo']['Message'] = 'TestData1';
    	$jsonObj = json_encode($accidentReport);
    	$result = $this->object->extractReportData($jsonObj);
    
    	//$expected = '{"AccidentData":{"Position":{"Latitude":5.432,"Longitude":2.435 },"AdditionalInfo":{"AccidentType":"Test1","AmountOfInjured":100,"AmountOfDead":0,"TrafficBlocked":false,"Message":"TestData1"}}}';
    
    	$this->assertEquals($accidentReport['AccidentData']['Position']['Latitude'], $result->latitude);
    	$this->assertEquals($accidentReport['AccidentData']['Position']['Longitude'], $result->longitude);
    	$this->assertEquals($accidentReport['AccidentData']['AdditionalInfo']['AccidentType'], $result->accidentType);
    	$this->assertEquals($accidentReport['AccidentData']['AdditionalInfo']['AmountOfInjured'], $result->amountOfInjured);
    	$this->assertEquals($accidentReport['AccidentData']['AdditionalInfo']['AmountOfDead'], $result->amountOfDead);
    	$this->assertEquals(0, $result->trafficBlocked);
    	$this->assertEquals($accidentReport['AccidentData']['AdditionalInfo']['Message'], $result->message);
    }
	
    public function testExtractRescueInfo() {
    	
    	$this->assertEquals("A", "");
    }
    
    public function testExtractIMEI() {
    	$imeiString = "123456789";
    	
    	$imei = array();
    	$imei['IMEI'] = $imeiString;
    	$jsonObj = json_encode($imei);
    	$result = $this->object->extractIMEI($jsonObj);
    	$this->assertEquals($result, $imeiString);
    }
    
    /**
     * @covers JSONObjectAdapter::packReportAcknowledge
     */
    public function testPackReportAcknowledge()
    {
    	$jsonObj = $this->object->packReportAcknowledge('TEST');
    	$jsonStr = (string)$jsonObj;
    	
        $this->assertEquals('{"AcknowledgeData":{"Message":"TEST"}}', $jsonStr);
    }
    
    public function testPackAccidentPolling() {
    	$dateTime = "2014-09-26 00:00:00";
    	$imei = "123456789";
    	$accidentID = 1;
    	$pull = 0;
    	
    	$accidentPolling = new AccidentPolling($dateTime, $imei, $accidentID, $pull);
    	$jsonObj = $this->object->packAccidentPolling($accidentPolling);
    	$jsonStr = (string)$jsonObj;
    	
    	$expected = '{"DateTime":"'.$dateTime.'","IMEI":"'.$imei.'","AccidentID":'.$accidentID.',"Pull":'.$pull.'}';
    	
    	
    	$this->assertEquals($expected, $jsonStr);
    }
    
    public function testPackAccidentData() {
    	$longitude = 12;
    	$latitude = 34;
    	$accidentType = "TESTTYPE";
    	$amountOfDead = 0;
    	$amountOfInjured = 5;
    	$trafficBlocked = 0;
    	$message = "TESTMSG";
    	$dateTime = "2014-09-26 00:00:00";
    
    	$accidentReport = new AccidentReport($longitude,$latitude,$accidentType,$amountOfDead,
    			$amountOfInjured,$trafficBlocked,$message,$dateTime);
    	 
    	$jsonObj = $this->object->packAccidentData($accidentReport);
    	$jsonStr = (string)$jsonObj;
    	 
    	$expected = '{"AccidentData":{"Position":{"Latitude":'.$latitude.',"Longitude":'.$longitude.'},"AdditionalInfo":{"AccidentType":"'.$accidentType.'","AmountOfInjured":'.$amountOfInjured.',"AmountOfDead":'.$amountOfDead.',"TrafficBlocked":'.$trafficBlocked.',"Message":"'.$message.'"}}}';
    	 
    	$this->assertEquals($expected, $jsonStr);
    }
}
?>

