<?php
	//koik AB'iga seonduv
	
	// uhenduse loomiseks kasuta
	require_once("config.php");
	$database = "if15_vitamak";
	
	// paneme sessiooni kaima, saame kasutada $_SESSION muutujaid
	session_start();
	
	// lisame kasutaja ab'i
	function createUser($create_email, $create_password, $create_name){
		$response = new StdClass();
		// globals on muutuja koigist php failidest mis on uhendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_tech (email, password, name) VALUES (?, ?, ?)");
		$stmt->bind_param("sss", $create_email, $create_password, $create_name);
		$stmt->execute();
			
		$stmt->close();
		$mysqli->close();		
	}
	
	
	//logime sisse
	function loginUser($email, $password){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM user_tech WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $password);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			echo "kasutaja id=".$id_from_db;
			
			$_SESSION["id_from_db"] = $id_from_db;
			$_SESSION["email_from_db"] = $email_from_db;
			
			//suunan kasutaja data.php lehele
			header("Location: post.php");
			
			
		}else{
			echo "Wrong password or email!";
		}
		$stmt->close();
		
		$mysqli->close();
	}
	
	
	function createPost($post_name, $id_from_db){
		// globals on muutuja kõigist php failidest mis on ühendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO post_tech (name, post_user_id) VALUES (?, ?)");
		$stmt->bind_param("si", $post_name, $if_from_db);
	
		$msg = "";
		
		if($stmt->execute()){
			// see on tõene siis kui sisestus ab'i õnnestus
			$msg = "Edukalt sisestatud andmebaasi";
			
		}else{
			// execute on false, miski läks katki
			echo $stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		return $msg;
		
	}
	
	function createProduct($product_name, $product_year, $product_problem){
		// globals on muutuja kõigist php failidest mis on ühendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO product_tech (product_name, product_year, product_problem, product_user_id, product_post_id) VALUES (?, ?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("sisii", $product_name, $product_year, $product_problem, $product_user_id, $product_post_id);
		//$stmt->bind_result($product_name, $product_year, $product_problem, $product_user_id, $product_administrator_id);

		$msg3 = "";
		
		if($stmt->execute()){
			// see on tõene siis kui sisestus ab'i õnnestus
			$msg3 = "Edukalt sisestatud andmebaasi";
			
		}else{
			// execute on false, miski läks katki
			echo $stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		return $msg3;
		
	}
	
	
	function createFeedback($feedback_name){
		// globals on muutuja kõigist php failidest mis on ühendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO feedback_tech (feedback_name, feedback_user_id) VALUES (?, ?)");
		$stmt->bind_param("si", $feedback_name, $feedback_user_id);
		
		$msg4 = "";
		
		if($stmt->execute()){
			// see on tõene siis kui sisestus ab'i õnnestus
			$msg4 = "Edukalt sisestatud andmebaasi";
			
		}else{
			// execute on false, miski läks katki
			echo $stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		return $msg4;
		
	}
	
	
	
	
	function createComment($comment_name){
		// globals on muutuja kõigist php failidest mis on ühendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO comment_tech (comment_name, comment_user_id, comment_post_id, comment_administrator_id) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("siii", $comment_name, $comment_user_id, $comment_post_id, $comment_administrator_id);
		
		$msg5 = "";
		
		if($stmt->execute()){
			// see on tõene siis kui sisestus ab'i õnnestus
			$msg5 = "Edukalt sisestatud andmebaasi";
			
		}else{
			// execute on false, miski läks katki
			echo $stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		return $msg5;
		
	}

?>