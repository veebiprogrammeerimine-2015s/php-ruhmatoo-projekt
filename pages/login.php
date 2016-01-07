<?php
	
	// LOGIN.PHP
	
	// loon andmebaasi ühenduse
	require_once("../functions.php");  
	require_once("../classes/User.class.php");
	
	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
	}
	
	$User = new User($mysqli);
	
	// muutujad errorite jaoks
	$name_error = "";
	$email_error = "";
	$password_error = "";
	$create_password_error = "";
	$create_email_error = "";
	
	//muutujad andmebaasi väärtuste jaoks
	
	$email = "";
	$username = "";
	$fullname ="";
	$create_email="";
	
	//kontrollime, et keegi vajutas input nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// LOGI SISSE
		
		if (isset($_POST["login"])) {
			
			//kontrollin, et e-post ei ole tühi
			if (empty($_POST["email"])) {
				$email_error = "This field is mandatory";
				
			}else{
				$email = test_input($_POST["email"]);
			}
				
			//kontrollin, et parool ei ole tühi
			if (empty($_POST["password"])) {
				$password_error = "This field is mandatory";
			} else {
				$password = test_input($_POST["password"]);				
			}
			
			// võib sisse logida
			
			if($password_error == "" && $email_error == ""){
				
				
				$hash = hash("sha512", $password);
				
				$login_response = $User->loginUser($email, $hash);
				var_dump($login_response);
				//kasutaja logis edukalt sisse
				if(isset($login_response->success)){
					
					$_SESSION["logged_in_user_id"] = $login_response->user->id;
					$_SESSION["logged_in_user_email"] = $login_response->user->email;
					$_SESSION["name"] = $login_response->user->fullname;
					
					//saadan sõnumi teise faili kasutades SESSIOONI
					$_SESSION["login_success_message"] = $login_response->success->message;
					
					header("Location: data.php");
					
				}
				
				
			}
			
		}
		
		// LOO KASUTAJA
		
		elseif (isset($_POST["create"])) //registration field errors
		{
			
			
			if (empty($_POST["username"])) {
				$name_error = "This field is mandatory";	
			} else {
				$username = test_input($_POST["username"]);
			}
			
			
			
			
			if (empty($_POST["fullname"])) {
				$name_error = "This field is mandatory";	
			} else {
				$fullname = test_input($_POST["fullname"]);
			}
			
			
			
			
			
			if (empty($_POST["create_email"])) {
				$create_email_error = "This field is mandatory";
				
			}else{
				
				$create_email = test_input($_POST["create_email"]);
			}
			
			
			
			if (empty($_POST["create_password"])) {
				$create_password_error = "This field is mandatory";
			
				
			}else{
				if(strlen($_POST["create_password"]) <8) {
					
					$create_password_error = "Password needs to be at least 8 characters long ";
				
				}else{
					$create_password = test_input($_POST["create_password"]);
				}
				
			}
			
			if ($name_error == ""){
				echo "saved to database ".$username;
			}
			
			if(	$create_email_error == "" && $create_password_error == "" && $name_error == ""){
				
				$hash = hash("sha512", $create_password);
				echo "User has been created! Registrated e-mail is ".$create_email.", username is ".$username." and password is ".$create_password."and hash is ".$hash;
				$User->createUser($create_email, $hash, $username, $fullname);
				
			}
			
		}
		
	}	
	
	function test_input($data) {
		// võtab ära tühikud, enterid, tabid
		$data = trim($data);
		//tagurpidi kaldkriipsud
		$data = stripslashes($data);
		//teeb html'i tekstiks
		$data = htmlspecialchars($data);
		return $data;
	}
	
		
	
?>
<?php
	$page_title = "Kasutaja leht";
	$page_file_name = "login.php"
?>	

<?php require_once("../header.php"); ?>
	<div class="container">
		<div class="row">
			
			<div class="col-md-3 col-md-push-9">
		

				<FONT FACE="arial">
				
				<h2>Login</h2>
				
				<form action="login.php" method="post">
					<div class="form-group">
					
						<input name="email" class="form-control" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?> 
					</div>
					<div class="form-group">
						<input name="password" class="form-control" type="password" placeholder="Parool"> <?php echo $password_error; ?> 
					</div>
					<div class="form-group">
						<input type="submit" name="login" value="Logi sisse"  class="btn btn-success">
					</div>
				</form>	
					
				<h2>Creat user</h2>
				
				<form action="login.php" method="post">
					<div class="form-group">
						<input name="fullname" class="form-control" type="text" placeholder="Täisnimi" value="<?php echo $fullname; ?>"> <?php echo $name_error; ?> 
					</div>
					<div class="form-group">
						<input name="username" class="form-control" type="name" placeholder="Kasutajanimi" value="<?php echo $username; ?>"> <?php echo $name_error; ?>
					</div>
					<div class="form-group">
						<input name="create_email" class="form-control" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?> 
					</div>
					<div class="form-group">
						<input name="create_password" class="form-control" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> 
					</div>
					<input name="create" type="submit" value="Sisesta" class="btn btn-success">
				</form>	
				
				
				
				</FONT>
				
				
				
			</div>
			
			
			<div class="col-md-9 col-md-pull-3">
				<div class="jumbotron">
					<div class="container ">
					  <h1>Welcome to ListIt</h1>
					  <div class="row">
					  
						<div class="col-sm-6 col-md-4">
							<div class="thumbnail">
							  <img src="http://findicons.com/files/icons/1580/devine_icons_part_2/512/account_and_control_w.png" alt="popcorn">
							  <div class="caption">
								<h3>Create user</h3></br>
								<p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
							  </div>
							</div>
						</div>
						
						<div class="col-sm-6 col-md-4">
							<div class="thumbnail">
							  <img src="http://www.clowns4kids.com/images/popcorn-film-party.png" alt="popcorn">
							  <div class="caption">
								<h3>Add series</h3></br>
								<p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
							  </div>
							</div>
						</div>
					  
						<div class="col-sm-6 col-md-4">
							<div class="thumbnail">
							  <img src="http://www.halliecrawford.com/wp-content/uploads/2015/05/list.png" alt="popcorn">
							  <div class="caption">
								<h3>Make your own lists of series</h3>
								<p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
							  </div>
							</div>
						</div>
						  
						  

						</div>
					</div>
				</div>
			</div>
			
			
			
		</div>
	</div>
</body>

</html>
<?php require_once("../footer.php"); ?>