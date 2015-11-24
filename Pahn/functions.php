<?php
	require_once("../config_global.php");

	session_start();
    $t=time();
	$time=date("Y-m-d",$t);
    function createUser($email, $hash, $First_name, $Last_name, $Address){
		$servername = "d49803.mysql.zone.ee";
		$username = "d49803sa102720";
		$password = "Pa55word";
		$dbname = "d49803sd107026";
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$stmt = $conn->prepare("INSERT INTO proov1 (email, password, first_name, last_name, aadress, created) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssss", $email, $hash, $First_name, $Last_name, $Address, $time);
		$stmt->execute();
		echo "New records created successfully";
		$stmt->close();
		$conn->close();
	}
    
    function logInUser($email, $hash){
		$servername = "d49803.mysql.zone.ee";
		$username = "d49803sa102720";
		$password = "Pa55word";
		$dbname = "d49803sd107026";
		$conn = new mysqli($servername, $username, $password, $dbname);
		$stmt = $conn->prepare("SELECT id, email FROM proov1 WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){	
			$_SESSION['logged_in_user_id'] = $id_from_db;
			$_SESSION['logged_in_user_email'] = $email_from_db;
			header("Location: index.php");
        }else{
			
            echo "Wrong credentials!";
			
        }
        $stmt->close();
        
        $conn->close();
        
    }
    
    
	
	function create_qweet($qweet){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO qweet (user_id, qwert) VALUES (?,?)");

        $stmt->bind_param("ss",$_SESSION['logged_in_user_id'], $qweet);

		$message = "k";
		if($stmt->execute()){
			$message='Edukalt andmebaasi sisestatud!';
		} else {
			$message= $mysqli->error;
		}
		$stmt->error;
		$stmt->close();
        
        $mysqli->close();
        
		return $message;
		
		
	}
	
	function getAllData($keyword=""){
        
        if($keyword == ""){
            //ei otsi
            $search = "%%";
        }else{
            //otsime
            $search = "%".$keyword."%";
        }
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, qwert from qweet WHERE deleted IS NULL AND (qwert LIKE ?)");
		$stmt->bind_param("s", $search);
		$stmt->bind_result($id_from_db, $user_id_from_db, $qwert_from_db);
		$stmt->execute();
		$array = array();
		while($stmt->fetch()){
			
			$tex = new StdClass();
			$tex->id = $id_from_db;
			$tex->user_id = $user_id_from_db;
			$tex->qwert = $qwert_from_db;
			array_push($array, $tex);
			
			}
			
		return $array;
		
	
	}
	

	
 function deleteQweetData($qwert_id, $user_id){
    
    $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
    
    // uuendan välja deleted, lisan praeguse date'i
    $stmt = $mysqli->prepare("UPDATE qweet SET deleted=NOW() WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $qwert_id, $user_id);
    $stmt->execute();
    
    // tühjendame aadressirea
    header("Location: table.php");
    
    $stmt->close();
    $mysqli->close();
}	

function updateQweetData($qwert, $qwert_id, $user_id){
    
    $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
    
    // uuendan välja deleted, lisan praeguse date'i
    $stmt = $mysqli->prepare("UPDATE qweet SET qwert=? WHERE id=? AND user_id=?");
    $stmt->bind_param("sii",$qwert, $qwert_id, $user_id);
    $stmt->execute();
    
    // tühjendame aadressirea
    header("Location: table.php");
    
    $stmt->close();
    $mysqli->close();
}	
 ?>