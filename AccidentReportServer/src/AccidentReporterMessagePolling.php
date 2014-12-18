<?php
        class AccidentReporterMessagePolling {

		public $DateTime;
		public $AccidentID;
                public $Message;
		public $Pull;

		function __construct($dateTime,$accidentID, $message, $pull)
		{
			$this->DateTime = $dateTime;
			$this->AccidentID = $accidentID;
                        $this->Message = $message;
			$this->Pull = $pull;
		}
	};
?>