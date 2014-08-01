<?php
	class AccidentReport{
		
		private $longitude;
		private $latitude;
		private $accidentType;
		private $amountOfDead;
		private $amountOfInjured;
		private $trafficBlocked;
		private $message;
		private $dateTime;
		
		function __construct($longitude,$latitude,$accidentType,$amountOfDead,
				$amountOfInjured,$trafficBlocked,$message,$dateTime)
		{
			$this->longitude = $longitude;
			$this->latitude = $latitude;
			$this->accidentType = $accidentType;
			$this->amountOfDead = $amountOfDead;
			$this->amountOfInjured = $amountOfInjured;
			$this->trafficBlocked = $trafficBlocked;
			$this->message = $message;
			$this->dateTime = $dateTime;
		}
	};
?>