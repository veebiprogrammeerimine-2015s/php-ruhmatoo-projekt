<?php
	
	require_once("../../teamconfig.php");
	
	
	session_start();
	
	function createUser($create_name, $create_email, $password_hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO users_php (name, email, password) VALUES (?, ?, ?)");
		$stmt->bind_param("sss",$create_name, $create_email, $password_hash);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();		
	}
	
	function loginUser($email, $password_hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT user_id, email FROM users_php WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $password_hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			echo "kasutaja id=".$id_from_db;
			
			$_SESSION["id_from_db"] = $id_from_db;
			$_SESSION["user_email"] = $email_from_db;
			
			
		header("Location: main.php");
			
			
		}else{
			echo "Wrong password or email!";
		}
		$stmt->close();
		
		$mysqli->close();
	}

	function getParkData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT park_id, park_name, nr_of_baskets FROM parks_php WHERE DELETED IS NULL");
		echo $mysqli->error;
		$stmt->bind_result($id, $park_name, $basket_number);	
		$stmt->execute();
		$array = array();
		while($stmt->fetch()){
			$park = new StdClass();
			$park->id = $id;
			$park->park_name = $park_name;
			$park->basket_number = $basket_number;
			array_push($array, $park);
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
		
	}
	

//pargi kustutamiseks
		function deletePark($id_to_be_deleted){
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
			$stmt = $mysqli->prepare("UPDATE parks_php SET DELETED=NOW() WHERE park_id=?");
			$stmt->bind_param("i", $id_to_be_deleted);
				if($stmt->execute()){
					header("Location: table.php");
			$message = "Edukalt kustutatud!";
				}else {
			echo $stmt->error;
			}
			$stmt->close();
			$mysqli->close();		
	
			return $message;	
	}
//PARide lisamiseks
		function saveParData($basket, $par, $park_id){
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("INSERT INTO pars_php (park_id, basket_nr, par) VALUES (?,?,?)");
			$stmt->bind_param("iii",$park_id, $basket, $par);
		$stmt->execute();
		echo $stmt->error;
		$stmt->close();
		$mysqli->close();
		} 	
	
//Uue mängu alustamine
	function startNewGame($game_name, $park_id){
			
			$message = "";
		
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("INSERT INTO game_php (user_id, game_name, park_id) VALUES (?, ?, ?)");
			$stmt->bind_param("isi", $_SESSION["id_from_db"], $game_name, $park_id);
			
			if($stmt->execute()){
			$message = "Mäng edukalt loodud!";
			
		}else {
			echo $stmt->error;
		}
		
		$stmt->close();
	
	//Küsin korvide arvu ja tekitan sessiooni muutuja
		$stmt = $mysqli->prepare("SELECT nr_of_baskets, park_name FROM parks_php WHERE park_id=?");
		$stmt->bind_param("i", $park_id);
		$stmt->bind_result($nr_of_baskets, $park_name);
		$stmt->execute();
		if($stmt->fetch()){
			$_SESSION["nr_of_baskets"] = $nr_of_baskets;
			$_SESSION["park_name"] = $park_name;
		}
		
		
		$stmt->close();
	//Küsin mängu id ja tekitan sessiooni muutuja
		$stmt = $mysqli->prepare("SELECT game_id FROM game_php WHERE game_name=? AND park_id=?");
		$stmt->bind_param("si", $game_name, $park_id);
		$stmt->bind_result($game_id);
		$stmt->execute();
		if($stmt->fetch()){
			$_SESSION["game_id"] = $game_id;
		}
	
		$mysqli->close();
		
		return $message;
		
		
	}
//Tulemuste salvestamine

		function saveResult($basket_nr, $result){
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("INSERT INTO results_php (basket_nr, result, game_id, user_id) VALUES (?, ?, ?, ?)");
			$stmt->bind_param("iiii", $basket_nr, $result, $_SESSION["game_id"], $_SESSION["id_from_db"]);
			if($stmt->execute()){
				$message = "Tulemus salvestatud!";
			}else {
				echo $stmt->error;
			}
		$stmt->close();
		$mysqli->close();		
	
		return $message;
	
	}			
?>