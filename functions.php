<?php
	
	require_once("../../teamconfig.php");
	

	function getParkData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, park_name, basket_number FROM park_list WHERE DELETED IS NULL");
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
		
			$stmt = $mysqli->prepare("UPDATE park_list SET DELETED=NOW() WHERE id=?");
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
	

		
		
	
	
?>