<?php
class RescueUnit{
	public $imei;
	public $longitude;
	public $latitude;
	public $status;
	
	function __construct($longitude,$latitude,$accidentType,$amountOfDead,
			$amountOfInjured,$trafficBlocked,$message,$dateTime)
	{
		$this->imei = $imei;
		$this->longitude = $longitude;
		$this->latitude = $latitude;
		$this->status = $status;
	}
};
?>
