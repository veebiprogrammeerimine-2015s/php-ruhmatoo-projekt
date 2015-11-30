<?php 
require_once(__DIR__."/../../config_global.php");

class userEdit {
	private $connection;
	
	function __construct($connection){
        $this->connection = $connection;
		}

	function editUser($userfirstname, $userlastname, $useraddress){
		
		$response = new StdClass();
		
		$stmt = $this->connection->prepare("UPDATE users SET first_name=?, last_name=?, address=? WHERE ID=?" );
		#echo($this->connection->error);
		$stmt->bind_param("sssi", $userfirstname, $userlastname, $useraddress, $_SESSION['logged_in_user_id']);
		//$stmt->execute();
		echo($this->connection->error);
		if($stmt->execute()){
			
			$success = new StdClass();
			$success->message = "Andmed uuendatud";
			
			$response->success = $success;
			
			
		} else {
			#echo($stmt->error);
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Hiireke läks katki";
			$response->error = $error;
			
		}
        $stmt->close();

        return $response;
    }
	
}
class userEditAdmin{
		private $connection;
	
	function __construct($connection){
        $this->connection = $connection;
		}

	function readUserAdmin($selectusername){
		$response = new StdClass();
		
	
		$stmt = $this->connection->prepare("SELECT username, first_name, last_name, address, creation_date, privileges FROM users WHERE username=?");
		$stmt->bind_param("s", $selectusername);
		$stmt->bind_result($userusername, $userfirstname, $userlastname, $useraddress, $creationdate, $privileges);
		$stmt->execute();
		if($stmt->fetch()){
			$success = new StdClass();
			
			$success->message = 'Lel';
			
			$user = new StdClass();
			$user->userfirstname = $userfirstname;
			$user->userlastname = $userlastname;
			$user->useraddress = $useraddress;
			$user->creationdate = $creationdate;
			$user->privileges = $privileges;
			$user->username = $userusername;
			
			$response->user = $user;

			return $response;
			
		} else {
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Tundmatu kasutaja!";
			$response->error = $error;
			
			return $response;
			
		}
        $stmt->close();
	}

	function editUserAdmin($userfirstname, $userlastname, $useraddress, $creationdate, $privileges, $selectusername){
		$response = new StdClass();
		echo $userfirstname, $userlastname, $useraddress, $creationdate, $privileges, $selectusername;
	
		$stmt = $this->connection->prepare("UPDATE users SET first_name=?, last_name=?, address=?, creation_date=?, privileges=? WHERE username=?");
		echo($this->connection->error);
		$stmt->bind_param("ssssss", $userfirstname, $userlastname, $useraddress, $creationdate, $privileges, $selectusername);
		//$stmt->execute();
		if($stmt->execute()){
			
			$success = new StdClass();
			$success->message = "Andmed uuendatud";
			
			$response->success = $success;
			
		} else {
			echo($stmt->error);
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Hiireke läks katki";
			
			$response->error = $error;
			
		}
		
		return $response;
        $stmt->close();
		
		
	}

}
?>
