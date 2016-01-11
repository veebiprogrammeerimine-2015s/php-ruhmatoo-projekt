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
		header("Location: dataWorker.php");
	}

	$login_email = "";
	$email_error = "";
	
	$login_password = "";
	$password_error = "";
	
	$firstname = "";
	$lastname = "";
	$firstname_error = "";
	$lastname_error = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(isset($_POST["login"])){ 

			if ( empty($_POST["email1"]) ) {
				$email_error = "See vali on kohustuslik";
			}else{
				$login_email = test_input($_POST["email1"]);
			}
			
			if ( empty($_POST["password1"]) ) {
				$password_error = "See vali on kohustuslik";
			}else{
				
				if(strlen($_POST["password1"]) < 8) { 
				
					$password_error = "Peab olema vahemalt 8 tahemarki pikk!";
					
				}else{
					$login_password = test_input($_POST["password1"]);
				}
				
			}
			
			if($email_error == "" && $password_error ==""){
				
				echo "kontrollin sisselogimist ".$login_email." ja parool ";
			}
		
		
			if($password_error == "" && $email_error == ""){
				echo "Voib sisse logida! Kasutajanimi on ".$login_email." ja parool on ".$login_password;
				
				$hash = hash("sha512", $login_password);
				
				echo $hash;
				
				loginUser($login_email, $hash);
			}
		}
		
		
		
	}
	
	function test_input($data) {
		 $data = trim($data);
		 $data = stripslashes($data);
		 $data = htmlspecialchars($data);
		 return $data;
	}
	
?>
	<h2>Log in</h2>
	
		<form action="login.php" method="post" >
			<input name="email1" type="email" placeholder="Email"> <?php echo $email_error; ?><br><br>
			<input name="password1" type="password" placeholder="Password"> <?php echo $password_error; ?><br><br>
			<input name="login" type="submit" value="Log in">
		</form>
<?php require_once("footer.php"); ?>