<?php

	require_once("user_class.php");
	require_once("../config_global.php");
	
	$database = "if15_Jork";
	
	session_start();
	
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	
		//saadan ühenduse classi ja loon uue classi
	$User = new User($mysqli);
	
	?>