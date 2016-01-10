
<?php
	 
	
	//laeme funktsiooni failis
	require_once("function.php");
	
     // Teen errori muutujad
	      //siiselogimine
	$email_error = "";
	$password_error = "";	 
	
	//Teen vaartuse muutujad
	$email = "";
	$password="";
	
	//kontrollin, kas kasutaja on sisseloginud
	if(isset($_SESSION["id_from_db"])){
		// suunan data lehele
		header("Location: sisselogimine.php");
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
				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
				// functions php failis käivitan funktsiooni
				loginUser($email, $password);
			}

		} // login if end
		 
}
		
	  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  return $data;
  }

?>

<html>
<head>
  <title>Login</title>
    <?php if(isset($login_response->error)): ?>
  
	<p style="color:red;">
		<?=$login_response->error->message;?>
	</p>
  
  <?php elseif(isset($login_response->success)): ?>
  
	<p style="color:green;">
		<?=$login_response->success->message;?>
	</p>
  
  <?php endif; ?>
  
  
  
  
  
</head>
<body>

  <h2>Log in</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	E-mail: <input class="input" name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
  	Parool: <input class="input" name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" class="button3" name="login" value="Log in">
  </form>
  <br><br><br><br>


 <?php
	require_once("header.php");
?>

<?php require_once("foother.php");?>

  


<?php
		
 require_once("menyy.php"); 
 
?>



