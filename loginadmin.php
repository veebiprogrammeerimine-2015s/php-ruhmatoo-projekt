<?php

	//laeme funktsiooni failis
	require_once("function2.php");
	
	//kontrollin, kas kasutaja on sisseloginud
	if(isset($_SESSION["administrator_id_from_db"])){
		// suunan data lehele
		header("Location: data2.php");
	}

     // Teen errori muutujad
	      //siiselogimine
         $administrator_email_error = "";
         $administrator_password_hash_error = "";
	
	//Teen vaartuse muutujad
	     $administrator_email = "";
		 $administrator_password_hash = "";
	
	
		if($_SERVER["REQUEST_METHOD"] == "POST") {
    // *********************
    // **** LOGI SISSE *****
    // *********************
		if(isset($_POST["login"])){
			
			echo "Vajutas log in nuppu!";
			
			if ( empty($_POST["email"]) ) {
				$administrator_email_error = "E-mail on kohustuslik";
			}else{
				$administrator_email = cleanInput($_POST["email"]);
			}
			
			if ( empty($_POST["password"]) ) {
				$administrator_password_hash_error = "Parool on kohustuslik";
			}else{
				$administrator_password_hash = cleanInput($_POST["password"]);
			}
      // Kui oleme siia joudnud, voime kasutaja sisse logida
			if($administrator_email_error == ""  && $administrator_password_hash_error == "" ){
				echo "Saab sisse logida! Kasutajanimi on ".$administrator_email." ja parool on ".$administrator_password_hash;
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
  	E-mail: <input class="input" name="email" type="email" placeholder="E-post" value="<?php echo $administrator_email; ?>"> <?php echo $administrator_email_error; ?><br><br>
  	Parool: <input class="input" name="password" type="password" placeholder="Parool" value="<?php echo $administrator_password_hash; ?>"> <?php echo $administrator_password_hash_error; ?><br><br>
  	<input type="submit" class="button3" name="login" value="Log in">
  </form>
  <br><br><br><br>



  <?php
	require_once("header.php");
?>
<?php require_once("foother.php");?>

  
