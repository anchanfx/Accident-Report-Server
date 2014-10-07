<?php
	class MissionReport{
		//Server Side
		public $ServerDateTime;

		public $IMEI;
		public $AccidentID;
		public $RescueState;
		public $AssignDateTime;
		public $DateTime;
		public $Message;

		function __construct($IMEI,$AccidentID,$RescueState,$AssignDateTime,$DateTime,$Message)
		{
			$this->ServerDateTime = 0;
			
			$this->IMEI = $IMEI;
			$this->AccidentID = $AccidentID;
			$this->RescueState = $RescueState;
			$this->AssignDateTime = $AssignDateTime;
			$this->DateTime = $DateTime;
			$this->Message = $Message;
		}
	};
?>