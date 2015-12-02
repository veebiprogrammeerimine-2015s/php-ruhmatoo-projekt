<?php class User {
	
	//klassi sees
	private $connection;
	
	
	
	function __construct($mysqli) {
		
		
		//this tähendab selle klassi muutujat
		$this->connection = $mysqli;
		
	}
	function createUser($create_email, $hash, $username, $fullname){
	
		//teen objekti
		//seal on error,  ->id ja ->message või success ja selle on ->message
		$response = new StdClass();
		
		//kas selline email on juba olemas
		$stmt = $this->connection->prepare("SELECT id FROM users WHERE email=? AND username=?");
		$stmt->bind_param("ss", $create_email, $username);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			//annan errori, et selline email olemas
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Sellise epostiga kasutaja on juba olemas!";
			
			$response->error = $error;
			
			return $response;
			
		}
		
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO users VALUES (email, password, username, fullname) VALUES (?, ?, ?, ?)");
				
		// asendame ? märgid, ss - s on string email, s on string password
		$stmt->bind_param("ssss", $create_email, $hash, $username, $fullname);
		if($stmt->execute()) {
			
			$success = new StdClass();
			$success->message = "kasutaja edukalt loodud!";
			$response->success = $success;
			
			
		}else {
			
			//midagi läks katki
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
		
		$stmt = $this->connection->prepare("SELECT id FROM users WHERE email=?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if(!$stmt->fetch()){
			
			//annan errori, et selline email olemas
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Sellise epostiga kasutajat ei ole!";
			
			$response->error = $error;
			
			return $response;
			
		}
		
		$stmt->close();
		
		
		$stmt = $this->connection->prepare("SELECT id, email FROM users WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
				
		//muutujad tulemustele
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
				
			//kontrollin kas tulemusi leiti
			if($stmt->fetch()){
			
				$success = new StdClass();
				$success->message = "Edukalt sisse logitud!";
				$response->success = $success;	
				
				$user = new StdClass();
				$user->id = $id_from_db;
				$user->email = $email_from_db;
				
				$response->user = $user;

					
			}else{
			
				$error = new StdClass();
				$error->id = 1;
				$error->message = "Vale parool!";
			
				$response->error = $error;

				
			}
			
			$stmt->close();
		
			return $response;
			
	}
	
	
	
} ?>