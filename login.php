<?php


	// Loon andmebaasi ühenduse
	require_once("functions.php");

	if(isset($_SESSION["logged_in_user_id"])){
		header("Location:data.php");
		
	}


		// LOGIN.PHP
		//echo $_POST["email"];
		//echo $_POST["password"];
		// errori muutujad peavad igal juhul olemas olema
		$email_error = "";
		$password_error= "";	
		$username_error= "";
		$create_email_error= "";
		$create_password_error="";
		
		//muutujad andmebaasi väärtuste jaoks
		$username= "";
		$email= "";
		$password="";
		$create_password="";
		$create_email="";
		
		
		//kontrollime et keegi vajutas input nuppu
		if($_SERVER["REQUEST_METHOD"] == "POST")  {
			//echo "keegi vajutas nuppu";
			
			//vajutas login nuppu
			if(isset($_POST["login"])){	
				
				
				
			
				//kontrollin et e-post ei oleks tühi
				
				if (empty($_POST["email"]) ) {
					$email_error = "See väli on kohustuslik";
				}else{
					$email = cleanInput($_POST["email"]);
					
				}
				
				//kontrollin, et parool ei ole tühi
				if (empty($_POST["password"]) ) {
					$password_error= "Kirjuta parool";
				} else {
					// kui oleme siia jõudnud, siis parool ei ole veel tühi
					// kontrollin
					if(strlen($_POST["password"]) < 8) {
					$password_error= "Peab olema vähemalt 8 tähemärki pikk"; 
					}else{
						
						$password = cleanInput($_POST["password"]);
					}
					
				}
			
				if($email_error== "" && $password_error == "") {
				
	
				
				$hash= hash("sha512", $password);
				loginUser($email, $hash);
				
				}
			
			}
			
			
			
			
			// keegi vajutas create nuppu	
			if(isset($_POST["create"])){
			
				
				
				if (empty($_POST["username"]) ) {
					$username_error = "Kirjuta oma kasutajanimi";
				
					
				}else{
					$username=cleanInput($_POST["username"]);
				}
				
				
		
				
				
				if (empty($_POST["create_email"]) ) {
					$create_email_error = "Kirjuta oma email";
				}else{
					$create_email = cleanInput($_POST["create_email"]);
					
				}
				
				
				if (empty($_POST["create_password"]) ) {
					$create_password_error= "Kirjuta parool";
				} else {
				
					if(strlen($_POST["create_password"]) < 8) {
						$create_password_error= "Peab olema vähemalt 8 tähemärki pikk"; 
					}else{
						
						$create_password = cleanInput($_POST["create_password"]);
					}
					
				}
				
				
			
		
				if ($create_email_error=="" && $create_password_error=="" && $username_error=="" ){
						
						$hash= hash("sha512", $create_password);
						
					
						
						createUser($username, $create_email, $hash);
						
					
				}
				
			}
			
		}
		
	function cleanInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
	}
	
?>