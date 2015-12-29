<?php

	require_once("user_class.php");
	require_once("../config_global.php");
	
	$database = "if15_Jork";
	
	session_start();
	
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	
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
		//echo $mysqli->error; 
		$stmt = $mysqli->prepare("INSERT INTO owners (oid, name, o_animal_name) VALUES (?, ?, ?)");
		$stmt->bind_param("iss", $id, $owner_name, $animal_name);
		
		$message= "";
		
		if($stmt->execute()){
			$message = "Sai edukalt lisatud omanikud. ";
		}else{
			echo $stmt->error;
		}
		$stmt->close();
		
		
		$stmt = $mysqli->prepare("INSERT INTO animals (lid, animal_name, owner_name, species, description) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("issss", $id, $animal_name, $owner_name, $animal_kind, $problem);
		
		
		
		if($stmt->execute()){
			$message .= "Sai edukalt lisatud loomad. ";
		}else{
			echo $stmt->error;
		}
		$stmt->close();
		
		
		$stmt = $mysqli->prepare("INSERT INTO times (time, time_animal_name) VALUES (?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ss", $date, $animal_name);
		
	
		if($stmt->execute()){
			$message .= "Sai edukalt lisatud vastuv6tuajad. ";
		}else{
			echo $stmt->error;
		}
		return $message;
		$stmt->close();
		$mysqli->close();
		
		
	}
	
		function DoctorView($doctor_name, $procedure_name, $operation_name, $operation_date, $operation_difficulty, $d_animal_name){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		//echo $mysqli->error; 
		$stmt = $mysqli->prepare("INSERT INTO vets (aid, dr_name, a_animal_name) VALUES (?, ?, ?)");
		$stmt->bind_param("iss", $id, $doctor_name, $d_animal_name);
		
		$message= "";
		
		if($stmt->execute()){
			$message = "Sai edukalt lisatud arstid. ";
		}else{
			echo $stmt->error;
		}
		$stmt->close();
		
		
		$stmt = $mysqli->prepare("INSERT INTO procedures (p_doctor_name, procedure_name, dr_animal_name) VALUES (?, ?, ?)");
		$stmt->bind_param("sss",$doctor_name , $procedure_name, $d_animal_name);
		
		
		
		if($stmt->execute()){
			$message .= "Sai edukalt lisatud protseduurid. ";
		}else{
			echo $stmt->error;
		}
		$stmt->close();
		
		
		$stmt = $mysqli->prepare("INSERT INTO operations (o_doctor_name, operation_name, difficulty, op_animal_name, date) VALUES (?, ?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("sssss",$doctor_name, $operation_name, $operation_difficulty, $d_animal_name, $operation_date);
		
	
		if($stmt->execute()){
			$message .= "Sai edukalt lisatud operatsioonid. ";
		}else{
			echo $stmt->error;
		}
		return $message;
		$stmt->close();
		$mysqli->close();
		
		
	}



?>