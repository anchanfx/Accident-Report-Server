<?php
header('Content-Type: text/html; charset=utf-8');

$log_file="log";

// load the contents of the file to a variable
$log=file_get_contents($log_file);
// display the contents of the variable (which has the contents of the file)
echo $log;
?>