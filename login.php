<?php
		
	require_once("functions.php");
	

	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: home.php");
	}
	
	
  // muuutujad errorite jaoks
	$username_error = "";
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";
  // muutujad väärtuste jaoks
	$username = "";
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	$create_username = "";

	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		// *********************
		// **** LOGI SISSE *****
		// *********************
		if(isset($_POST["login"])){
			if ( empty($_POST["user"]) ) {
				$username_error = "See väli on kohustuslik";
			}else{
			// puhastame muutuja võimalikest üleliigsetest sümbolitest
				$username = cleanInput($_POST["user"]);
			}
			if ( empty($_POST["password"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}
			// Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $username_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$username." ja parool on ".$password;
			
				$hash = hash("sha512", $password);
				
				// kasutaja sisselogimise fn, failist functions.php
				$login_response = $User->loginUser($username, $hash);
				
				//kasutaja logis edukalt sisse
				if(isset($login_response->success)){
					
					// id, emaili
					$_SESSION["logged_in_user_id"] = $login_response->user->id;
					$_SESSION["logged_in_user_email"] = $login_response->user->email;
					
					//saadan sõnumi teise faili kasutades SESSIOONI
					$_SESSION["login_success_message"] = $login_response->success->message;
					
					header("Location: profile.php");
					
				}
				
				
			}
		} // login if end
		// *********************
		// ** LOO KASUTAJA *****
		// *********************
		if(isset($_POST["create"])){
				if ( empty($_POST["create_username"]) ) {
					$create_username_error = "See väli on kohustuslik";
				}else{
					$create_username = cleanInput($_POST["create_username"]);
				}
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
				if( $create_username_error == "" &&	$create_email_error == "" && $create_password_error == ""){
					
					// räsi paroolist, mille salvestame ab'i
					$hash = hash("sha512", $create_password);
					
					echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password." ja räsi on ".$hash;
					
					// kasutaja loomise fn, failist functions.php,
					// saadame kaasa muutujad
					
					// fn User klassist
					$create_response = $User->createUser($create_username, $create_email, $hash);
					
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
  	<input name="user" type="text" placeholder="Username" value="<?php echo $username; ?>"> <?php echo $username_error; ?><br><br>
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
	<input name="create_username" type="username" placeholder="Username" value="<?php echo $create_username; ?>">
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
  	<input type="submit" name="create" value="Create user">
  </form>
<body>
<html>
