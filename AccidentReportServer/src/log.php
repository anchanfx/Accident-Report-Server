<?php
header('Content-Type: text/html; charset=utf-8');

$log_file="log";

$log=file_get_contents($log_file);
echo $log;
?>