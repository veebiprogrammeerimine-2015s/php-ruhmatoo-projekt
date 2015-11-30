<?php
class User {
	
	private $connection;
	
	function __construct($mysqli){
        $this->connection = $mysqli;
    }

	function createUser($email, $hash, $code, $firstname, $lastname, $school){
		$response = new StdClass();
		#Emaili kontroll
		$stmt = $this->connection->prepare("SELECT id FROM users WHERE email=?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if($stmt->fetch()) {
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Selline email on juba kasutusel!";
			$response->error = $error;
			
			return $response;
		}
		#Kontroll kinni
		#Konto sisestamine
        $stmt = $this->connection->prepare("INSERT INTO users (code, email, password, firstname, lastname, school, usergroup, inserted) VALUES (?,?,?,?,?,?,1,NOW())");
        $stmt->bind_param("ssssss", $code, $email, $hash, $firstname, $lastname, $school);
        if($stmt->execute()) {
			$success = new StdClass();
			$success->message = "Kasutaja loodud!";
			$response->success = $success;
		} else {
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Oh ei! Paistab, et UFO lõhkus midagi ära!";
			$response->error = $error;
		}
        $stmt->close();
        
		return $response;
        
    }
	//Konto sisestamine kinni
	
	
	
}

?>