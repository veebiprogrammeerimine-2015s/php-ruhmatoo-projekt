<?php

require_once("functions.php");

class Worker {
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
	function getPacketData($keyword=""){
		
		$search = "%%";
		
		if($keyword!=""){
			
			$search = "%".$keyword."%";
			
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT packet_id, arrival, departure, fromc, comment FROM post_import WHERE deleted IS NULL AND (packet_id LIKE ? OR arrival LIKE ? OR departure LIKE ? OR fromc LIKE ? OR comment LIKE ?)");
		$stmt->bind_param("issss", $search, $search, $search, $search, $search);
		$stmt->bind_result($id, $arrival, $departure, $fromc, $comment);
		$stmt->execute();
		$packet_array = array();
		while($stmt->fetch()){
			$packet = new StdClass();
			$packet->id = $id;
			$packet->arrival = $arrival;
			$packet->departure = $departure;
			$packet->fromc = $fromc;
			$packet->comment = $comment;
			array_push($packet_array, $packet);
			
		}
		$stmt->close();
		return $packet_array;
		
	}
}

?>