<?php
	//koik AB'iga seonduv
	
	// uhenduse loomiseks kasuta
	require_once("config.php");
	$database = "if15_jekavor";
	
	// paneme sessiooni kaima, saame kasutada $_SESSION muutujaid
	session_start();
	
	// lisame kasutaja ab'i
	function createUser($create_login, $create_email, $create_password_hash, $create_name, $create_secondname, $create_age){
		// globals on muutuja koigist php failidest mis on uhendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_tech (user_login, user_email, user_password, user_name, user_secondname, user_age) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("sssssi", $create_email, $create_password_hash);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();		
	}
	
	//logime sisse
	function loginUser($email, $password_hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT user_id, user_email FROM user_tech WHERE email=? AND password=?");
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
			echo "Wrong password or email!";
		}
		$stmt->close();
		
		$mysqli->close();
	}
	
	
	function create($car_plate, $color){
		// globals on muutuja koigist php failidest mis on uhendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO car_plates (user_id, number_plate, color) VALUES (?, ?, ?)");
		$stmt->bind_param("iss", $_SESSION["id_from_db"], $car_plate, $color);
		
		$message = "";
		
		if($stmt->execute()){
			// see on toene siis kui sisestus ab'i onnestus
			$message = "Edukalt sisestatud andmebaasi";
			
		}else{
			// execute on false, miski laks katki
			echo $stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		return $message;
		
	}
	
	
	/*
	// return sample
	
	function welcome($name){
		$string = "Tere ".$name;
		return $string;
		
		// mis on parast returni seda ei kaivitata
		echo "hellooooo";
		
	}
	
	$str = welcome("Romil");
	
	echo $str;
	
	*/
	
	
?>