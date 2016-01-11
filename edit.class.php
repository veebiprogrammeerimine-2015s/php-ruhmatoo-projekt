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
		
		/*function updatePacket($packet_id, $arrival, $departure, $fromc, $comment, $office_id){
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("UPDATE post_import SET arrival=?, departure=?, fromc=?, comment=?, ofice_id=?");
			$stmt->bind_param("issssi", $packet_id, $arrival, $departure, $fromc, $comment, $office_id);
			if($stmt->execute()){
				
			}
			$stmt->close();
			
		}*/
		
	}
?>