<?php 
class User {
	
	private $connection;
	
	function __construct($mysqli) {
		
		$this->connection = $mysqli;
	}
	
	function createUser($create_email, $hash){
		

		$response = new StdClass();
		
		$stmt = $this->connection->prepare("SELECT id FROM user_creation WHERE Email=?");
		$stmt->bind_param("s", $create_email);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "E-mail already taken!";
			
			$response->error = $error;
			
			return $response;
			
		}
		
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO user_creation (Email, Password) VALUES (?,?)");
		$stmt->bind_param("ss", $create_email, $hash);
		
		if($stmt->execute()){
			
			$success = new StdClass();
			$success->message = "Account created!";
			
			$response->success = $success;
			
		}else{
			
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Something got messed up!";
			
			$response->error = $error;
			
		}
		
		$stmt->close();
		
		return $response;
	}
	
	function loginUser($email, $hash){
		
		$response = new StdClass();
		
		$stmt = $this->connection->prepare("SELECT id FROM user_creation WHERE Email=?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if(!$stmt->fetch()){
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Such an account doesn't exist!";
			
			$response->error = $error;
			return $response;
		}
		
		//***********************
		//****** ESSENTIAL ******
		//***********************
		$stmt->close();
		
		$stmt = $this->connection->prepare("SELECT id, Email FROM user_creation WHERE Email=? AND Password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){

			$success = new StdClass();
			$success->message = "Successfully logged in!";
			
			$response->success = $success;
			
			$user = new StdClass();
			$user->id = $id_from_db;
			$user->Email = $email_from_db;
			
			$response->user = $user;
			
		}else{
			
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Wrong password!";
			
			$response->error = $error;
			
		}
		$stmt->close();
		
		return $response;
	}
	
} ?>