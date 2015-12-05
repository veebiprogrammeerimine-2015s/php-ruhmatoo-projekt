<?php
	require_once("../../config_global.php");
    require_once("User.Class.php");
	$database = "if15_no_plagiarism";
	
	session_start();
	
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	$User = new User($mysqli);
?>