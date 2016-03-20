<?php
  if ($page_file == "index.php") {
    require_once("inc/functions.php");
  } else {
    require_once("../inc/functions.php");
  }

	//variables
	$email = "";
	$password = "";
	$checkbox = "";

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

			if (empty($_POST["remember"])) {
				$checkbox = "";
			} else {
				$checkbox = cleanInput($_POST["remember"]);
			}

			if($password_error == "" && $email_error == "" && $checkbox == "on"){
				$hash = hash("sha512", $password);
				$login_response = $User->logInCookie($email, $hash);
            }
			elseif ($password_error == "" && $email_error == ""){
                $hash = hash("sha512", $password);
                $login_response = $User->loginUser($email, $hash);

            }
		}
	}

	//login end

if(!isset($_SESSION['logged_in_user_id'])):
?>
<div class="row">
	<form class="navbar-form navbar-right" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >

	<div class="form-group">
		<input class="form-control input-sm" name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>">
	</div>

	<div class="form-group">
		<input class="form-control input-sm" name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>">
	</div>

	<input type="submit" name="login" value="Logi sisse" class="btn btn-default btn-sm">

	<a href="content/register.php"><input type="button" name="register" value="Registreeru" class="btn btn-default btn-sm"></a><br>

	<div class="col-sm-4 checkbox">
		<label>
		  <input name="remember" type="checkbox"> Mäleta mind
		</label>
	</div>

	<div class="col-sm-4">
		<a href="<?=$myurl; ?>content/forgot.php">Unustasid parooli?</a>
	</div>





</div>



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
			<a class="btn btn-default btn-xs" href="<?=$myurl; ?>content/profile.php">Profiil</a>

		</form>
<?php endif; ?>

<?php
	if(isset($_GET["logout"])) {

  setcookie('authUser');
	//kustutame sessiooni muutujad
	session_destroy();
	header("Location: ".$myurl."index.php");
	exit();
	}
?>
