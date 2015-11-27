<?php

     // Teen errori muutujad
	      //siiselogimine
	$email_error = "";
	$password_error = "";	 
	
	//Teen vaartuse muutujad
	$email = "";
	$password="";
	
	
		if($_SERVER["REQUEST_METHOD"] == "POST") {
    // *********************
    // **** LOGI SISSE *****
    // *********************
		if(isset($_POST["login"])){
			
			echo "Vajutas log in nuppu!";
			
			if ( empty($_POST["email"]) ) {
				$email_error = "E-mail on kohustuslik";
			}else{
				$email = cleanInput($_POST["email"]);
			}
			
			if ( empty($_POST["password"]) ) {
				$password_error = "Parool on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}
      // Kui oleme siia joudnud, voime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				echo "Saab sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
			}
		
		}
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
  	E-mail: <input name="email" type="email" placeholder="E-post"> <?php echo $email_error; ?><br><br>
  	Parool: <input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Log in">
  </form>