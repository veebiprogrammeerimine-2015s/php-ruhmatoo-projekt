<?php require_once("header.php"); ?>

<?php
	
 
	require_once("functions.php");
	
	
	if(isset($_SESSION["id_from_db"])){
		header("Location: data.php");
		
		
	}
  
  
  
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";
	$create_password_again_error = "";

  
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	$create_password_again = "";

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
			
				$password_hash = hash("sha512", $password);
				
				loginUser($email, $password_hash);
			
			}

		} 
		
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
			
			if ( empty($_POST["create_password_again"]) ) {
				$create_password_again_error = "See väli on kohustuslik";
			} else {
				if ($_POST["create_password"] != $_POST["create_password_again"] ) {
				$create_password_again_error = "Ei ole sama mis esimene parool!";
				} else {	
					if(strlen($_POST["create_password_again"]) < 8) {
					$create_password_again_error = "Peab olema vähemalt 8 tähemärki pikk!";
					}else{
					$create_password_again = cleanInput($_POST["create_password"]);
					}
				}
				
			}
			
			if(	$create_email_error == "" && $create_password_error == "" && $create_password_again_error == ""){
				echo "Võib kasutajat luua!";
			
				$password_hash = hash("sha512", $create_password);
				echo "<br>";
				
				
				createUser($create_email, $password_hash);
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

<div class="container-fluid">


	<div class="row">
	
		<div class="col-md-3 col-md-offset-1 col-sm-4">
			<h3>Login</h3>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
			  <div class="form-group">
				<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" value="<?php echo $email; ?>"> <?php echo $email_error; ?>
			  </div>
			  <div class="form-group">
				<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" value="<?php echo $password; ?>"> <?php echo $password_error; ?>
			  </div>
			  <button type="submit" class="btn btn-success pull-right hidden-xs">Submit</button>
			  <button type="submit" class="btn btn-success btn-block visible-xs" value="Log in">Submit</button>
			</form>
		</div>
		
		<div class="col-md-3 col-md-offset-1 col-sm-4">
			<h3>Create User</h3>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
			  <div class="form-group">
				<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?>
			  </div>
			  <div class="form-group">
				<input type="password" class="form-control" id="exampleInputEmail1" placeholder="Password"> <?php echo $create_password_error; ?>
			  </div>
			  <div class="form-group">
				<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password Again"> <?php echo $create_password_again_error; ?>
			  </div>
			  <button type="submit" class="btn btn-success pull-right hidden-xs">Submit</button>
			  <button type="submit" class="btn btn-success btn-block visible-xs" value="Create user">Submit</button>
			</form>
		</div>
	
	</div>

	
</div>

<?php require_once("footer.php"); ?>