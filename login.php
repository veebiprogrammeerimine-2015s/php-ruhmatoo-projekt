<?php
	//load header
	require_once("header.php");
?> 
<!--main code start here --> 

<?php
//laeme funktsiooni failis
	require_once("functions.php");
	
	//*******************//
	//***Kuhu suunata?***//
	//*******************//
	//kontrollin, kas kasutaja on sisseloginud
	/*if(isset($_SESSION["id_from_db"])){
		// kui on,suunan data lehele
		header("Location: data.php");
		exit();
	}*/
	
	// muuutujad errorite jaoks
	$personalcode_error = $password_error = $gender_error = $insurance_error = $name_error = $age_error = $username_error = "";
	// muutujad väärtuste jaoks
	$personalcode = $password = $gender = $insurance = $name = $age = $username = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		// Sisse logimine
		if(isset($_POST["login"])){
			//isikukood
			if(empty($_POST["username"])){
				$username_error = "See väli on kohustuslik";
			}else{
				// puhastame muutuja võimalikest üleliigsetest sümbolitest
				$username = cleanInput($_POST["username"]);
			}
			//parool
			if(empty($_POST["password"])){
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}
			
			// Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $username_error == ""){

				$password_hash = hash("sha512", $password);
				// käivitan funktsiooni
				$login_response = $User->loginUser($username, $password_hash);
				if(isset($login_response->success)){
					//läks edukalt, peab sessiooni salvestama
					$_SESSION["id_from_db"] = $login_response->success->user->id;
					$_SESSION["un_from_db"] = $login_response->success->user->username;
					//***********************************//
					//**suunamine peale sisse logimist?**//
					//***********************************//
					/*header("Location:data.php");
					//lõpetame php laadimise
					exit();*/
				}
			}
		}
	}
  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
?>





	
	<div class="container-fluid">
  		<div class ="row">
  			<div class="col-md-3 col-md-offset-1">
  				<h2>Logi sisse</h2>
				<?php if(isset($login_response->error)):?>
				<p style="color:red;"><?=$login_response->error->message;?></p>
				<?php elseif(isset($login_response->success)):?>
				<p style="color:green;"><?=$login_response->success->message;?></p>
				<?php endif;?>
  
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
					<div class="form-group">
						<input name="username" type="text" placeholder="Kasutajanimi" value="<?php echo $username; ?>"> <font style="color:red"><?php echo $username_error; ?></font><br><br>
					<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <font style="color:red"><?php echo $password_error; ?></font><br><br>
					<input type="submit" name="login" value="Logi sisse">
				</form>
			
				<form>
				  <div class="form-group">
					<label for="exampleInputEmail1">Email address</label>
					<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
				  </div>
				  <div class="form-group">
					<label for="exampleInputPassword1">Password</label>
					<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
				  </div>
				  <div class="form-group">
					<label for="exampleInputFile">File input</label>
					<input type="file" id="exampleInputFile">
					<p class="help-block">Example block-level help text here.</p>
				  </div>
				  <div class="checkbox">
					<label>
					  <input type="checkbox"> Check me out
					</label>
				  </div>
				  <button type="submit" class="btn btn-default">Submit</button>
				</form>
			</div>
	  		
		</div>
	</div>
</body>
</html>

<!--main code end here -->  
<?php
	//load footer
	require_once("footer.php");	
?> 
    