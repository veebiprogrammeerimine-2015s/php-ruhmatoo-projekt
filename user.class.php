<?php
class User {
    
    private $connection;
    
    function __construct($mysqli){
        $this->connection = $mysqli;
    }

	//Login Funktsioon
	function logInUser($email, $hash){   
		//Emaili ja parooli kontroll
		$response = new StdClass();
	
		$stmt = $this->connection->prepare("SELECT id FROM ntb_users WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if(!$stmt->fetch()) {
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Vale email/parool!";
			$response->error = $error;
			
			return $response;
		}
		$stmt->close();
		//Kontroll kinni
		//Kasutaja sisse logimine
        $stmt = $this->connection->prepare("SELECT id, email, usergroup FROM ntb_users WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $hash);
        $stmt->bind_result($id_from_db, $email_from_db, $usergroup_from_db);
        $stmt->execute();
        if($stmt->fetch()){

			// sessioon salvestatakse serveris
			$_SESSION['logged_in_user_id'] = $id_from_db;
			$_SESSION['logged_in_user_email'] = $email_from_db;
			$_SESSION['logged_in_user_group'] = $usergroup_from_db;
			//Suuname kasutaja teisele lehele
			header("Location: profile.php");
			exit();
			
        }
        $stmt->close();
        
        $mysqli->close();
        
    }
    //Sisse logimine kinni
	
	//Konto loomine	
    function createUser($create_email, $hash){
		//Emaili kontroll
		$response = new StdClass();
	
		$stmt = $this->connection->prepare("SELECT id FROM ntb_users WHERE email=?");
		$stmt->bind_param("s", $create_email);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if($stmt->fetch()) {
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Selline email on juba kasutusel!";
			$response->error = $error;
			
			return $response;
		}
        //Emaili kontroll kinni
		
		//Konto loomine
        $stmt = $this->connection->prepare("INSERT INTO ntb_users (email, password, usergroup, created) VALUES (?,?,1,NOW())");
        $stmt->bind_param("ss", $create_email, $hash);
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
	//Konto loomine kinni
	
	function createEmployer($create_email, $hash){
		//Emaili kontroll
		$response = new StdClass();
	
		$stmt = $this->connection->prepare("SELECT id FROM ntb_users WHERE email=?");
		$stmt->bind_param("s", $create_email);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if($stmt->fetch()) {
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Selline email on juba kasutusel!";
			$response->error = $error;
			
			return $response;
		}
        //Emaili kontroll kinni
		
		//Konto loomine
        $stmt = $this->connection->prepare("INSERT INTO ntb_users (email, password, usergroup, created) VALUES (?,?,2,NOW())");
        $stmt->bind_param("ss", $create_email, $hash);
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
}



?>