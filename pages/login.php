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
				$email_error = "See väli on kohustuslik";
				
			}else{
				$email = test_input($_POST["email"]);
			}
				
			//kontrollin, et parool ei ole tühi
			if (empty($_POST["password"])) {
				$password_error = "See väli on kohustuslik";
			} else {
				$password = test_input($_POST["password"]);				
			}
			
			// võib sisse logida
			
			if($password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
				
				$hash = hash("sha512", $password);
				
				$login_response = $User->loginUser($email, $hash);
				//var_dump($login_response);
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
				$name_error = "See väli on kohustuslik";	
			} else {
				$username = test_input($_POST["username"]);
			}
			
			
			
			
			if (empty($_POST["fullname"])) {
				$name_error = "See väli on kohustuslik";	
			} else {
				$fullname = test_input($_POST["fullname"]);
			}
			
			
			
			
			
			if (empty($_POST["create_email"])) {
				$create_email_error = "See väli on kohustuslik";
				
			}else{
				
				$create_email = test_input($_POST["create_email"]);
			}
			
			
			
			if (empty($_POST["create_password"])) {
				$create_password_error = "See väli on kohustuslik";
			
				
			}else{
				if(strlen($_POST["create_password"]) <8) {
					
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk";
				
				}else{
					$create_password = test_input($_POST["create_password"]);
				}
				
			}
			
			if ($name_error == ""){
				echo "salvestasin andmebaasi ".$username;
			}
			
			if(	$create_email_error == "" && $create_password_error == "" && $name_error == ""){
				
				$hash = hash("sha512", $create_password);
				echo "Kasutaja on loodud! Registreeritud e-mail on ".$create_email.", kasutajanimi on ".$username." ja parool on ".$create_password."ja räsi on ".$hash;
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
				
				<h2>Logi sisse</h2>
				
				<form action="login.php" method="post">
				
				
					<?php if(isset($login_response->error)):?>
  
						<div class="alert alert-danger" role="alert"><?=$login_response->error->message;?></div>
						
					  <?php elseif(isset($login_response->success)):?>
					  
						<div class="alert alert-success" role="alert"><?=$login_response->success->message;?></div>
					  
					  <?php endif; ?>
				
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
					
				<h2>Loo kasutaja</h2>
				
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
					  <p>Connect with your friends — and other fascinating people. Get in-the-moment updates on the things that interest you. And watch events unfold, in real time, from every angle.</p>
					  
					</div>
				</div>
			
			</div>
			
			
		</div>
	</div>
</body>

</html>
<?php require_once("../footer.php"); ?>