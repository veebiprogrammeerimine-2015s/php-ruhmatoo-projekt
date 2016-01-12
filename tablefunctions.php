<?php

require_once("../config_global.php");
	$database= "if15_mats_3a";
	
	function getPostsData($keyword=""){
		
		$search = "%%";
		
		if($keyword == ""){
			echo"Ei otsi";
			
		}else{
			echo "Otsin ".$keyword;
			$search= "%".$keyword."%";
		}

		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt= $mysqli->prepare("SELECT Post, PostId, User from UserPost WHERE deleted IS NULL AND (post LIKE ?)");
		$stmt->bind_param("s",$search);
		
		$stmt->bind_result($id, $user_id_from_database, $post);
		$stmt->execute();
		
		$posts_array = array();
		while($stmt->fetch()){
			
			$posts = new StdClass();
			$posts->id= $id;
			$posts->post = $post;
			$posts->user_id= $user_id_from_database;
			
			
			array_push($posts_array, $posts);
			
		}
		
		
		return $posts_array;
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function deletePosts($id){
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("UPDATE UserPost SET deleted=NOW() WHERE PostId=? AND User=?");
	$stmt->bind_param("ii", $id, $_SESSION["logged_in_user_id"]);
	if($stmt->execute()){
		
		header("Location: poststable.php");
		
	}
	$stmt->close();
	$mysqli->close();
	
	
	
	}
	
	function updatePosts ($id, $post){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE UserPost SET Post=?  WHERE PostId=? AND User=?");
        $stmt->bind_param("sii", $post, $posts_id, $_SESSION["logged_in_user_id"]);
        if($stmt->execute()){
			
		
        
       
        header("Location: poststable.php");
        }
        $stmt->close();
        $mysqli->close();
		
		
	}
	
?>	