<?php
	require_once("../configGLOBAL.php");
	$database = "if15_vitamak";
	
	
	// paneme sessiooni käima, saame kasutada $_SESSION muutujaid
	session_start();
	
	// lisame kasutaja ab'i
	function createUser($create_name, $create_secondname, $create_login, $password_hash, $create_email , $create_mobile){
		// globals on muutuja kõigist php failidest mis on ühendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_tech (name, lastname, login, psssword, email, mobile) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ssssss", $create_name, $create_secondname, $create_login, $password_hash, $create_email , $create_mobile);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();	
		
	}
	
	
	
	//logime sisse
	function loginUser($email, $password_hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM user_tech WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $password_hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			echo "kasutaja id=".$id_from_db;
			
			$_SESSION["id_from_db"] = $id_from_db;
			$_SESSION["user_email"] = $email_from_db;
			
			//suunan kasutaja data.php lehele
			header("Location: data.php");
			
			
		}else{
			echo " on wrong!";
		}
		$stmt->close();
		
		$mysqli->close();
	}
	