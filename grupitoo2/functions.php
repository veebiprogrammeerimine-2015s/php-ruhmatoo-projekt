<?php
		//********************ENDA***************************************
	
	//kõik AB'iga seonduv
	
	// ühenduse loomiseks kasuta
	require_once("../../../../configglobal.php");
	$database = "if15_kkkaur";
	
	//panen sessiooni käima, saame kasutada $_session muutujaid
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
	
	
	#					$stmt = $mysqli->prepare("INSERT INTO test (id, critic) VALUES (?, ?)");
	#					$stmt->bind_param("is", $_SESSION["id_from_db"], $critic); 
	
	
	
	function insertreview($critic){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		echo $_SESSION["id_from_db"]; #Leht saab andmebaasist kasutaja id ilusasti kätte ja prindib selle lehele välja
		$stmt = $mysqli->prepare("INSERT INTO test2 (user_id, critic) VALUES (?, ?)");
		$stmt->bind_param("is", $_SESSION["id_from_db"], $critic); 
		######### SIIN REAL VISKAB ERRORI #########
			#   Fatal error: Call to a member function bind_param() on a non-object in /home/kaurkal/public_html/GT_Kaur_Tauno_Koit/php-ruhmatoo-projekt/grupitoo2/functions.php on line 52 		
			# Vist on kamm, et ta ei sisesta andmebaasist saadud kasutaja id-d uute tabelisse?
		if($stmt->execute()){
			// sisestan sõnumi, mis tuleb juhul, kui andmed sisestati edukalt!
			$message = "Edukalt sisestatud andmebaasi";
			
		}else{
			// execute on false, miski läks katki
			echo $stmt->error;		
			$stmt->close();
		}
		$mysqli->close();		
	}
	
	//sisestame autonumbri sisestusfunktsiooni
	function createCarPlate($number_plate, $color){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO car_plates (user_id, number_plate, color) VALUES (?, ?, ?)");
		$stmt->bind_param("iss", $_SESSION["id_from_db"], $number_plate, $color);
		$message = "";
		
		if($stmt->execute()){
			//see on tõene siis, kui sisestus andmebaasi õnnestus
			$message = "Edukalt sisestatud andmebaasi!";
		}else{
			//execute is false, ehk sisestus ei õnnestunud
		echo $stmt->error;}
		
		$stmt->close();
		
		$mysqli->close();		
		return $message;
	}
	// "return sample" näide (kommenteeri välja)
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