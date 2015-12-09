<?php 
class User {
	
	//private - klassi sees
	private $connection;
	
	//klassi loomisel (new User)
	function __construct($mysqli) {
		
		// this tähendab selle klassi muutujat
		$this->connection = $mysqli;
	}
	
	function createUser($create_username, $create_email, $hash){
		

		$response = new StdClass();
		
		//kas selline email on juba olemas
		$stmt = $this->connection->prepare("SELECT id FROM user_creation WHERE Email=?");
		$stmt->bind_param("s", $create_email);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Sellise e-postiga kasutaja on juba olemas!";
			
			$response->error = $error;
			
			return $response;
			
		}
		
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO user_creation (User, Email, Password, Created) VALUES (?,?,?,NOW())");
		$stmt->bind_param("sss", $create_username, $create_email, $hash);
		
		
		// sai edukalt salvestatud
		if($stmt->execute()){
			
			$success = new StdClass();
			$success->message = "Kasutaja edukalt loodud!";
			
			$response->success = $success;
			
		}else{
			
			// midagi läks katki
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Midagi läks katki!";
			
			$response->error = $error;
			
		}
		
		$stmt->close();
		
		return $response;
	}
	
	function loginUser($user, $hash){
		
		$response = new StdClass();
		
		//kas selline email on juba olemas
		$stmt = $this->connection->prepare("SELECT id FROM user_creation WHERE User=?");
		$stmt->bind_param("s", $user);
		$stmt->bind_result($id);
		$stmt->execute();
		
		// ! -> ei olnud sellist e-posti
		if(!$stmt->fetch()){
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Sellist kasutajat ei ole!";
			
			$response->error = $error;
			return $response;
		}
		
		//*********************
		//***** OLULINE *******
		//*********************
		$stmt->close();
		
		$stmt = $this->connection->prepare("SELECT id, User, Email FROM user_creation WHERE User=? AND Password=?");
		$stmt->bind_param("ss",$user, $hash);
		$stmt->bind_result($id_from_db, $username_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			
			// kõik õige 
			$success = new StdClass();
			$success->message = "Kasutaja edukalt sisselogitud!";
			
			$response->success = $success;
			
			$user = new StdClass();
			$user->id = $id_from_db;
			$user->username = $username_from_db;
			$user->email = $email_from_db;
			
			$response->user = $user;
			
		}else{
			
			// parool vale
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Parool oli vale!";
			
			$response->error = $error;
			
		}
		$stmt->close();
		
		return $response;
	}
	
} ?>