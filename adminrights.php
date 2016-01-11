<?php
		$id = "";
		$email = "";
		$access_level = "";

		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        
        $response = new StdClass();
        
        $stmt = $mysqli->prepare("SELECT id, email, access_level FROM user_sample WHERE id = ? AND email = ? AND access_level = ?");
        $stmt->bind_param("isi", $id, $email, $access_level);
        $stmt->bind_result($id, $email, $access_level);
        $stmt->execute();
        
        if($access_level == 2){

		
		//mõni funktsioon või element
		
		}else{
		$stmt->close();
        
        $mysqli->close();
		}
?>