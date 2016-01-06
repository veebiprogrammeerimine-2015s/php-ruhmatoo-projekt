<?php
	require_once("../../config_global.php");
	require_once("user.class.php");
	require_once("rate.class.php");


	$database = "if15_rate_my"; #Kui ma peaks teile edasipidi ka midagi sellist saatma siis pane asemele if15_rate_my

	session_start();

	$mysqli = new mysqli($servername, $server_username, $server_password, $database);

	$User = new User($mysqli);
	$Rate = new Rate($mysqli);


	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
  
  function getAllData($keyword=""){
		
		if($keyword == ""){
			$search = "%%";
		}else{
			$search = "%".$keyword."%";
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        // accepted IS NULL - ei ole vastu võetud
        
		$stmt = $mysqli->prepare("SELECT id, pro_id, user_id, inserted, comment, accepted FROM procomment 
		WHERE accepted IS NULL AND (inserted LIKE ? OR comment LIKE ? OR accepted like ?)");
        
		echo $mysqli->error;
		
		$stmt->bind_param("sss", $search, $search, $search);
        $stmt->bind_result($id_from_db, $pro_id_from_db, $user_id_from_db, $inserted_from_db, $comment_from_db, $accepted_from_db);
        $stmt->execute();
	
	
	$array = array();
	
	while($stmt->fetch()){
            //suvaline muutuja, kus hoiame auto andmeid 
            //selle hetkeni kui lisame massiivi
               
            // tühi objekt kus hoiame väärtusi
            $procomments = new StdClass();
            
            $procomments->id = $id_from_db;
            $procomments->pro_id = $pro_id_from_db; 
			$procomments->user_id = $user_id_from_db;
			$procomments->inserted = $inserted_from_db;
            $procomments->comment = $comment_from_db;
			$procomments->accepted = $accepted_from_db;
            
            //lisan massiivi (auto lisan massiivi)
            array_push($array, $procomments);
            //echo "<pre>";
            //var_dump($array);
            //echo "</pre>";
        }
        
        //saadan tagasi
        return $array;
        
        $stmt->close();
        $mysqli->close();
    }
	
	function deleteComment($id){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        // uuendan välja deleted, lisan praeguse date'i
        $stmt = $mysqli->prepare("UPDATE procomment SET DELETED=NOW() WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // tühjendame aadressirea
        header("Location: moderate.php");
        
        $stmt->close();
        $mysqli->close();
	}
	
	function acceptComment($accepted){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("UPDATE procomment SET accepted='NOW()' WHERE id=?");
        $stmt->bind_param("s", $accepted);
        $stmt->execute();
        
        // tühjendame aadressirea
        //header("Location: table.php");
        
        $stmt->close();
        $mysqli->close();
        
    }
	
	?>
