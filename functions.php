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
	
	/*function getUserData($email, $first_name, $last_name, $GK, $LB, $CB1, $CB2, $RB, $LM, $CM1, $CM2, $RM, $ST1, $ST2, $favteam){
	
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email, first_name, last_name, GK, LB, CB1, CB2, RB, LM, CM1, CM2, RM, ST1, ST2, favteam from users");
		$stmt->bind_param("sssssssssssssss", $email, $first_name, $last_name, $GK, $LB, $CB1, $CB2, $RB, $LM, $CM1, $CM2, $RM, $ST1, $ST2, $favteam);
		$stmt->bind_result($id, $email, $first_name, $last_name, $GK, $LB, $CB1, $CB2, $RB, $LM, $CM1, $CM2, $RM, $ST1, $ST2, $favteam );
		$stmt->execute();
		
		// tühi massiiv, kus hoian moose ja objekte
		$users_array = array();
		//tee midagi seni, kuni saame ab'ist ühe rea andmeid
		while($stmt->fetch()){
			// seda siin sees tehakse 
			// nii mitu korda kui on ridu
				
			// tekitan objekti, kus hakkan hoitma oma moose ja väärtusi
			$users = new StdClass();
			$users->id=$id;
			$users->email= $email;
			$users->first_name=$first_name;
			$users->last_name=$last_name;
			$users->GK=$GK;
			$users->LB=$LB;
			$users->CB1=$CB1;
			$users->CB2=$CB2;
			$users->RB=$RB;
			$users->LM=$LM;
			$users->CM1=$CM1;
			$users->CM2=$CM2;
			$users->RM=$RM;
			$users->ST1=$ST1;
			$users->ST2=$ST2;
			$users->favteam=$favteam;
			
			
			//lisan massiivi
			
			array_push($users_array, $users);
			
			
			
		}
		//tagastan massiivi, kus kõik asjad sees, read.
		return $users_array;
		
		$stmt->close();
		$mysqli->close();
	}
	*/
	
?>
	
	

