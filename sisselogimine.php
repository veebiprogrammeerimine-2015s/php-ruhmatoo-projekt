<?php

	//laeme funktsiooni failis
	require_once("function.php");
	
     // Teen errori muutujad
	      //siiselogimine
	$user_email_error = "";
	$user_password_error = "";	 
	
	//Teen vaartuse muutujad
	$user_email = "";
	$user_password="";
	
	//kontrollin, kas kasutaja on sisseloginud
	if(isset($_SESSION["id_from_db"])){
		// suunan data lehele
		header("Location: data.php");
	}
	
		if($_SERVER["REQUEST_METHOD"] == "POST") {
    // *********************
    // **** LOGI SISSE *****
    // *********************
		if(isset($_POST["login"])){
			
			
			if ( empty($_POST["email"]) ) {
				$user_email_error = "E-mail on kohustuslik";
			}else{
				$user_email = cleanInput($_POST["email"]);
			}
			
			if ( empty($_POST["password"]) ) {
				$user_password_error = "Parool on kohustuslik";
			}else{
				$user_password = cleanInput($_POST["password"]);
			}
      // Kui oleme siia joudnud, voime kasutaja sisse logida
			if($user_password_error == "" && $user_email_error == ""){
				echo "Saab sisse logida! Kasutajanimi on ".$user_email." ja parool on ".$user_password;
			// functions php failis käivitan funktsiooni
				loginUser($user_email, $user_password);
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
  	E-mail: <input class="input" name="email" type="email" placeholder="E-post" value="<?php echo $user_email; ?>"> <?php echo $user_email_error; ?><br><br>
  	Parool: <input class="input" name="password" type="password" placeholder="Parool" value="<?php echo $user_password; ?>"> <?php echo $user_password_error; ?><br><br>
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



