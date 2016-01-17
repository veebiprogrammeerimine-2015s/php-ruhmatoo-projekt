<?php 
	
	require_once("../config_global.php");
	require_once("user.class.php");
	
	$database = "if15_Martin_Siim";
	
	session_start();
	
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	
	$User = new User($mysqli);
	
	function getThreadData($keyword=""){
               
    $search = "%%";

    if($keyword == ""){

                               
    }else{
    $search = "%".$keyword."%";

	}
						
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
						   
		$stmt = $mysqli->prepare("SELECT teema from PeaTeemad");
		$stmt->bind_param("s", $search);
						   
		$stmt->bind_result($id, $user_id_from_database, $thread );
		$stmt->execute();
						   
		$thread_array = array();
						   
						   
		while($stmt->fetch()){

		$forum = new StdClass();
		$forum->id = $id;
		$forum->thread = $thread;
		$forum->user_id = $user_id_from_database;
		$forum->post = $post;
								   

		array_push($thread_array, $forum);

								   
								   
	}
						   
		return $thread_array;
						   
		$stmt->close();
		$mysqli->close();
						   
	}

?>