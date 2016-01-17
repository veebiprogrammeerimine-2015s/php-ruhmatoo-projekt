<?php 
 
 	require_once("config.php"); 
 	require_once("User_Class.php"); 
 	 
	$database = "if15_vitamak"; 
 	 
 	//session_start(); 
 	 
 	//loome ab'i uhenduse 
 	$mysqli = new mysqli($servername, $server_username, $server_password, $database); 
 	 
 	//Uus instants klassist User 
 	$User = new User($mysqli); 
 	 

 	 
 	 
 ?> 
