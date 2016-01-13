<?php 
	
	require_once("../config_global.php");
	$database = "if15_mikkmae";
	
	
	
	//tekitatakse sessioon, mida hoitakse serveris,
	// kõik session muutujad on kättesaadavad kuni viimase brauseriakna sulgemiseni
	session_start();
	
	
	// võtab andmed ja sisestab ab'i
	// võtame vastu 2 muutujat
	function createUser($create_email, $hash, $firstname, $lastname ){
		
		// Global muutujad, et kätte saada config failist andmed
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO users (email, password, first_name, last_name) VALUES (?,?,?,?)");
		$stmt->bind_param("ssss", $create_email, $hash, $firstname, $lastname);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();
		
	}
	
	function loginUser($email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);		
		
		$stmt = $mysqli->prepare("SELECT id, email FROM users WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			// ab'i oli midagi
			echo "Email ja parool õiged, kasutaja id=".$id_from_db;
			
			// tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			//suunan data.php lehele
			header("Location: data.php");
			
		}else{
			// ei leidnud
			echo "Wrong e-mail or password!";
		}
		$stmt->close();
		
		$mysqli->close();
	}
			function addPost($arvamus ){
		
		// Global muutujad, et kätte saada config failist andmed
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO eestijalgpall (user_id, user_email, post) VALUES (?,?,?)");
		$stmt->bind_param("iis", $_SESSION["logged_in_user_id"], $_SESSION["logged_in_user_email"], $arvamus);
		if($stmt->execute()){
			// kui on tõene,
			//siis INSERT õnnestus
			$message = "*Sai edukalt lisatud*";
			 
			
		}else{
			// kui on väärtus FALSE
			// siis kuvame errori
			echo $stmt->error;
			
		}
		
		return $message;
		
		
		$stmt->close();
		
			$mysqli->close(); }
		
			function getPostData() {
				
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, user_email, timestamp, post from eestijalgpall WHERE deleted IS NULL");
		//$stmt->bind_param("ssss", $search, $search, $search, $search);
		$stmt->bind_result($id, $user_id_from_database, $user_email_from_database, $timestamp, $post);
		$stmt->execute();
		
		
		// tühi massiiv, kus hoian moose ja 
		$posts_array = array();
		//tee midagi seni, kuni saame ab'ist ühe rea andmeid
		while($stmt->fetch()){
			// seda siin sees tehakse 
			// nii mitu korda kui on ridu
				
			// tekitan objekti, kus hakkan hoitma oma moose ja väärtusi
			$posts = new StdClass();
			$posts->id=$id;
			$posts->user_id=$user_id_from_database;
			$posts->user_email= $user_email_from_database;
			$posts->timestamp=$timestamp;
			$posts->post=$post;
			
			//lisan massiivi
			
			array_push($posts_array, $posts);
			
			
			
		}
		//tagastan massiivi, kus kõik asjad sees, read.
		return $posts_array;
		
		$stmt->close();
		$mysqli->close();
	}	
				
				
		function deletePosts($id) {
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE eestijalgpall SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		if($stmt->execute()) {
			// sai kustutatud
			// kustutame adressirea tühjaks
			header("Location: eestijalgpall.php");
			
			
		}
		$stmt->close();
		$mysqli->close();
		
	}	
		
	
	
?>
	
	

