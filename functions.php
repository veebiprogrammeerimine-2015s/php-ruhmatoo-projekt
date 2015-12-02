<?php

	require_once("../../config_global.php");
	$database= "if15_mats_3a";
	
	session_start();
	
	function createUser($username, $create_email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("INSERT INTO User (User,Email,Password) VALUES (?,?,?)");
		$stmt->bind_param("sss",$username, $create_email, $hash);
		$stmt->execute();
		$stmt->close();
	   
	$mysqli->close();  
   }
	
   function loginUser ($email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare ("SELECT User FROM User WHERE User=? email=? AND password=?");
		$stmt->bind_param("sss", $username, $email, $hash);
		$stmt->bind_result($username_from_db, $email_from_db);
		$stmt->execute ();
		if($stmt->fetch()){
			echo " Email ja parool õiged, kasutaja id=".$id_from_db.".";
		$_SESSION["logged_in_user_username"]=$username_from_db;
		$_SESSION["logged_in_user_email"]=$email_from_db;
		header("Location: data.php")
		}else{
			echo  "Wrong credentials";
		}
		$stmt->close();
	
		$mysqli->close();
	   
   }
    function createPost($post){
    $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO UserPosts (PostId, Post) VALUES (?,?)");
        
        $stmt->bind_param("is", $_SESSION['logged_in_user_username'], $post);
        
		//sõnum
        $message = "";
        
   
        if($stmt->execute()){
			//kui on tõene, siis INSERT õnnestus
            $message = "Sai edukalt lisatud.";
			
        }else{
			//kui on väär, siis error
			echo $stmt->error;
			
		}
        
		return $message;
		
        $stmt->close();
        $mysqli->close();
    }
	
?>