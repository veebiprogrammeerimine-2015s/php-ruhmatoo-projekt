<?php
	require_once("../config_global.php");
	
	$database = "if15_teamalpha_3";
	
	session_start();
	
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
?>