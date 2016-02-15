<?php
		//********************ENDA***************************************
	
	//k�ik AB'iga seonduv
	
	// �henduse loomiseks kasuta
	require_once("../../../../configglobal.php");
	$database = "if15_kkkaur";
	
	//panen sessiooni k�ima, saame kasutada $_session muutujaid
	session_start();
	// lisame kasutaja andmebaasi'i
	function createUser($create_email, $password_hash){	
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		$stmt->bind_param("ss", $create_email, $password_hash);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();		
	}
	
	//logime sisse
	function loginUser($email, $password_hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $password_hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			echo "kasutaja id=".$id_from_db;
			$_SESSION["id_from_db"] = $id_from_db;
			$_SESSION["user_email"] = $email_from_db;
			header("Location: landingpage.php");
		}else{
			echo " - Wrong password or email!";
		}
		$stmt->close();
		$mysqli->close();
		}
	
	

	
	
	# TESTFUNKTSIOON "CRITIC"
	function insertreview($critic){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO test2 (user_id, critic) VALUES (?, ?)");
		$stmt->bind_param("is", $_SESSION["id_from_db"], $critic); 
		$message = "";
		if($stmt->execute()){
			// sisestan s�numi, mis tuleb juhul, kui andmed sisestati edukalt!
			$message = "�levaade on edukalt sisestatud andmebaasi. Ait�h!";
			
		}else{
			// execute on false, miski l�ks katki
			echo $stmt->error;		
			$stmt->close();
		}
		$mysqli->close();
		return $message;
	}
	
	//sisestame autonumbri sisestusfunktsiooni
	function createCarPlate($number_plate, $color){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO car_plates (user_id, number_plate, color) VALUES (?, ?, ?)");
		$stmt->bind_param("iss", $_SESSION["id_from_db"], $number_plate, $color);
		$message = "";
		
		if($stmt->execute()){
			//see on t�ene siis, kui sisestus andmebaasi �nnestus
			$message = "Edukalt sisestatud andmebaasi!";
		}else{
			//execute is false, ehk sisestus ei �nnestunud
		echo $stmt->error;}
		
		$stmt->close();
		
		$mysqli->close();		
		return $message;
	}
	// "return sample" n�ide (kommenteeri v�lja)
	/*
	function welcome($name){
		$string = "Tere" .$name;
		return $string;
		echo "Hellloooooooo";
	}
	$str = welcome("Kaur");
	echo $str;
	*/
	
	
	

?>