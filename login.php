<?php
		
<<<<<<< .merge_file_EydidF
	// kõik funktsioonid, kus tegeleme AB'iga
=======
	// kÃµik funktsioonid, kus tegeleme AB'iga
>>>>>>> .merge_file_MYWo0w
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
<<<<<<< .merge_file_EydidF
  // muutujad väärtuste jaoks
=======
  // muutujad vÃ¤Ã¤rtuste jaoks
>>>>>>> .merge_file_MYWo0w
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
<<<<<<< .merge_file_EydidF
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
=======
				$email_error = "See vÃ¤li on kohustuslik";
			}else{
			// puhastame muutuja vÃµimalikest Ã¼leliigsetest sÃ¼mbolitest
				$email = cleanInput($_POST["email"]);
			}
			if ( empty($_POST["password"]) ) {
				$password_error = "See vÃ¤li on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}
			// Kui oleme siia jÃµudnud, vÃµime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				echo "VÃµib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
>>>>>>> .merge_file_MYWo0w
			
				$hash = hash("sha512", $password);
				
				// kasutaja sisselogimise fn, failist functions.php
				$login_response = $User->loginUser($email, $hash);
				
<<<<<<< .merge_file_EydidF
				//kasutaja logis edukalt sisse 
				if(isset($login_response->success)){
					
					//id, email
=======
				//kasutaja logis edukalt sisse
				if(isset($login_response->success)){
					
					// id, emaili
>>>>>>> .merge_file_MYWo0w
					$_SESSION["logged_in_user_id"] = $login_response->user->id;
					$_SESSION["logged_in_user_email"] = $login_response->user->email;
					
					//saadan sõnumi teise faili kasutades sessiooni
					$_SESSION["login_success_message"] = $login_response->success->message;
					
					header("Location: data.php");
					
				}
				
				
			}
		} // login if end
		// *********************
		// ** LOO KASUTAJA *****
		// *********************
		if(isset($_POST["create"])){
				if ( empty($_POST["create_email"]) ) {
<<<<<<< .merge_file_EydidF
					$create_email_error = "See väli on kohustuslik";
=======
					$create_email_error = "See vÃ¤li on kohustuslik";
>>>>>>> .merge_file_MYWo0w
				}else{
					$create_email = cleanInput($_POST["create_email"]);
				}
				if ( empty($_POST["create_password"]) ) {
<<<<<<< .merge_file_EydidF
					$create_password_error = "See väli on kohustuslik";
				} else {
					if(strlen($_POST["create_password"]) < 8) {
						$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
=======
					$create_password_error = "See vÃ¤li on kohustuslik";
				} else {
					if(strlen($_POST["create_password"]) < 8) {
						$create_password_error = "Peab olema vÃ¤hemalt 8 tÃ¤hemÃ¤rki pikk!";
>>>>>>> .merge_file_MYWo0w
					}else{
						$create_password = cleanInput($_POST["create_password"]);
					}
				}
				if(	$create_email_error == "" && $create_password_error == ""){
					
<<<<<<< .merge_file_EydidF
					// räsi paroolist, mille salvestame ab'i
					$hash = hash("sha512", $create_password);
					
					echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password." ja räsi on ".$hash;
=======
					// rÃ¤si paroolist, mille salvestame ab'i
					$hash = hash("sha512", $create_password);
					
					echo "VÃµib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password." ja rÃ¤si on ".$hash;
>>>>>>> .merge_file_MYWo0w
					
					// kasutaja loomise fn, failist functions.php,
					// saadame kaasa muutujad
					
					// fn User klassist
					$create_response = $User->createUser($create_email, $hash);
					
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
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

  <h2>Log in</h2>
    <?php if(isset($login_response->error)): ?>
  
	<p style="color:red;">
		<?=$login_response->error->message;?>
	</p>
  
  <?php elseif(isset($login_response->success)): ?>
	
	<p style="color:green;" >
		<?=$login_response->success->message;?>
	</p>
	
  <?php endif; ?>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
  	<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Log in">
  </form>

  <h2>Create user</h2>
  
  <?php if(isset($create_response->error)): ?>
  
	<p style="color:red;">
		<?=$create_response->error->message;?>
	</p>
  
  <?php elseif(isset($create_response->success)): ?>
	
	<p style="color:green;" >
		<?=$create_response->success->message;?>
	</p>
	
  <?php endif; ?>
  
  
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
  	<input type="submit" name="create" value="Create user">
  </form>
<body>
<html>