<?php
	class MissionReport{
		public $IMEI;
		public $AccidentID;
		public $RescueState;
		public $DateTime;
		public $Message;

		function __construct($IMEI,$AccidentID,$RescueState,$DateTime,$Message)
		{
			$this->IMEI = $IMEI;
			$this->AccidentID = $AccidentID;
			$this->RescueState = $RescueState;
			$this->DateTime = $DateTime;
			$this->Message = $Message;
		}
	};
?>