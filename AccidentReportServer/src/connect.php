<?php
	$host = "fdb7.runhosting.com";
	$user = "1679495_dbacc";
	$pass = "tot_1288";
	$name = "1679495_dbacc";
	 
	$con = mysqli_connect($host, $user, $pass, $name);
	
	if (mysqli_connect_error()) {
		echo "Fail to connect to mysql: " . mysqli_connect_error();
	}
?>