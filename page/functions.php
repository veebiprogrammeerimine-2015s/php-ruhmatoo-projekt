<?php
	require_once("user_class.php");
	require_once("../../config_global.php");
	
	$database = "if15_stenverk";
	
	session_start();
	
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	
	$User = new User($mysqli);
	
	function cleanInput($data) {
  	  $data = trim($data);
  	  $data = stripslashes($data);
  	  $data = htmlspecialchars($data);
  	  return $data;
    }
	
	$message= "";
	$topic_ID = "";
	
	function getAllData(){
          
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("SELECT poll_ID, poll, yes, no FROM polls");
        $stmt->bind_result($poll_ID_from_db, $poll_from_db, $yes_from_db, $no_from_db);
        $stmt->execute();
        // siin on see massiiv kus hoiame me oma küsimusi
        $array = array();
        
        while($stmt->fetch()){
            
            $answering = new StdClass();
            
            $answering->poll_ID = $poll_ID_from_db;
            $answering->poll = $poll_from_db; 
            $answering->yes = $yes_from_db;
            $answering->no = $no_from_db; 
            
            //lisan massiivi
            array_push($array, $answering);
        }
        
        //saadan tagasi
        return $array;
        
        $stmt->close();
        $mysqli->close();
    }
	
		function getCommentData(){
          
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("SELECT comment_ID, comment FROM comment");
        $stmt->bind_result($comment_ID_from_db, $comment_from_db);
        $stmt->execute();
        $array = array();
        

        while($stmt->fetch()){
            $answering = new StdClass();
            
            $answering->comment_ID = $comment_ID_from_db;
            $answering->comment = $comment_from_db; 
            
            array_push($array, $answering);
            
        }

        return $array;
        
        $stmt->close();
        $mysqli->close();
    }
    
    function yesAnswer($poll_ID){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
       
        $stmt = $mysqli->prepare("UPDATE polls SET yes = yes + 1 WHERE polls.poll_ID = ? ;");
        $stmt->bind_param("i", $poll_ID);
        $stmt->execute();
        
        // tühjendab aadressirea
        header("Location: poll.php");
        
        $stmt->close();
        $mysqli->close();
        
		
    }
    
    function noAnswer($poll_ID){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
     
        $stmt = $mysqli->prepare("UPDATE polls SET no = no + 1 WHERE polls.poll_ID = ?;");
        $stmt->bind_param("i", $poll_ID);
        $stmt->execute();
        
        // tühjendab 
        header("Location: poll.php");
        
        $stmt->close();
        $mysqli->close();
        
    }
		function addComment($comment){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO comment (comment) VALUE (?);");
			echo $mysqli->error;
		$stmt->bind_param("s", $comment);
		
		$message= "";
		
		if($stmt->execute()){
			echo $message = "Kommntaar edukalt edastatud :) ";
		}else{
			echo $stmt->error;
			echo "comment= ".$comment;
		}
		$stmt->close();
		
	}
		
		function adminView($topic_poll_ID, $poll){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO polls (topic_poll_ID, poll) VALUES (?,?);");
			echo $mysqli->error;
		$stmt->bind_param("is", $topic_poll_ID, $poll);
		
		$message= "";
		
		if($stmt->execute()){
			echo $message = "Küsimus edukalt lisatud :) ";
		}else{
			echo $stmt->error;
			echo  "topic_id= ".$topic_poll_ID."poll= ".$poll;
		}
		$stmt->close();
		
	}
?>