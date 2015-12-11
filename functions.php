<?php
    //loome AB ühenduse
	require_once("../config_global.php");
	require_once("user.class.php");
	require_once("job.class.php");
	require_once("insert.class.php");
	require_once("profile.class.php");
	require_once("admin.class.php");
    $database = "if15_raunkos_ntb";
	
	//paneme sessiooni serveris toole, saame kasutada SESSIOS[]
	session_start();

	$mysqli = new mysqli($servername, $server_username, $server_password, $database);

	$User = new User($mysqli);
	$Job = new Job($mysqli);
	$Insert = new Insert($mysqli);
	$Profile = new Profile($mysqli);
	$Admin = new Admin($mysqli);
	
//Ümber tegemisele
			function filterParish() {
				$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
				
				$stmt = $mysqli->prepare("SELECT parish, COUNT(parish) FROM job_offers WHERE active IS NOT NULL AND deleted IS NULL GROUP BY parish");
				$stmt->bind_result($parish_from_db, $parish_count_db);
				$stmt->execute();
        
				$array = array();
			//Iga rea kohta teeme midagi
				while($stmt->fetch()) {
					$job_parish = new StdClass();
					$job_parish->parish = $parish_from_db;
					$job_parish->parish_count = $parish_count_db;
					array_push($array, $job_parish);
			}
				return $array;
				//Saime andmed katte
				echo($name_from_db);
				
			
		$stmt->close();
		$mysqli->close();
	}
	
			function filterLocation() {
				$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
				
				$stmt = $mysqli->prepare("SELECT location, COUNT(location) FROM job_offers WHERE active IS NOT NULL AND deleted IS NULL GROUP BY location");
				$stmt->bind_result($location_from_db, $location_count_db);
				$stmt->execute();
        
				$array = array();
			//Iga rea kohta teeme midagi
				while($stmt->fetch()) {
					$job_location = new StdClass();
					$job_location->location = $location_from_db;
					$job_location->location_count = $location_count_db;
					array_push($array, $job_location);
			}
				return $array;
				//Saime andmed katte
				echo($name_from_db);
				
			
		$stmt->close();
		$mysqli->close();
	}
//Ümber tegemisele lõpp


	
	
	
	
	
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
	
	
 ?>