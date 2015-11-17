<?php
class Profile {
	private $connection;
    
    function __construct($mysqli){
        $this->connection = $mysqli;
    }
	
	/*Tööotsija*/
	
	
	/*Tööotsija lõpp*/
	
	/*Tööpakkuja*/
	function createCompany($create_company, $create_email, $create_number){
		$response = new StdClass();
	
		$stmt = $this->connection->prepare("SELECT name FROM job_company WHERE name=?");
		$stmt->bind_param("s", $create_company);
		$stmt->bind_result($name);
		$stmt->execute();
		
		if($stmt->fetch()) {
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Selline ettevõte on juba kasutusel!";
			$response->error = $error;
			
			return $response;
		}

        $stmt = $this->connection->prepare("INSERT INTO job_company (user_id, email, number, name) VALUES (?,?,?,?)");
        $stmt->bind_param("isss", $_SESSION['logged_in_user_id'], $create_email, $create_number, $create_company);
        if($stmt->execute()) {
			$success = new StdClass();
			$success->message = "Ettevõte sisestatud!";
			$response->success = $success;
			
		} else {
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Oh ei! Paistab, et UFO lõhkus midagi ära!";
			$response->error = $error;
		}
        $stmt->close();
        header("Location: profile.php");
		exit();
		return $response;
        
    }
	
	function companyCheck($user) {
		$stmt = $this->connection->prepare("SELECT user_id, email, number, name FROM job_company WHERE user_id = ?");
		$stmt->bind_param("i", $user);
		$stmt->bind_result($userid, $email, $number, $name);
		$stmt->execute();
		$job = new StdClass();
		if($stmt->fetch()) {
			$job->userid = $userid;
			$job->email = $email;
			$job->number = $number;
			$job->name = $name;
		} else {
			$job->userid = $userid;
			$job->email = "";
			$job->number = "";
			$job->name = "";
		}
		return ($job);
		$stmt->close();
	}
		
	
	
	/*Tööpakkuja lõpp*/
}
?>