<?php

class Client {
	
	//private- klassi sees
	private $connection;
	
	//klassi loomisel (new User)
	function __construct($mysqli){
		
		//this tähendab selle klassi muutujat, mis on ülal defineeritud (rida5)
		$this->connection = $mysqli;
	
	}
	
	function getPacketData($keyword=""){
		
		$stmt = $this->connection->prepare("SELECT packet_id, arrival, departure, fromc, comment, offices.office FROM post_import join offices on post_import.office_id=offices.office_id WHERE deleted IS NULL AND packet_id LIKE ?");
		echo $this->connection->error;
		$stmt->bind_param("i", $keyword);
		$stmt->bind_result($id, $arrival, $departure, $fromc, $comment, $office_id);
		$stmt->execute();
		$packet_array = array();
		while($stmt->fetch()){
			$packet = new StdClass();
			$packet->id = $id;
			$packet->arrival = $arrival;
			$packet->departure = $departure;
			$packet->fromc = $fromc;
			$packet->comment = $comment;
			$packet->office_id = $office_id;
			array_push($packet_array, $packet);
			return $packet_array;
		}/*else{
			$response = new StdClass();
			$response = "Sellist pakki pole.";
			return $response;
		}*/
		$stmt->close();
		
	}

	/*function checkFor($keyword=""){
		$response = new StdClass();
		$stmt = $this->connection->prepare("SELECT packet_id FROM post_import WHERE packet_id=?");
		echo $this->connection->error;
		$stmt->bind_param("i", $keyword);
		$stmt->bind_result($id);
		$stmt->execute();
		
		//kas sain rea andmeid
		if($stmt->fetch()){
			$response = "normalno";
			return $response;
			$stmt->close();
		}else{
			$response = "hujoova";
			return $response;
		}

		$stmt->close();
	}*/
	/*function
		
		$packet_id_array = array();
		while($stmt->fetch()){
			$packet1 = new StdClass();
			$packet1->id = $id;
			array_push($packet_id_array, $packet1);
		}
		*/

 /* <?=sprintf('%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535));?>  - pane see muutujasse*/
}
?>