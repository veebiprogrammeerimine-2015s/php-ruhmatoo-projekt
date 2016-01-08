<?php
	//koik AB'iga seonduv
	
	// uhenduse loomiseks kasuta
	require_once("config.php");
	$database = "if15_jekavor";
	
	// paneme sessiooni kaima, saame kasutada $_SESSION muutujaid
	session_start();	
	//function createAdmin($create_administrator_name, $create_administrator_login, $create_administrator_password, $create_administrator_email, $create_administrator_mobile){
		 //globals on muutuja koigist php failidest mis on uhendatud
	//	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
	//	$stmt = $mysqli->prepare("INSERT INTO administrator_tech (administrator_name , administrator_login, administrator_password, administrator_email, administrator_mobile) VALUES ('Jekaterina', 'katariin', md5('katariin12345'), 'katariin@gmail.com', '555-55-55')");
	//	$stmt -> bind_param("sssss", $create_administrator_name, $create_administrator_login, $create_administrator_password, $create_administrator_email, $create_administrator_mobile)
	//	$stmt -> bind_result($create_administrator_name, $create_administrator_login, $create_administrator_password, $create_administrator_email, $create_administrator_mobile)
	//	$stmt->execute();
	//	$stmt->close();
		
	//	$mysqli->close();		
	//}
	
		function loginAdmin($administrator_email, $administrator_password_hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT administrator_id, administrator_email FROM administrator_tech WHERE administrator_email='katariin@gmail.com' AND administrator_password='katariin12345'");
		$stmt->bind_param("ss", $administrator_email, $administrator_password_hash);
		$stmt->bind_result($administrator_id_from_db, $administrator_email_from_db);
		$stmt->execute();
		
		if($stmt->fetch()){
			echo "administrator id=".$administrator_id_from_db;
			
			$_SESSION["administrator_id_from_db"] = $administrator_id_from_db;
			//$_SESSION["administrator_email"] = $administrator_email_from_db;

			
			//suunan kasutaja data.php lehele
			header("Location: data2.php");
			
			
		}else{
			echo "Wrong password or email!";
		}
		$stmt->close();
		
		$mysqli->close();
	}
	
	
	
	
	
		function createPost($post_name, $post_done){
		// globals on muutuja koigist php failidest mis on uhendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO post_tech (post_name, post_done, post_user_id, post_administrator_id) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("iss", $_SESSION["post_id_from_db"], $post_name, $post_done);
		
		$msg = "";
		
		if($stmt->execute()){
			// see on toene siis kui sisestus ab'i onnestus
			$msg = "Edukalt sisestatud andmebaasi";
			
		}else{
			// execute on false, miski laks katki
			echo $stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		return $msg;
		
	}
	
	
	
		function createComment($comment_name){
		// globals on muutuja koigist php failidest mis on uhendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO comment_tech (comment_name, comment_user_id, comment_post_id, comment_administrator_id) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("is", $_SESSION["comment_id_from_db"], $comment_name);
		
		$msg5 = "";
		
		if($stmt->execute()){
			// see on toene siis kui sisestus ab'i onnestus
			$msg5 = "Edukalt sisestatud andmebaasi";
			
		}else{
			// execute on false, miski laks katki
			echo $stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		return $msg5;
		
	}
	
	
	
?>