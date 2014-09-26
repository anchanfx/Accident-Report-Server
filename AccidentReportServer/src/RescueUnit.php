<?php
class RescueUnit{
	public $imei;
	public $longitude;
	public $latitude;
	public $online;
	public $available;

	function __construct($longitude,$latitude,$online,$available)
	{
		$this->imei = $imei;
		$this->longitude = $longitude;
		$this->latitude = $latitude;
		$this->online = $online;
		$this->available = $available;
	}
};
?>
