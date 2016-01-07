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
		
	function test_input($data) {
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
  	E-mail: <input class="input" name="email" type="email" placeholder="E-post"> <?php echo $email_error; ?><br><br>
  	Parool: <input class="input" name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" class="button3" name="login" value="Log in">
  </form>
  <br><br><br><br>

  
<<<<<<< HEAD

  <?php
	require_once("header.php");
?>
<?php require_once("foother.php");?>

  
  <?php 
=======
<?php 
>>>>>>> katariin
		
		if($file_name == "registration.php"){ 
		
			echo "<li>Registreerimine</li>";
		
		}else{
	
			echo '<li><a href="registration.php">Registreerimine</a></li>';
		}
		
<<<<<<< HEAD
?>
=======
?>


<?php require_once("menyy.php"); ?>



>>>>>>> katariin
