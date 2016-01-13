<?php
	require_once("../configglobal.php");
	$database = "if15_kertkulp";

	
	session_start();
	
	
	function createUser($create_email, $password_hash){
		
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO users (email, password) VALUE (?, ?)");
				
		
		
		
		
		$stmt->bind_param("ss", $create_email, $password_hash);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();
		
	}
	
	
	function loginUser($email, $password_hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM users WHERE email=? AND password=?");
		$stmt->bind_param("ss",$email, $password_hash);
		
		
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			echo"<br>";
			echo "kasutaja id=" .$id_from_db;
			
			$_SESSION["id_from_db"] = $id_from_db;
			$_SESSION["user_email"] = $email_from_db;
			
			header("Location: data.php");
			
		}else{
			
			echo "Wrong password or email";
			
		}
		
		$stmt->close();
		
		$mysqli->close();
	}
	
	function createCar($car_model, $car_make, $color){
		
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO add_car (user_id, model, make, color) VALUE (?, ?, ?, ?)");
				
		echo $mysqli->error;
		$stmt->bind_param("isss", $_SESSION["id_from_db"], $car_model, $car_make, $color);
		
		$message = "";
		
		if($stmt->execute()){
			$message = "Edukalt sisestatud andmebaasi";
			
		}else{
			echo$stmt->error;
		}
		
		
		$stmt->close();
		$mysqli->close();
		
		return $message;
		
	}
	
	require_once("../configglobal.php");
	$database = "if15_kertkulp";
	
	//loome uue funktsiooni
	function getCarData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, user_id, car_model, car_make, color FROM add_car WHERE deleted IS NULL");
		$stmt->bind_result($id, $user_id, $car_model, $car_make, $color);
		$stmt->execute();
		
		$array = array();
		
		while($stmt->fetch()){
			$car = new StdClass();
			$car->id = $id;
			$car->car_model= $car_model;
			$car->car_make= $car_make;
			$car->user_id = $user_id;
			$car->color = $color;
			
			array_push($array, $car);
			
			
			
		}
		
		$stmt->close();
		
		$mysqli->close();
		
		return $array;
	}
	
	function deleteCar($id_to_be_deleted){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE add_car SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id_to_be_deleted);
		
		if($stmt->execute()){
			
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	}
	
	getCarData();
?>
