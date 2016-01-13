<?php
	require_once("functions.php");
	
	class Edit {
	
		//private- klassi sees
		private $connection;
		
		//klassi loomisel (new User)
		function __construct($mysqli){
			
			$this->connection = $mysqli;
		
		}
	
		function getPacketData($id){
			
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("SELECT arrival, departure, fromc, comment, office_id FROM post_import WHERE deleted IS NULL AND packet_id = ?");
			$stmt->bind_param("i", $id);
			$stmt->bind_result($arrival, $departure, $fromc, $comment, $office_id);
			$stmt->execute();
			$packet_array = array();
			while($stmt->fetch()){
				$packet = new StdClass();
				$packet->arrival = $arrival;
				$packet->departure = $departure;
				$packet->fromc = $fromc;
				$packet->comment = $comment;
				$packet->office_id = $office_id;
				array_push($packet_array, $packet);
			}
			$stmt->close();
			return $packet_array;
			
		}
		
		function updatePacket($office, $arrival, $departure, $fromc, $comment, $office_id, $packet_id){
			
			$offices = array("peakontor", "kopli", "kristiine", "lasna", "mustamae", "nomme", "oismae", "pirita");
		
			if (!in_array($office, $offices)) {
				die("Ära üritagi häkkida");
			}
			
			if($office == "peakontor"){
				
				$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
				$stmt = $mysqli->prepare("UPDATE post_import SET arrival=?, departure=?, fromc=?, comment=?, office_id=? WHERE packet_id = ? AND deleted IS NULL");
				$stmt->bind_param("iissii", $arrival, $departure, $fromc, $comment, $office_id, $packet_id);
				$stmt->execute();
				$stmt->close();
			
			}else{
				
				$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
				$stmt = $mysqli->prepare("UPDATE ".$office." SET arrival=?, departure=?, comment=? WHERE packet_id = ? AND deleted IS NULL");
				$stmt->bind_param("iisi", $arrival, $departure, $comment, $packet_id);
				$stmt->execute();
				$stmt->close();
				
			}
			
		}
		
	}
?>