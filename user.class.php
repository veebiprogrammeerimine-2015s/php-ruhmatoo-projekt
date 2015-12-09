<?php 
class User {
	//private - klassi sees
	private $connection;
	
	//klassi loomisel (new User)
	function __construct($mysqli) {
		
		// this tähendab selle klassi muutujat
		$this->connection = $mysqli;
	}
	  function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }
	  function loginUser($email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM VL_Login WHERE email=? AND hash=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){		  
		  $_SESSION["logged_in_user_id"] = $id_from_db;
		  $_SESSION["logged_in_user_email"] = $email_from_db;
		  $user = new StdClass();
		  $user->email = $email_from_db;		  
		  header("Location: main.php");
		}
		else{
		  echo "Valed andmed";
		}
	  }
	  function createUser($email_reg, $hash){
		//echo $email_reg;
		//echo $hash;
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO VL_Login (email, hash) VALUES (?,?)");
		$stmt->bind_param("ss", $email_reg, $hash);
		$stmt->execute();
		$stmt->close();

		}
		function getCategory($url){
			if (strpos($url,'Action') == true) {
				$category = "action";
				echo "action";
			}
		}
<<<<<<< HEAD
		else
		
		}
=======

>>>>>>> 17a97093ed08b5cfca0de66cffe2124326af9923
}
?>