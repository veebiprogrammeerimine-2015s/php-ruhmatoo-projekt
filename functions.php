<?php
	
	require_once("../../teamconfig.php");
	require_once("user.class.php");
	
	$database = "if15_jarmhab";
	
	session_start();
	
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	
	$User = new User($mysqli);
	


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
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("INSERT INTO game_php (user_id, game_name, park_id) VALUES (?, ?, ?)");
			$stmt->bind_param("isi", $_SESSION["id_from_db"], $game_name, $park_id);
			
			if($stmt->execute()){
			$message = "Mäng edukalt loodud!";
			
		}else {
			echo $stmt->error;
		}
		
		$stmt->close();
		
		
	}
		
	
	
?>