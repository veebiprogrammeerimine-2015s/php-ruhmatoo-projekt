<?php

	//Loome ühenduse andmebaasiga
	require_once("../../../../config_global.php");
	$database = "if15_Harri_bowling";
	session_start();
	
	
	//hakkame andmeid andmebaasi sisestama (exam, grade, mistakes)
	function createUser($username, $firstname, $lastname, $email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO kasutajad (username, email, password, firstname, lastname) VALUES (? , ?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("sssss", $username ,$email, $hash, $firstname, $lastname);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
	}
	function loginUser($username, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, username FROM kasutajad WHERE username=? AND password=?");
		$stmt->bind_param("ss", $username, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){

			
			//tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			header("Location: member.php");
			exit();

			
		}else{
			echo "Wrong credentials";
		}


		$stmt->close();
		$mysqli->close();
		
	} 

		
?>