<?php

	require_once("user_class.php");
	require_once("../config_global.php");
	
	$database = "if15_Jork";
	
	session_start();
	
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	
		//saadan ühenduse classi ja loon uue classi
	$User = new User($mysqli);

	
	function cleanInput($data) {
  	  $data = trim($data);
  	  $data = stripslashes($data);
  	  $data = htmlspecialchars($data);
  	  return $data;
    }
	
	$message= "";
	
	function registerAnimal($owner_name, $animal_name, $animal_kind, $date, $problem){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO looma_omanikud (oid, nimi, o_looma_nimi) VALUES (?, ?, ?)");
		$stmt->bind_param("iss", $id, $owner_name, $animal_name);

		$stmt->close();
		
		
		
		$stmt = $mysqli->prepare("INSERT INTO loomad (lid, looma_nimi, omaniku_nimi, looma_liik, looma_kirjeldus) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("issss", $id, $animal_name, $owner_name, $animal_kind, $problem);

		$stmt->close();

		$stmt = $mysqli->prepare("INSERT INTO vastuv6tuajad (aeg, looma_nimi) VALUES (?, ?)");
		$stmt->bind_param("ss", $date, $animal_name);

		$stmt->close();
		$mysqli->close();
		
		
	}


?>