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
		
	function getHistoryData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT game_id, user_id, game_name, park_id, date FROM game_php WHERE user_id = $_SESSION[id_from_db]");
		echo $mysqli->error;
		$stmt->bind_result($id, $user_id, $game_name, $park_id, $date);	
		$stmt->execute();
		$array = array();
		while($stmt->fetch()){
			$game = new StdClass();
			$game->id = $id;
			$game->user_id = $user_id;
			$game->game_name = $game_name;
			$game->park_id = $park_id;
			$game->date = $date;
			
			array_push($array, $game);
			
		}
	
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
	}
function getResultData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT result_id, game_id, basket_nr, result FROM results_php WHERE game_id = $_GET[id]");
		echo $mysqli->error;
		$stmt->bind_result($result_id, $game_id, $basket_nr, $result);	
		$stmt->execute();
		$array = array();
		while($stmt->fetch()){
			$results = new StdClass();
			$results->game_id = $game_id;
			$results->basket_nr = $basket_nr;
			$results->result = $result;
			array_push($array, $results);
			
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
		$stmt->close();
		
	
		
		$mysqli->close();
		
		return $message;
		
		
	}
//Tulemuste salvestamine

		function saveResult($basket_nr, $result){
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			

			$stmt = $mysqli->prepare("INSERT INTO results_php (basket_nr, result, game_id) VALUES (?, ?, ?)");
			$stmt->bind_param("iii", $basket_nr, $result, $_SESSION["game_id"]);
			if($stmt->execute()){
				$message = "Tulemus salvestatud!";
			}else {
				echo $stmt->error;
			}
		$stmt->close();
		
			
		
		$mysqli->close();		
	
		return $message;
	
	}

//Tulemuste kuvamine mängu lõpus

		function getGameData($game_id){
			
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("SELECT results_php.basket_nr, results_php.result, pars_php.par FROM results_php
			JOIN game_php ON game_php.game_id=results_php.game_id
			JOIN parks_php ON parks_php.park_id=game_php.park_id
			JOIN pars_php ON pars_php.park_id=parks_php.park_id
			WHERE game_php.game_id=? AND results_php.basket_nr=pars_php.basket_nr");			
			$stmt->bind_param("i", $game_id);
			echo $stmt->error;
			$stmt->bind_result($basket_nr, $result, $par);
			$stmt->execute();
			
			$array = array();
			
			while($stmt->fetch()){
				
				$game_data = new StdClass();
				$game_data->basket_nr = $basket_nr;
				$game_data->result = $result;
				$game_data->par = $par;
				
				array_push($array, $game_data);
			}
		
			$stmt->close();
			
			$stmt = $mysqli->prepare("SELECT SUM(results_php.result), SUM(pars_php.par), (SUM(results_php.result)-SUM(pars_php.par)) FROM results_php
			JOIN game_php ON game_php.game_id=results_php.game_id
			JOIN parks_php ON parks_php.park_id=game_php.park_id
			JOIN pars_php ON pars_php.park_id=parks_php.park_id
			WHERE game_php.game_id=? AND results_php.basket_nr=pars_php.basket_nr");
			$stmt->bind_param("i", $game_id);
			$stmt->bind_result($sum_results, $sum_pars, $difference);
			$stmt->execute();
			if($stmt->fetch()){
				$_SESSION["sum_results"] = $sum_results;
				$_SESSION["sum_pars"] = $sum_pars;
				$_SESSION["difference"] = $difference;
				
			}
			$stmt->close();
			
			
			$mysqli->close();
			
			return $array;
		}
			
			
?>