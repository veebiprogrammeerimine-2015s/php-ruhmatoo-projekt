<?php

	//laeme funktsiooni failis
	require_once("function.php");
	
	//kontrollin, kas kasutaja on sisseloginud
	if(isset($_SESSION["user_id_from_db"])){
		// suunan data lehele
		header("Location: data.php");
	}
	
	$create_email_error = "";
	$create_password_error = "";
	$create_name_error = "";
	
	$create_email = "";
	$create_password = "";
	$create_name = "";
	
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
			
			if ( empty($_POST["create_name"]) ) {
				$create_name_error = "See väli on kohustuslik";
			}else{
				$create_name = cleanInput($_POST["create_name"]);
			}
			
			
			if(	$create_email_error == "" && $create_password_error == ""){
				echo "Nüüd oled registreeritud! <br> Kasutajanimi: ".$create_email." <br> Parool: ".$create_password;
				
		    createUser($create_email, $create_password, $create_name);
			
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
 <body>
		<h2>Create user</h2>

		<div>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="field" >
			E-Mail: <input class="input" name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
			Parool: <input class="input" name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
			Nimi: <input class="input" name="create_name" type="text" placeholder="Nimi" value="<?php echo $create_name; ?>"> <?php echo $create_name_error; ?><br><br>
			</div>
			<input  name="create" type="submit" class="button3" value="create user" > <br><br>
        </form>

			

<?php 
	$file_name = "registration.php";
	$page_title = "Registration"; ?>
	

	
<?php require_once("foother.php"); ?>

<?php require_once("menyy.php"); ?>


