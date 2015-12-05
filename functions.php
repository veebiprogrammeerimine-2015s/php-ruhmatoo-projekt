<?php
	require_once("../configglobal.php");
	require_once("User.class.php");
	
	
	
	session_start();
	
	//loome ab'i ühenduse
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);

	mysqli_set_charset($mysqli, "utf8");
	//Uus instants klassist User
	$User = new User($mysqli);
	
	
	//näita backu button
	function createBackButton($href_to_back){
			
		echo '<a href="'.$href_to_back.'" class="btn btn-info" role="button">Tagasi</a>';
		
	}
	
?>