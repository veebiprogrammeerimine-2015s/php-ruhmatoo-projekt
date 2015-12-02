<?php
		
	// kõik funktsioonid, kus tegeleme AB'iga
	require_once("functions.php");
	
	//kui kasutaja on sisseloginud,
	//siis suuunan data.php lehele
	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
	}
	
	
	
  // muuutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";
  // muutujad väärtuste jaoks
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		// *********************
		// **** LOGI SISSE *****
		// *********************
		if(isset($_POST["login"])){
			if ( empty($_POST["email"]) ) {
				$email_error = "See väli on kohustuslik";
			}else{
			// puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);
			}
			if ( empty($_POST["password"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}
			// Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
			
				$hash = hash("sha512", $password);
				
				// kasutaja sisselogimise fn, failist functions.php
				loginUser($email, $hash);
				
				
			}
		} // login if end
		// *********************
		// ** LOO KASUTAJA *****
		// *********************
		if(isset($_POST["create"])){
				if ( empty($_POST["create_email"]) ) {
					$create_email_error = "See väli on kohustuslik";
				}else{
					$create_email = cleanInput($_POST["create_email"]);
				}
				if ( empty($_POST["create_password"]) ) {
					$create_password_error = "See väli on kohustuslik";
				} else {
					if(strlen($_POST["create_password"]) < 8) {
						$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
					}else{
						$create_password = cleanInput($_POST["create_password"]);
					}
				}
				if(	$create_email_error == "" && $create_password_error == ""){
					
					// räsi paroolist, mille salvestame ab'i
					$hash = hash("sha512", $create_password);
					
					echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password." ja räsi on ".$hash;
					
					// kasutaja loomise fn, failist functions.php,
					// saadame kaasa muutujad
					createUser($create_email, $hash);
					
				}
		} // create if end
	}
  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
	
	
	
?>