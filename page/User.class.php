<?php
class User {
	
	private $connection;
	
	function __construct($mysqli){
		
		$this->connection = $mysqli;
		
	}
	
	function loginUser($email, $hash){
		
		$response = new StdClass();
		
		$stmt = $this->connection->prepare("SELECT user_id, user_group_ID, first_name, last_name, e_mail FROM users WHERE e_mail=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $group_id_from_db, $first_name_from_db, $last_name_from_db, $email_from_db);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			$success = new StdClass();
			$success->message = "Kasutaja edukalt sisse logitud";
			
			$user = new StdClass();
			$user->id = $id_from_db;
			$user->group_id = $group_id_from_db;
			$user->first_name = $first_name_from_db;
			$user->last_name = $last_name_from_db;
			$user->email = $email_from_db;
			
			$success->user = $user;
			$response->success = $success;
			
		}else{
			
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Vale parool!";
			
			$response->error = $error;
			
		}
		
		$stmt->close();
		
		if(isset($response->success)){
			
			$stmt = $this->connection->prepare("INSERT INTO history (user_ID, log_in) VALUES (?, NOW())");
			$stmt->bind_param ("i", $response->success->user->id);
			$stmt->execute();
			$stmt->close();
			
		}
       
        return $response;
	}
	
	function createUser($user_group, $first_name, $last_name, $create_user_email, $hash, $company_name, $company_description){
		
		$response = new StdClass();

		$stmt = $this->connection->prepare("INSERT INTO users (user_group_ID, first_name, last_name, e_mail, password, company_name, company_description, created) VALUES (?,?,?,?,?,?,?, NOW())");
		$stmt->bind_param ("issssss", $user_group, $first_name, $last_name, $create_user_email, $hash, $company_name, $company_description);
		
		if($stmt->execute()){
			$success = new StdClass();	
			$success->message = "Kasutaja edukalt salvestatud";	
		    $response->success = $success;
		}else{
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Midagi läks katki!";
			$response->error = $error;
		};
		
		$stmt->close();
		return $response;
	}
	
	function logoutUser(){

		$stmt = $this->connection->prepare("INSERT INTO history (user_ID, log_out) VALUES (?, NOW())");
		$stmt->bind_param ("i", $_SESSION["logged_in_user_id"]);
		$stmt->execute();
		$stmt->close();
		
	}
}
?>