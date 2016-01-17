
<?php 
 class User { 
	 
 	//privaatne muutuja, saan kasutada klassi sees 
 	private $connection; 
 	 
    function __construct($mysqli){ 
 		 
 		// selle klassi muutuja 
 		$this->connection = $mysqli; 
	} 
 	 
 	function createUser($create_email, $create_password, $create_name){ 
 		 
 		//teen objekti, et saata tagasi kas errori (id, message) voi successi (message)  
 		$response = new StdClass(); 

 		//kas selline email on juba olemas? 
 		$stmt = $this->connection->prepare("SELECT email FROM user_tech WHERE email = ?"); 
		$stmt->bind_param("s", $create_email); 
 		$stmt->execute(); 
		 
 		//kas oli 1 rida andmeid 
 		if($stmt->fetch()){ 
			 
 			// saadan tagasi errori 
 			$error = new StdClass(); 
 			$error->id = 0; 
 			$error->message = "Sellise e-postiga kasutaja juba olemas!"; 
 			 
 			//panen errori responsile kulge 
 			$response->error = $error; 
 			 
 			// parast returni enam koodi edasi ei vaadata funktsioonis 
 			return $response; 
 			 
 		} 
 	 
 		//************************* 
 		//******* OLULINE ********* 
 		//************************* 
 		//panen eelmise kasu kinni 
 		$stmt->close(); 
 	 
 		$stmt = $this->connection->prepare("INSERT INTO user_tech (email, password, name) VALUES (?, ?, ?)"); 
 		$stmt->bind_param("sss", $create_email, $create_password, $create_name); 
 		 
 		if($stmt->execute()){ 
 			// edukalt salvestas 
 			$success = new StdClass(); 
 			$success->message = "Kasutaja edukalt salvestatud"; 
 			 
 			$response->success = $success; 
 			 
 		}else{ 
 			// midagi laks katki 
 			$error = new StdClass(); 
 			$error->id =1; 
 			$error->message = "Midagi laks katki!"; 
 			 
 			//panen errori responsile kulge 
 			$response->error = $error; 
 		} 
 		 
 		$stmt->close(); 
 		 
 		//saada tagasi vastuse, kas success voi error 
 		return $response; 
 	 
 	} 
 	 
 	function loginUser($email, $password){ 
 		 
    $response = new StdClass(); 
  
		//kas selline email on juba olemas? 
 		$stmt = $this->connection->prepare("SELECT email FROM user_tech WHERE email = ?"); 
 		$stmt->bind_param("s", $email); 
 		$stmt->execute(); 
 		 
 		// ei ole sellist kasutajat - ! 
 		if(!$stmt->fetch()){ 
			 
 			// saadan tagasi errori 
 			$error = new StdClass(); 
 			$error->id = 0; 
 			$error->message = "Sellise e-postiga kasutajat ei ole olemas!"; 
 			 
 			//panen errori responsile kulge 
 			$response->error = $error; 
 			 
 			// parast returni enam koodi edasi ei vaadata funktsioonis 
 			return $response; 
 			 
 		} 
 	 
		$stmt->close(); 
 		 
 		$stmt = $this->connection->prepare("SELECT id, email FROM user_tech WHERE email=? AND password=?"); 
 		$stmt->bind_param("ss", $email, $password); 
 		$stmt->bind_result($id_from_db, $email_from_db); 
 		$stmt->execute(); 
 		if($stmt->fetch()){ 
		// edukalt sai katte 
 			$success = new StdClass(); 
 			$success->message = "Kasutaja edukalt sisse logitud"; 
 			 
			$user = new StdClass(); 
 			$user->id = $id_from_db; 
 			$user->email = $email_from_db; 
 			 
			$success->user = $user; 
 			 
 			$response->success = $success; 
 			 
		}else{ 
 			// midagi laks katki 
 			$error = new StdClass(); 
 			$error->id =1; 
 			$error->message = "Vale parool!"; 
 			 
 			//panen errori responsile kulge 
 			$response->error = $error; 
 		} 
 		 
 		$stmt->close(); 
 		 
 		return $response; 
 	} 
 	 
 } ?> 
