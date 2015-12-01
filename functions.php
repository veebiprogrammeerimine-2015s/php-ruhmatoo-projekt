<?php 
	
	require_once("../config_global.php");
	$database = "if15_ruzjaa_3";
	
	session_start();
	
	function createUser($create_email, $hash, $firstname, $lastname){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO post_office (email, password, firstname, lastname) VALUES (?,?,?,?)");
		$stmt->bind_param("ssss", $create_email, $hash, $firstname, $lastname);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();
	}
	
		
	
	
	
	function loginUser($login_email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM post_office WHERE email=? AND password=?");
		echo $mysqli->error;
		$stmt->bind_param("ss", $login_email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			echo "Email ja parool oiged, kasutaja id=".$id_from_db;
			
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
		}else{
			echo "Wrong redentials";
		}
				
		$stmt->close();
		
		$mysqli->close();
	}
?>