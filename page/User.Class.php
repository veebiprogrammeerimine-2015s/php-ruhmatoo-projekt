<?php
class User {
	
	private $connection;
	
	function __construct($mysqli){
		
		$this->connection = $mysqli;
		
	}
	function loginUser($email, $hash){
		
		$response = new StdClass();
		
		$stmt = $this->connection->prepare("SELECT id, email FROM users_naaber WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			$success = new StdClass();
			$success->message = "Kasutaja edukalt sisse logitud";
			
			$user = new StdClass();
			$user->id = $id_from_db;
			$user->email = $email_from_db;
			
			$success->user = $user;
			$response->success = $success;
			
			
			header("Location: data.php");
		}else{
			$error = new StdClass();
			$error->id =1;
			$error->message = "Vale parool!";
			
			$response->error = $error;
			
		}
        $stmt->close();
        return $response;
	}
	
	function createUser($create_user_email, $hash){
		$response = new StdClass();
				
		$stmt = $this->connection->prepare("INSERT INTO users_naaber (first_name, last_name, organisation, email, password) VALUES (?,?,?,?,?)");
		$stmt->bind_param ("sssss", $first_name, $last_name, $organisation, $create_user_email, $hash);
		if($stmt->execute()){
			$success = new StdClass();	
			$success->message = "Kasutaja edukalt salvestatud";	
		    $response->success = $success;
		}else{
			$error = new StdClass();
			$error->id =1;
			$error->message = "Midagi läks katki!";
			$response->error = $error;
		};
		
		$stmt->close();
		return $response;
	}

?>