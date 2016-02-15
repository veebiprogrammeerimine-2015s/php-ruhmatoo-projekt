<?php
class User {
	private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}

	function createUser($create_name, $create_email, $password_hash){
		
		$response = new StdClass();
		
		$stmt = $this->connection->prepare("SELECT email FROM users_php WHERE email =?");
		$stmt->bind_param("s",$create_email);
		$stmt->execute();		
		
		
		if($stmt->fetch()){
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "This username is already taken!";
			
			$response->error = $error;
			
			return $response;
		}
		
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO users_php (name, email, password) VALUES (?, ?, ?)");
		$stmt->bind_param("sss",$create_name, $create_email, $password_hash);
		
		if($stmt->execute()){
			$success = new StdClass();
			$success->message = "The username has been successfully saved!";
			$response->success = $success;
					
		}else{
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Something went wrong!";
			
			$response->error = $error;			
		}
		
		$stmt->close();
		return $response;
	}
	
	function loginUser($email, $password_hash){
		
		$response = new StdClass();
		
		$stmt = $this->connection->prepare("SELECT email FROM users_php WHERE email=?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		
		if(!$stmt->fetch()){
			$error = new StdClass();
			$error->id = 0;
			$error->message = "User with this email doesn't exist!";
			
			$response->error = $error;
			return $response;	
		}
		
		$stmt->close();
		
		$stmt = $this->connection->prepare("SELECT user_id, email FROM users_php WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $password_hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			$success = new StdClass();
			$success->message = "Success!";
			
			$user = new StdClass();
			$user->id = $id_from_db;
			$user->email = $email_from_db;
			
			$success->user = $user;
			$response->success = $success;
		
		}else{
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Wrong password!";
			
			$response->error = $error;
		}
		$stmt->close();
		return $response;
		
	}
	
}
?>