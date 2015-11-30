<?php 
require_once(__DIR__.'/../functions/functions.php');
	
class userCreate {
    private $connection;
	
	function __construct($connection){
        $this->connection = $connection;
		}

	function createUser($username, $password){

		$response = new StdClass();
		
        $stmt = $this->connection->prepare("SELECT id FROM users WHERE username=?");
		#echo($this->connection->error);
		$stmt->bind_param("s", $username);
		$stmt->bind_result($id);
		$stmt->execute();
		if($stmt->fetch()){
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Kasutajanimi on juba kasutusel";
			$response->error = $error;
			
			return $response;
			
		}
		$stmt->close();
        $stmt = $this->connection->prepare("INSERT INTO users (username, password) VALUES (?,?)");
        $stmt->bind_param("ss", $username, $password);
		
        if($stmt->execute()){
			
			$success = new StdClass();
			$success->message = "Kasutaja edukalt loodud";
			
			$response->success = $success;
			
			
		} else {
			#echo($stmt->error);
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Hiireke läks katki";
			$response->error = $error;
			
		}
        $stmt->close();
		
        return $response;
    }
		
}	
class userLogin {
    private $connection;
	
	function __construct($connection){
        $this->connection = $connection;
		}

	function loginUser($username_to_db, $password_to_db){

		$response = new StdClass();
		
        $stmt = $this->connection->prepare("SELECT id FROM users WHERE username=?");
		echo($this->connection->error);
		$stmt->bind_param("s", $username_to_db);
		$stmt->execute();
		if(!$stmt->fetch()){
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Tundmatu kasutaja!";
			$response->error = $error;
			
			return $response;
			
		}
		$stmt->close();
        $stmt = $this->connection->prepare("SELECT id, username, privileges FROM users WHERE username = ? AND password = ? ");
		echo($this->connection->error);
        $stmt->bind_param("ss", $username_to_db, $password_to_db);
		$stmt->bind_result($id_from_db, $username_from_db, $privileges_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			
			$success = new StdClass();
			$success->message = "Edukalt sisse logitud!!!";
			
			$user = new StdClass();
			$user->id = $id_from_db;
			$user->username = $username_from_db;
			$user->privileges = $privileges_from_db;
			
			$success->user = $user;
			
			$response->success = $success;

			
		} else {
			echo($stmt->error);
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Meie hampstritel jooksev server on ülekoormatud palun oodake.";
			$response->error = $error;
			
		}
        $stmt->close();
        return $response;
    }
		
}	

?>