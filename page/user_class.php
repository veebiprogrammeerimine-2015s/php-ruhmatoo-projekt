<?php 
class User {
	
	//private - klassi sees
	private $connection;
	
	//klassi loomisel (new User)
	function __construct($mysqli) {
		
		// this tähendab selle klassi muutujat
		$this->connection = $mysqli;
	}
	
	function createUser($create_email, $hash){
		
		// teen objekti 
		// seal on error, ->id ja ->message
		// või success ja sellel on ->message
		$response = new StdClass();
		
		//kas selline email on juba olemas
		$stmt = $this->connection->prepare("SELECT user_ID FROM users WHERE email=?");
		$stmt->bind_param("s", $create_email);
		$stmt->bind_result($id);
		$stmt->execute();
		
		// kas sain rea andmeid
		if($stmt->fetch()){
			
			// annan errori, et selline email olemas
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Sellise e-postiga kasutaja on juba olemas!";
			
			$response->error = $error;
			
			// kõik mis on pärast returni enam ei käivitata
			return $response;
			
		}
		
		// panen eelmise päringu kinni
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO users (email, hash) VALUES (?,?)");
		$stmt->bind_param("ss", $create_email, $hash);
		
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
	
	function loginUser($email, $hash){
		
		$response = new StdClass();
		
		//kas selline email on juba olemas
		$stmt = $this->connection->prepare("SELECT user_ID FROM users WHERE email=?");
		$stmt->bind_param("s", $email);
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
		
		$stmt = $this->connection->prepare("SELECT user_ID, email, role FROM users WHERE email=? AND hash=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db, $role);
		$stmt->execute();
		if($stmt->fetch()){
			
			// kõik õige 
			$success = new StdClass();
			$success->message = "Kasutaja edukalt sisselogitud!";
			
			$response->success = $success;
			
			$user = new StdClass();
			$user->user_ID = $id_from_db;
			$user->email = $email_from_db;
			$user->role = $role;
			
			$response->user = $user;
			
		}else{
			
			// parool vale
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Parool oli vale!";
			
			$response->error = $error;
			
		}
		$stmt->close();
		
		if(isset($response->success)){
			$stmt = $this->connection->prepare("INSERT INTO user_log (user_ID, log_in) VALUES (?, NOW())");
			$stmt->bind_param ("i", $response->user->user_ID);
			$stmt->execute();
			$stmt->close();
			
		}
		
		return $response;
	}
	function logoutUser(){
		$stmt = $this->connection->prepare("INSERT INTO user_log (user_ID, log_out) VALUES (?, NOW())");
		$stmt->bind_param ("i", $_SESSION["logged_in_user_id"]);
		$stmt->execute();
		$stmt->close();
		
	}
} 
?>