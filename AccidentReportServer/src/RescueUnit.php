<?php
    class RescueUnit{
            public $longitude;
            public $latitude;
            public $online;
            public $available;
            public $imei;

            function __construct($longitude,$latitude,$online,$available,$imei)
            {
                    $this->longitude = $longitude;
                    $this->latitude = $latitude;
                    $this->online = $online;
                    $this->available = $available;
                    $this->imei = $imei;
            }
    };
?>
