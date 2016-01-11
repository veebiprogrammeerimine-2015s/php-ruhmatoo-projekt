<?php require_once("header.php"); ?>


	<!-- ###################### -->
	<!-- ####### MENUU ######## -->
	<!-- ###################### -->
	
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="http://localhost:5555/~rusljeg/php-ruhmatoo-projekt/tiitelleht.html">Eesti post</a>
    </div>
</nav>
	
<br><br><br>


	



<?php
	require_once("functions.php");
	
	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
	}
	
	$email = "";
	$login_email = "";
	$email_error = "";
	
	$password = "";
	$login_password = "";
	$password_error = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {

		if(isset($_POST["login"])){

			if ( empty($_POST["email"]) ) {
				$email_error = "See väli on kohustuslik";
			}else{

				$email = cleanInput($_POST["email"]);
			}
			if ( empty($_POST["password"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}

			if($password_error == "" && $email_error == ""){

				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
				

				
				if(isset($login_response->success)){
					

					$_SESSION["logged_in_user_id"] = $login_response->user->id;
					$_SESSION["logged_in_user_email"] = $login_response->user->email;

					

					$_SESSION["login_success_message"] = $login_response->success->message;
					
					header("Location: data.php");
					
					
				}
				
				
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
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

  <h2>Log in</h2>
  
  <?php if(isset($login_response->error)): ?>
	<p style="color:red;"> <?=$login_response->error->message;?> </p>
  <?php elseif(isset($login_response->success)): ?>
	<p style="color:green;"> <?=$login_response->success->message;?> </p>
  <?php endif; ?>
  
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
  	<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Log in">
  </form>
  
<?php require_once("footer.php"); ?>