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
		
		if(isset($_GET["peakontor"])){
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("SELECT packet_id, arrival, fromc, comment, offices.office FROM post_import join offices on post_import.office_id=offices.office_id WHERE deleted IS NULL AND departure='00000000000000' AND (packet_id LIKE ? OR arrival LIKE ? OR fromc LIKE ? OR comment LIKE ? OR offices.office LIKE ?)");
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
			/*$stmt->close();*/
			return $packet_array;
		}elseif(isset($_GET["kopli"])){
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("SELECT packet_id, arrival, departure, comment FROM kopli WHERE (packet_id LIKE ? OR arrival LIKE ? OR departure LIKE ? OR comment LIKE ?)");
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
			
		}elseif(isset($_GET["kristiine"])){
			
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("SELECT packet_id, arrival, departure, comment FROM kristiine WHERE (packet_id LIKE ? OR arrival LIKE ? OR departure LIKE ? OR comment LIKE ?)");
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
			
		}elseif(isset($_GET["lasna"])){
			
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("SELECT packet_id, arrival, departure, comment FROM lasna WHERE (packet_id LIKE ? OR arrival LIKE ? OR departure LIKE ? OR comment LIKE ?)");
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
			
		}elseif(isset($_GET["mustamae"])){
			
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("SELECT packet_id, arrival, departure, comment FROM mustamae WHERE (packet_id LIKE ? OR arrival LIKE ? OR departure LIKE ? OR comment LIKE ?)");
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
			
		}elseif(isset($_GET["nomme"])){
			
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("SELECT packet_id, arrival, departure, comment FROM nomme WHERE (packet_id LIKE ? OR arrival LIKE ? OR departure LIKE ? OR comment LIKE ?)");
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
			
		}elseif(isset($_GET["oismae"])){
			
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("SELECT packet_id, arrival, departure, comment FROM oismae WHERE (packet_id LIKE ? OR arrival LIKE ? OR departure LIKE ? OR comment LIKE ?)");
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
			
		}elseif(isset($_GET["pirita"])){
			
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("SELECT packet_id, arrival, departure, comment FROM pirita WHERE (packet_id LIKE ? OR arrival LIKE ? OR departure LIKE ? OR comment LIKE ?)");
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
}
?>