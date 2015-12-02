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
				$email = $user->cleanInput($_POST["email"]);
			}
			if (empty($_POST["pw"])) {
				$pw_error = "See väli on kohustuslik";
			}else{
				$pw = $user->cleanInput($_POST["pw"]);
			}
			if($pw_error == "" && $email_error == ""){
				$hash = hash("sha512", $pw);
				$user->loginUser($email, $hash);
				echo $user->email;
				
			}
		} // login if end
		// *********************
		// ** LOO KASUTAJA *****
		// *********************
		if(isset($_POST["register"])){
				if (empty($_POST["email_reg"])) {
					$email_reg_error = "See väli on kohustuslik";
				}else{
					$email_reg = $user->cleanInput($_POST["email_reg"]);
				}
				if (empty($_POST["pw_reg"])) {
					$pw_reg_error = "See väli on kohustuslik";
				} else {
					if(strlen($_POST["pw_reg"]) < 8) {
						$pw_reg_error = "Peab olema vähemalt 8 tähemärki pikk!";
					}else{
						$pw_reg = $user->cleanInput($_POST["pw_reg"]);
					}
				}
				if($email_reg_error == "" && $pw_reg_error == ""){
					$hash = hash("sha512", $pw_reg);
					$user->createUser($email_reg, $hash);

					
				}
		} // create if end
	}
  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist

	
	
	
?>
<!-- ################################################################################################################ -->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Videolaenutus</title>

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <!-- ################################################################################################################################ -->
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Videolaenutus</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    
  </div><!-- /.container-fluid -->
</nav>
<!-- ################################################################################################################################ -->
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