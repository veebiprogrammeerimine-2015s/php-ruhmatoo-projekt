<?php
  require_once("functions.php");
	
	//variables
	$email = "";
	$password = "";
	
	//errors
	$email_error = "";
	$password_error = "";
	
	//login start
	
	if( $_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["login"])){
			if (empty($_POST["email"])) {
				$email_error = "E-posti lahter ei tohi olla tühi!";
			} else {
        // puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);
			}
			if (empty($_POST["password"])) {
				$password_error = "Parooli lahter ei tohi olla tühi!";
			} else {
				$password = cleanInput($_POST["password"]);
			}
      // Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
                $hash = hash("sha512", $password);
                $login_response = $User->loginUser($email, $hash);
            
            }
		}
	}
	
	//login end

if(!isset($_SESSION['logged_in_user_id'])):
?>

<form class="navbar-form navbar-right" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<div class="form-group">
		<input class="form-control input-sm" name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>">
	</div>
	<div class="form-group">
		<input class="form-control input-sm" name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>">
	</div>
	<input type="submit" name="login" value="Logi sisse" class="btn btn-default btn-sm">
	<a href="register.php"><input type="button" name="register" value="Registreeru" class="btn btn-default btn-sm"></a><br>
	<a href="forgot.php">Unustasid parooli?</a>
	<?php if(isset($login_response->error)): ?>

	<p style="color:red;">
	<?=$login_response->error->message;?>
	</p>

	<?php endif; ?>
</form>

<?php 
	else: ?>
		<form class="navbar-form navbar-right">Tere, <?=$_SESSION['logged_in_user_email'];?><br>
		<a class="btn btn-default btn-xs" href="?logout=1">Logi välja</a>
			<a class="btn btn-default btn-xs" href="profile.php">Profiil</a>
		
		</form>
<?php endif; ?>
	
<?php
	if(isset($_GET["logout"])) {
	//kustutame sessiooni muutujad
	session_destroy();
	header("Location: index.php");
	exit();
	}
?>







