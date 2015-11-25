<?php
	//Login
	require_once("page/functions.php");		
	$email_error = "";
	$pw_error = "";
	$email_reg_error = "";
	$pw_reg_error = "";
  // muutujad väärtuste jaoks
	$email = "";
	$pw = "";
	$email_reg = "";
	$pw_reg = "";
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		// *********************
		// **** LOGI SISSE *****
		// *********************
		if(isset($_POST["login"])){
			if (empty($_POST["email"]) ) {
				$email_error = "See väli on kohustuslik";
			}else{
				$email = cleanInput($_POST["email"]);
			}
			if (empty($_POST["pw"])) {
				$pw_error = "See väli on kohustuslik";
			}else{
				$pw = cleanInput($_POST["pw"]);
			}
			if($pw_error == "" && $email_error == ""){
				$hash = hash("sha512", $pw);
				loginUser($email, $hash);
				
				
			}
		} // login if end
		// *********************
		// ** LOO KASUTAJA *****
		// *********************
		if(isset($_POST["register"])){
				if (empty($_POST["email_reg"])) {
					$email_reg_error = "See väli on kohustuslik";
				}else{
					$email_reg = cleanInput($_POST["email_reg"]);
				}
				if (empty($_POST["pw_reg"])) {
					$pw_reg_error = "See väli on kohustuslik";
				} else {
					if(strlen($_POST["pw_reg"]) < 8) {
						$pw_reg_error = "Peab olema vähemalt 8 tähemärki pikk!";
					}else{
						$pw_reg = cleanInput($_POST["pw_reg"]);
					}
				}
				if($email_reg_error == "" && $pw_reg_error == ""){
					$hash = hash("sha512", $pw_reg);
					createUser($email_reg, $hash);

					
				}
		} // create if end
	}
  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist

	
	
	
?>
<?php require_once("page/header.php"); ?>
<div class="container">

		<div class="row">
	
			<div class="col-sm-6">

				<form class="form-horizontal" method="post" action="login.php">
				  <div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
					  <input name="email" type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $email; ?>"><?php echo $email_error; ?>
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10">
					  <input name="pw" type="password" class="form-control" id="pw" placeholder="Password" value="<?php echo $pw; ?>"><?php echo $pw_error; ?>
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <div class="checkbox">
						<label>
						  <input type="checkbox"> Remember me
						</label>
					  </div>
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <button type="submit" class="btn btn-default" name="login">Sign in</button>
					</div>
				  </div>
				</form>
		</div>
		<div class="col-sm-6">

				<form class="form-horizontal" method="post" action="login.php">
				  <div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
					  <input name="email_reg" type="email" class="form-control" id="email_reg" placeholder="Email" value="<?php echo $email_reg; ?>"><?php echo $email_reg_error; ?>
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10">
					  <input name="pw_reg" type="password" class="form-control" id="pw_reg" placeholder="Password" value="<?php echo $pw_reg; ?>"><?php echo $pw_reg_error; ?>
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <button type="submit" class="btn btn-default" name="register">Register</button>
					</div>
				  </div>
				</form>
		</div>
	</div/
</div>







<?php require_once("page/footer.php"); ?>