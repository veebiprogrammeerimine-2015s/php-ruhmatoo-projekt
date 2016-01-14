<?php
		
	// kõik funktsioonid, kus tegeleme AB'iga
	require_once("functions.php");
	
	
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
				$login_response = $User->loginUser($email, $hash);
				
				//kasutaja logis edukalt sisse 
				if(isset($login_response->success)){
					
					//id, email
					
					if($login_response->user->role == "admin"){
						$_SESSION["logged_in_user_id"] = $login_response->user->user_ID;
						$_SESSION["logged_in_user_email"] = $login_response->user->email;
						
						$_SESSION["login_success_message"] = $login_response->success->message;
						
						$_SESSION["admin"] = true;
						//if(isset($_SESSION["admin"])){}
						
						header("Location: admin.php");
						
					}else{
						$_SESSION["logged_in_user_id"] = $login_response->user->user_ID;
						$_SESSION["logged_in_user_email"] = $login_response->user->email;
						
						$_SESSION["login_success_message"] = $login_response->success->message;
						
						header("Location: poll.php");
						
					}
					
					
				}
				
				
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
					
					// fn User klassist
					$create_response = $User->createUser($create_email, $hash);
					
				}
		} // create if end
	}
	
	
	
?>
<!DOCTYPE html>
<html>
<head>
  <title>Logi sisse</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
 <div class="login-form">
  <h2>Logi sisse</h2>
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
  	<input type="submit" name="login" value="Logi sisse">
  </form>

  <h2>Loo kasutaja</h2>
  
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
  	<input type="submit" name="create" value="Loo kasutaja">
  </form>
   </div>
<body>
<html>
<?php require_once("footer.php"); ?>
<body>
<html>