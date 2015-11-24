<?php

	require_once("../../config_global.php");
	require_once("user.class.php");
	session_start();
	
	$mysqli = new mysqli($servername, $server_username, $server_password, $dbname);
	
	$User = new User($mysqli);
	
	

  
 ?>