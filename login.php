
<?php require_once("functions.php"); ?> 



<?php 

	$email = "";
	$password = "";
	
	$email_error = "";
	$password_error = "";
	
if (isset($_SESSION["logged_in_user_id"])){
       header("Location: data.php");
	   
}

 
if($_SERVER["REQUEST_METHOD"] == "POST") {
		// *********************
		// **** LOGI SISSE *****
		// *********************
		if(isset($_POST["login"])){
			if ( empty($_POST["email"]) ) {
				$email_error = "See väli on kohustuslik";
			}else{
			// puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);
			}
			if ( empty($_POST["password"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}
			// Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				//echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
			
				$hash = hash("sha512", $password);
				
				// kasutaja sisselogimise fn, failist functions.php
				loginUser($email, $hash);
				
				
			}
		} 
}

 function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
   function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	

?>

<html>

<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<br><br><br>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Logi sisse</h1>
            <div class="account-wall">
                <img class="profile-img" src="pildid/jalgpall.ico"
                    alt="sveg">
                <form class="form-signin">
                <input type="email" class="form-control" name="email" placeholder="Email"> <?php echo $email_error; ?> <br>
                <input type="password" class="form-control" name="password" placeholder="Parool"> <?php echo $password_error; ?> <br>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Logi sisse</button>
                <label class="checkbox pull-left">
                    <input type="checkbox" value="remember-me">
                    Jäta mind meelde
                </label>
                
                </form>
            </div>
            <a href="register.php" class="text-center new-account">Loo kasutaja </a>
        </div>
    </div>
</div>

  </body>
  </html>
  


