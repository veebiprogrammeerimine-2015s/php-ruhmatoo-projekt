<?php
	require_once("../../../../configglobal.php");
	$database = "if15_kkkaur";
	
	session_start();

	function createUser($create_email, $password_hash){			
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
		$stmt->bind_param("ss", $create_email, $password_hash);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();		
	}
	

	function loginUser($email, $password_hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);		
		$stmt = $mysqli->prepare("SELECT id, email FROM users WHERE email=? AND password=?");
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
	
	
	
	# MAIN FUNCTION - INSERTING REVIEWS
	function insertreview($bar, $cocktails, $service, $interior, $prices, $score, $info){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO reviews (user_id, bar, cocktails, service, interior, prices, score, info) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("issiiiis", $_SESSION["id_from_db"], $bar, $cocktails, $service, $interior, $prices, $score, $info); 
		$message = "";
		if($stmt->execute()){
			$message = "Ülevaade on edukalt sisestatud andmebaasi. Aitäh!";			
		}else{
			echo $stmt->error;		
			$stmt->close();
		}
		$mysqli->close();
		return $message;
	}
	function getreviews(){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT user_id, bar, cocktails, service, interior, prices, score, info, date FROM reviews ORDER BY score DESC");
		$stmt->bind_result($user_id, $bar, $cocktails, $service, $interior, $prices, $score, $info, $date);
		$stmt->execute();

		$array = array();

		while($stmt->fetch()){

			$review = new StdClass();
			$review->user_id = $user_id;
			$review->date = $date;
			$review->bar = $bar;
			$review->cocktails = $cocktails;
			$review->service = $service;
			$review->interior = $interior;
			$review->prices = $prices;
			$review->score = $score;
			$review->info = $info;
			
			array_push($array, $review);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;				
	}
?>