<?php 
require_once("../config_global.php");

class userEdit {
	private $connection;
	
	function __construct($connection){
        $this->connection = $connection;
		}
	

	
	function editUser($userfirstname, $userlastname, $useraddress, $userusername){
        
		$response = new StdClass();
		
		$stmt = $this->connection->prepare("UPDATE users SET first_name='?', last_name='?', address='?' WHERE ID='?'" );
		#echo($this->connection->error);
		$stmt->bind_param("ssss", $userfirstname, $userlastname, $useraddress, $userusername);
		$stmt->execute();
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
?>
