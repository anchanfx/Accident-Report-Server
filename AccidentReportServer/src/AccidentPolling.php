<?php
	class AccidentPolling{

		public $DateTime;
		public $IMEI;
		public $AccidentID;
		public $Pull;

		function __construct($dateTime,$imei,$accidentID,$pull)
		{
			$this->DateTime = $dateTime;
			$this->IMEI = $imei;
			$this->AccidentID = $accidentID;
			$this->Pull = $pull;
		}
	};
?>