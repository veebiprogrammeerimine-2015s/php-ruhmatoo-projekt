<?php
	require_once("../../config_global.php");
	require_once("user.class.php");
	require_once("rate.class.php");


	$database = "if15_rate_my"; #Kui ma peaks teile edasipidi ka midagi sellist saatma siis pane asemele if15_rate_my

	session_start();

	$mysqli = new mysqli($servername, $server_username, $server_password, $database);

	$User = new User($mysqli);
	$Rate = new Rate($mysqli);


	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }

?>
