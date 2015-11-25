<?php 
	
	require_once("../config_global.php");
	require_once("user.class.php");
	
	$database = "if15_robing_3";
	
	session_start();
	
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	
	//saadan ühenduse classi ja loon uue classi
	$user = new user($mysqli);
	
	//var_dump($User->connection);
	
?>