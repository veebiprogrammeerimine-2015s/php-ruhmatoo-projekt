<?php
class User{
	//privaatne muutuja
	private $connection;
	//käivitub kui tuleb new User();
	function __construct($mysqli){
		//selle klassi muutuja
		$this->connection = $mysqli;
	}
	function createUser($create_personalcode, $password_hash){
		//objekt et saata tagasi kas errori(id,message) või success(message)
		$response = new StdClass();
		
		$stmt = $this->connection->prepare("SELECT isikukood FROM np3799_abprojekt WHERE isikukood = ?");
		$stmt->bind_param("s", $create_personalcode);
		$stmt->execute();
		if($stmt->fetch()){
			//saadan errori
			$error = new StdClass();
			$error->id = 0;
			$error->message = "sellise isikukoodiga kasutaja on juba olemas";
			//error responsele külge
			$response->error = $error;
			//peale returni koodi ei vaadata enam funktsioonis
			return $response;
		}
		//elmine käsk kinni
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO np3799_abprojekt (isikukood, parool) VALUES (?, ?)");
		$stmt->bind_param("ss", $create_personalcode, $password_hash);
		if($stmt->execute()){
			//salvestas edukalt
			$success = new StdClass();
			$success->message = "Kasutaja loomine õnnestus";
			$response->success = $success;
		}else{
			//kui ei läinud edukalt saadan errori
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Midagi läks katki";
			//error responsele külge
			$response->error = $error;
		}
		$stmt->close();
		return $response;
	}
	function loginUser($personalcode, $password_hash){
		$response = new StdClass();
		$stmt = $this->connection->prepare("SELECT id, isikukood FROM np3799_abprojekt WHERE isikukood=?");
		$stmt->bind_param("s", $personalcode);
		$stmt->execute();
		if(!$stmt->fetch()){
			// saadan tagasi errori
			$error = new StdClass();
			$error->id = 2;
			$error->message = "Sellise isikukoodiga kasutajat ei ole";
			
			//panen errori responsile külge
			$response->error = $error;
			// pärast returni enam koodi edasi ei vaadata funktsioonis
			return $response;
		}
		$stmt->close();
		$stmt = $this->connection->prepare("SELECT id, isikukood FROM np3799_abprojekt WHERE isikukood=? AND parool=?");
		$stmt->bind_param("ss", $personalcode, $password_hash);
		$stmt->bind_result($id_from_db, $pc_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			$success = new StdClass();
			$success->message = "Sisselogimine õnnestus";
			$user = new StdClass();
			$user->id = $id_from_db;
			$user->personalcode = $pc_from_db;
			$success->user = $user;
			$response->success = $success;
		}else{
			$error = new StdClass();
			$error->id = 3;
			$error->message = "Vale parool";
			$response->error = $error;
		}
		$stmt->close();
		return $response;
	}
}?>