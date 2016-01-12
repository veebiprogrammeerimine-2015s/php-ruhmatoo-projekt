
<?php 
		require_once("../header1.php"); 
		require_once("../functions.php"); 

		if(isset($_SESSION["id_from_db"])){
			header("Location: main.php");
		}

		$email_error = "";
		$password_error = "";
		$create_name_error = "";
		$create_email_error = "";
		$create_password_error = "";

		$email = "";
		$password = "";
		$create_name = "";
		$create_email = "";
		$create_password = "";

		if($_SERVER["REQUEST_METHOD"] == "POST") {
			
			
			
			if(isset($_POST["login"])){
				if (empty($_POST["email"]) ) {
					$email_error = "This field is required!";
				}else{
			
					$email = cleanInput($_POST["email"]);
				}
				
				if ( empty($_POST["password"]) ) {
					$password_error = "This field is required!";
				}else{
					$password = cleanInput($_POST["password"]);
				}
		  
				if($password_error == "" && $email_error == ""){

					echo "<br>";
					echo "User ".$email.". ";

				
					
					$password_hash = hash("sha512", $password);
					
			
					$login_response = $User->loginUser($email, $password_hash);
					if(isset($login_response->success)){
						$_SESSION["id_from_db"] = $login_response->success->user->id;
						$_SESSION["user_email"] = $login_response->success->user->email;
						
						header("Location: main.php");
						exit();
					}
					
					
				}
			} 
		
			 if(isset($_POST["create"])){
				
				if ( empty($_POST["create_name"]) ) {
					$create_name_error = "This field is required!";
				}else{
					$create_name = cleanInput($_POST["create_name"]);
				}				
				
				if ( empty($_POST["create_email"]) ) {
					$create_email_error = "This field is required!";
				}else{
					$create_email = cleanInput($_POST["create_email"]);
				}
				
				if ( empty($_POST["create_password"]) ) {
					$create_password_error = "This field is required!";
				} else {
					if(strlen($_POST["create_password"]) < 8) {
						$create_password_error = "Minimum lenght - 8 characters!";
					}else{
						$create_password = cleanInput($_POST["create_password"]);
					}
				}
				
				if(	$create_name_error == "" && $create_email_error == "" && $create_password_error == ""){
					echo "<br><br><br> Hi, ".$create_name."! Your username is ".$create_email.".";
					
					$password_hash = hash("sha512", $create_password);
					echo "<br>";
					
					$create_response = $User->createUser($create_name, $create_email, $password_hash);
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
<html lang="et">
<head>
<meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="yldine.css">
</head>
<body>

<!-- SISU -->

<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-md-offset-1 col-sm-9">
			<div class="jumbotron">
				<h1>Welcome to </h1>
				<h1>disc golf </h1>
				<h1>page!</h1>
				<p></p>

				
			</div>
		</div>



		
<!-- SISSE LOGIMINE -->		






		<div class="col-md-3 col-md-offset-1 col-sm-4">
			<h3>Log in</h3>
			<form action="login.php" method="post" >
			  <div class="form-group">				
				<input name="email" type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $email; ?>"> <?php echo $email_error; ?>
			  </div>
			  <div class="form-group">
				<input name="password" type="password" class="form-control" id="password" placeholder="Password" value="<?php echo $password; ?>"> <?php echo $password_error; ?>
			  </div>
			  <div class="form-group">
			  <?php if(isset($login_response->error)): ?>
  
				<p style="color:white;">
				<?=$login_response->error->message;?>
				</p>
			
			  
			  <?php elseif(isset($login_response->success)): ?>
  
				<p style="color:white;">
				<?=$login_response->success->message;?>
				</p>
			  <?php endif; ?> 
			  
			  
			  </div>
			  <input name="login" type="submit" value="Log in" class="btn btn-success pull-right hidden-xs">
			  <input name="login" type="submit" value="Log in" class="btn btn-success btn-block visible-xs">
			</form>
			
			<br></br>

		</div>


	<!-- UUS KASUTAJA -->		

  

	
			<div class="col-md-3 col-md-offset-1 col-sm-4">
			<h3>Sign up</h3>
			<form action="login.php" method="post">
			  <div class="form-group">
				
				<input name="create_name" type="name" class="form-control" id="create_name" placeholder="Full Name" value="<?php echo $create_name; ?>"> <?php echo $create_name_error; ?>
			  </div>
			
			
			  <div class="form-group">
				
				<input name="create_email" type="email" class="form-control" id="create_email" placeholder="Email" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?>
			  </div>
			  <div class="form-group">
				
				<input name="create_password" type="password" class="form-control" id="create_password" placeholder="Password" <?php echo $create_password_error; ?>"> <?php echo $create_password_error ?>
			  </div>
			  <div class="form-group">
			  
			  <?php if(isset($create_response->error)): ?>
				<p style="color:white;">
				<?=$create_response->error->message;?>
				</p>
				<?php elseif(isset($create_response->success)): ?>
  
				<p style="color:white;">
				<?=$create_response->success->message;?>
				</p>
				
			  <?php endif; ?>
				
				
				
			  </div>
			  <button name="create" type="submit" value="Sign up" class="btn btn-success pull-right hidden-xs">Sign up</button>
			  <button name="create" type="submit" value="Sign up" class="btn btn-success btn-block visible-xs">Sign up</button>
			</form>
					
		</div>
	
</div>
</body>
</html>

<?php require_once("../footer.php"); ?>