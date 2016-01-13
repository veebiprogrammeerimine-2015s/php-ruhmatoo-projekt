<?php

require_once("functions.php");

class Worker {
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
	function getPacketData($office, $keyword=""){
		
		$search = "%%";
		
		if($keyword!=""){
			
			$search = "%".$keyword."%";
			
		}
		
		$offices = array("peakontor", "kopli", "kristiine", "lasna", "mustamae", "nomme", "oismae", "pirita");
		
		if (!in_array($office, $offices)) {
			die("Ära üritagi häkkida");
		}
		
		if($office == "peakontor"){
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("SELECT packet_id, arrival, fromc, comment, offices.office FROM post_import right join offices on post_import.office_id=offices.office_id WHERE departure = 00000000000000 AND deleted IS NULL AND (packet_id LIKE ? OR arrival LIKE ? OR fromc LIKE ? OR comment LIKE ? OR offices.office LIKE ?) ORDER BY packet_id");
			echo $mysqli->error;
			$stmt->bind_param("isssi", $search, $search, $search, $search, $search);
			$stmt->bind_result($id, $arrival, $fromc, $comment, $office_id);
			$stmt->execute();
			$packet_array = array();
			while($stmt->fetch()){
				$packet = new StdClass();
				$packet->id = $id;
				$packet->arrival = $arrival;
				$packet->fromc = $fromc;
				$packet->comment = $comment;
				$packet->office_id = $office_id;
				array_push($packet_array, $packet);
				
			}
			$stmt->close();
			return $packet_array;
			
		}else{
			
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("SELECT packet_id, arrival, departure, comment FROM ".$office." WHERE deleted IS NULL AND (packet_id LIKE ? OR arrival LIKE ? OR departure LIKE ? OR comment LIKE ?) ORDER BY packet_id");
			echo $mysqli->error;
			$stmt->bind_param("isss", $search, $search, $search, $search);
			$stmt->bind_result($id, $arrival, $departure, $comment);
			$stmt->execute();
			$packet_array = array();
			while($stmt->fetch()){
				$packet = new StdClass();
				$packet->id = $id;
				$packet->arrival = $arrival;
				$packet->departure = $departure;
				$packet->comment = $comment;
				array_push($packet_array, $packet);
				
			}
			$stmt->close();
			return $packet_array;
			
		}
	}
	
	function addPacket($arrival, $departure, $fromc, $comment, $office_id, $code){
		
		/*echo "hello ".$code;*/
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO post_import (arrival, departure, fromc, comment, office_id, code) VALUES (?,?,?,?,?,?)");
		echo $mysqli->error;
		$stmt->bind_param("iissss", $arrival, $departure, $fromc, $comment, $office_id, $code);
		$stmt->execute();
		echo $mysqli->error;
		$stmt->close();
		
	}
	
	function deletePacket($office, $id){
		
		$offices = array("peakontor", "kopli", "kristiine", "lasna", "mustamae", "nomme", "oismae", "pirita");
		
		if (!in_array($office, $offices)) {
			die("Ära üritagi häkkida");
		}
		
		if($office == "peakontor"){
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("UPDATE post_import SET deleted=NOW() WHERE packet_id=?");
			$stmt->bind_param("i", $id);
			if($stmt->execute()){

				header("Location: dataWorker.php");
				
			}
			$stmt->close();
			
		}else{
			
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			echo $office;
			$stmt = $mysqli->prepare("UPDATE ".$office." SET deleted=NOW() WHERE packet_id=?");
			$stmt->bind_param("i", $id);
			if($stmt->execute()){

				header("Location: dataWorker.php?office=$office");
				
			}
			$stmt->close();
			
		}	
		
	}
	
}

?>