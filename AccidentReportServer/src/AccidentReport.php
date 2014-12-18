<?php
class AccidentReport{
        
        public $imei; // NOT IN Constructor
	public $longitude;
	public $latitude;
	public $accidentType;
	public $amountOfDead;
	public $amountOfInjured;
	public $trafficBlocked;
	public $message;
	public $dateTime;

	//Server Side
	public $serverDateTime;
	public $resolve;

	function __construct($longitude,$latitude,$accidentType,$amountOfDead,
			$amountOfInjured, $trafficBlocked, $message, $dateTime)
	{
		$this->longitude = $longitude;
		$this->latitude = $latitude;
		$this->accidentType = $accidentType;
		$this->amountOfDead = $amountOfDead;
		$this->amountOfInjured = $amountOfInjured;
		$this->trafficBlocked = $trafficBlocked;
		$this->message = $message;
		$this->dateTime = $dateTime;
                
                $this->imei = "";
		$this->serverDateTime = 0;
		$this->resolve = 0;
	}
};
?>