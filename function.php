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
	
	
	function createPost($post_tech, $id_from_db){
		// globals on muutuja kõigist php failidest mis on ühendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO post_tech (name, user_id) VALUES (?, ?)");
		$stmt->bind_param("si", $post_tech, $id_from_db);
		
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
	
	function loginPost($login_post_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT post_id FROM post_tech WHERE post_id=?");
		$stmt->bind_param("ss", $login_post_id);
		$stmt->bind_result($post_id_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			
			$_SESSION["post_id_from_db"] = $post_id_from_db;
			
			//suunan kasutaja data.php lehele
			header("Location: comment.php");	
		}
		$stmt->close();
		
		$mysqli->close();
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
		
		$stmt = $mysqli->prepare("INSERT INTO feedback_tech (name) VALUES (?)");
		$stmt->bind_param("s", $feedback_name);
		
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
		
		$stmt = $mysqli->prepare("INSERT INTO comment_tech (comment, user_id, post_id) VALUES (?, ?, ?)");
		$stmt->bind_param("sii", $comment_name, $_SESSION["id_from_db"], $comment_post_id);
		
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

	
	//loome uue funktsiooni, et küsida ab'ist andmeid
	function getPostList(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
<<<<<<< HEAD

		
		$stmt = $mysqli->prepare("SELECT post_id,name,user_id,admin_id FROM post_tech WHERE deleted IS NULL");
		echo $mysqli->error;
		$stmt->bind_result($post_id, $post_name, $post_user_id, $admin_id);

		$stmt = $mysqli->prepare("SELECT post_id, user_id, post_tech.name, user_tech.name, user_tech.email FROM post_tech JOIN user_tech ON post_tech.user_id=user_tech.id");
		echo $mysqli->error;
		$stmt->bind_result($post_id, $user_id, $post_tech_name, $user_tech_name, $user_tech_email);
=======
		$stmt = $mysqli->prepare("SELECT post_id, user_id, post_tech.name, user_tech.name, user_tech.email FROM post_tech JOIN user_tech ON post_tech.user_id=user_tech.id");
		echo $mysqli->error;
		$stmt->bind_result($post_id, $user_id, $post_tech_name, $user_tech_name, $user_tech_email);
>>>>>>> 0328d815aa2df04c1383b893f0b1e1bd21f6f09d
		$stmt->execute();

		// tühi massiiv kus hoiame objekte (1 rida andmeid)
		$array = array();
		while($stmt->fetch()){
			$posts = new StdClass();
			$posts->post_id = $post_id;
			$posts->user_id = $user_id;
			$posts->post_tech_name = $post_tech_name;
			$posts->user_tech_name = $user_tech_name;
			$posts->user_tech_email = $user_tech_email;
			
			
			
<<<<<<< HEAD

			// loon objekti iga while tsükli kord
			$posts = new StdClass();
			$posts->post_id = $post_id;
			$posts->name = $post_name;
			$posts->user_id = $post_user_id;
			$posts->admin_id = $admin_id;

=======
>>>>>>> 0328d815aa2df04c1383b893f0b1e1bd21f6f09d
			
			// lisame selle massiivi
			array_push($array, $posts);
			//echo "<pre>";
			//var_dump($array);
			//echo "</pre>";
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
	}
	
	
	function deletePostList($id_to_be_deleted){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE post_tech SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id_to_be_deleted);
		
		if($stmt->execute()){
			// sai edukalt kustutatud
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
		function getSinglePostData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT post_tech.name, comment, comment_tech.user_id, user_tech.email, user_tech.name FROM comment_tech JOIN user_tech JOIN post_tech ON comment_tech.user_id=user_tech.id AND comment_tech.post_id=post_tech.post_id");
		echo $mysqli->error;
		$stmt->bind_result($post_name, $comment_user, $comment_tech_id, $user_tech_email, $user_tech_name);
		$stmt->execute();

		// tühi massiiv kus hoiame objekte (1 rida andmeid)
		$array = array();
		while($stmt->fetch()){
			$comms = new StdClass();
			$comms->post_name = $post_name;
			$comms->comment_user = $comment_user;
			$comms->comment_tech_id = $comment_tech_id;
			$comms->user_tech_email = $user_tech_email;
			$comms->user_tech_name = $user_tech_name;
			
			
			
			
			// lisame selle massiivi
			array_push($array, $comms);
			//echo "<pre>";
			//var_dump($array);
			//echo "</pre>";
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
	}
	
?>