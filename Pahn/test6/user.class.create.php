<?php 

class User {
    
	private $connection;
    
    //see fn käivitub kui tekitame uue instantsi
    // new User()
    function __construct($mysqli){
        
		$this->connection = $mysqli;
		
		
    }
    
    function logInUser($email, $hash){
		
		$response = new StdClass();
        
        $stmt = $this->connection->prepare("SELECT id, email FROM users WHERE email=?");
		echo($this->connection->error);
        $stmt->bind_param("s", $email);
        $stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
        if(!$stmt->fetch()){
			
			$error = new StdClass();
			$error->id = 3;
			$error->message = "Tundmatu kasutaja";
			$response->error = $error;
			return $response;
			
		}
		//Paneb eelneva stmt kinni kuna yhe yhendusega ei saa teha mitu fetchi
		$stmt->close();
		
		$stmt = $this->connection->prepare("SELECT id, email FROM users WHERE email=? AND password=?");

        $stmt->bind_param("ss", $email, $hash);
        $stmt->bind_result($id_from_db, $email_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            
            $success = new StdClass();
			$success->message = "Edukalt sisse logitud";
			
			$user = new StdClass();
			$user->id = $id_from_db;
			$user->email = $email_from_db;
			
			$success->user = $user;
			
			$response->success = $success;
            
        }else{
			
			$error = new StdClass();
			$error->id = 2;
			$error->message = "Vale parool";
			$response->error = $error;
			
        }
		
		return $response;
        $stmt->close();
        
    }
	
	function createUser($create_email, $hash){
		
		//vastuse jaoks muutuja error (id, message) success(id)
		$response = new StdClass();
		
        $stmt = $this->connection->prepare("SELECT id FROM users WHERE email=?");
		$stmt->error;
		$stmt->bind_param("s", $create_email);
		$stmt->bind_result($id);
		$stmt->execute();
		if($stmt->fetch()){
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Email on juba kasutusel";
			$response->error = $error;
			
			return $response;
			
		}
		$stmt->close();
        $stmt = $this->connection->prepare("INSERT INTO users (email, password) VALUES (?,?)");
        $stmt->bind_param("ss", $create_email, $hash);
		
        if($stmt->execute()){
			
			$success = new StdClass();
			$success->message = "Kasutaja edukalt loodud";
			
			$response->success = $success;
			
			
		} else {
			echo($stmt->error);
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Hiireke läks katki";
			$response->error = $error;
			
		}
        $stmt->close();
        return $response;
    }
    
} ?>