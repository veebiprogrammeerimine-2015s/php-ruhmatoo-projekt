<?php
	require_once ("header.php");
	require_once ("functions.php");
	
	//kontrollin, kas kasutaja on sisseloginud
	if(isset($_SESSION["id_from_db"])){
		header ("Location: landingpage.php");
		
	}
  
  
  // muuutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";

  // muutujad väärtuste jaoks
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	
	
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
if(isset($_POST["create"])){

			if ( empty($_POST["create_email"]) ) {
				$create_email_error = "See väli on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}

			if ( empty($_POST["create_password"]) ) {
				$create_password_error = "See väli on kohustuslik";
			} else {
				if(strlen($_POST["create_password"]) < 8) {
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
			}

			if(	$create_email_error == "" && $create_password_error == ""){
				echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password;
      
				$password_hash = hash("sha512", $create_password);
				echo "<br>";
				echo $password_hash;
				
				createUser($create_email, $password_hash);
			
	  }

    } // create if end	
}	
function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Registreeri</title>
</head>
<body>

  <h2>Registreeri kriitikuks</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
  	<input type="submit" name="create" value="Loo kasutaja">
  </form>
<body>
<html>