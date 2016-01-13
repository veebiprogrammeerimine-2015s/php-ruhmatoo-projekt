<?php
	
	require_once("../config_global.php");
	$database = "if15_mikkmae";
	
	function getEditData($edit_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT post FROM eestijalgpall WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$edit_id);
		$stmt->bind_result($post);
		$stmt->execute();
		
		//object
		$posts = new StdClass();
		
		// kas sain ühe rea andmeid kätte
		//$stmt->fetch() annab ühe rea andmeid
		if($stmt->fetch()){
			//sain
			$posts->post= $post;
			
			
		}else{
			// ei saanud
			// id ei olnud olemas, id=123123123
			// rida on kustutatud, deleted ei ole NULL
			header("Location: eestijalgpall2.php");
		}
		
		return $posts;
		
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	
	
	function updatePosts($id, $post){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE eestijalgpall SET post=? WHERE id=?");
		$stmt->bind_param("si", $post, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tühjaks
			header("Location: eestijalgpall2.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	}
?>