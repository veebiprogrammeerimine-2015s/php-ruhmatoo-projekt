<?php
class User{
	//privaatne muutuja
	private $connection;
	//käivitub kui tuleb new User();
	function __construct($mysqli){
		//selle klassi muutuja
		$this->connection = $mysqli;
	}
	function createUser($create_personalcode, $password_hash, $create_username, $create_name, $create_age, $create_gender, $create_insurance){
		//objekt et saata tagasi kas errori(id,message) või success(message)
		$response = new StdClass();
		
		$stmt = $this->connection->prepare("SELECT kasutajanimi FROM np3799_abprojekt WHERE kasutajanimi = ?");
		$stmt->bind_param("s", $create_username);
		$stmt->execute();
		if($stmt->fetch()){
			//saadan errori
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Sellise kasutajanimega kasutaja on juba olemas";
			//error responsele külge
			$response->error = $error;
			//peale returni koodi ei vaadata enam funktsioonis
			return $response;
		}
		//elmine käsk kinni
		$stmt->close();
		
		$stmt = $this->connection->prepare("SELECT isikukood FROM np3799_abprojekt WHERE isikukood = ?");
		$stmt->bind_param("i", $create_personalcode);
		$stmt->execute();
		if($stmt->fetch()){
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Sellise isikukoodiga kasutaja on juba olemas";
			$response->error = $error;
			return $response;
		}
		$stmt->close();
		$stmt = $this->connection->prepare("INSERT INTO np3799_abprojekt (isikukood, parool, kasutajanimi, nimi, vanus, sugu, ravikindlustus) VALUES (?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("isssssi", $create_personalcode, $password_hash, $create_username, $create_name, $create_age, $create_gender, $create_insurance);
		if($stmt->execute()){
			//salvestas edukalt
			$success = new StdClass();
			$success->message = "Kasutaja loomine õnnestus";
			$response->success = $success;
		}else{
			//kui ei läinud edukalt saadan errori
			$error = new StdClass();
			$error->id = 2;
			$error->message = "Midagi läks katki";
			//error responsele külge
			$response->error = $error;
		}
		$stmt->close();
		return $response;
	}
	function loginUser($username, $password_hash){
		$response = new StdClass();
		$stmt = $this->connection->prepare("SELECT id, kasutajanimi FROM np3799_abprojekt WHERE kasutajanimi=?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		if(!$stmt->fetch()){
			// saadan tagasi errori
			$error = new StdClass();
			$error->id = 2;
			$error->message = "Sellise kasutajanimega kasutajat ei ole";
			
			//panen errori responsile külge
			$response->error = $error;
			// pärast returni enam koodi edasi ei vaadata funktsioonis
			return $response;
		}
		$stmt->close();
		$stmt = $this->connection->prepare("SELECT id, kasutajanimi FROM np3799_abprojekt WHERE kasutajanimi=? AND parool=?");
		$stmt->bind_param("ss", $username, $password_hash);
		$stmt->bind_result($id_from_db, $un_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			$success = new StdClass();
			$success->message = "Sisselogimine õnnestus";
			$user = new StdClass();
			$user->id = $id_from_db;
			$user->username = $un_from_db;
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