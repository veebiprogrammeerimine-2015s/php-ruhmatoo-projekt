<?php
	
	//kontrollin, kas kasutaja on sisseligunud
	
	//kontrollin, kas kasutaja on registreerinud
	
		
	
	
	$create_password_error = "";
	$create_email_error = "";
	$create_name_error = "";
	$create_secondname_error = "";
	$create_age_error = "";
	$create_eriala_error = "";
	$create_login_error = "";

	$create_email = "";
	$create_password = "";
	$create_name = "";
	$create_secondname = "";
	$create_age = "";
	$create_eriala = "";
	$create_login = "";

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
			
			if ( empty($_POST["create_login"]) ) {
				$create_login_error = "See väli on kohustuslik";
			}else{
				$create_login = cleanInput($_POST["create_login"]);
			}
			
			if ( empty($_POST["create_name"]) ) {
				$create_name_error = "See väli on kohustuslik";
			}else{
				$create_name = cleanInput($_POST["create_name"]);
			}
			
			if ( empty($_POST["create_secondname"]) ) {
				$create_secondname_error = "See väli on kohustuslik";
			}else{
				$create_secondname = cleanInput($_POST["create_secondname"]);
			}
			
			if ( empty($_POST["create_age"]) ) {
				$create_age_error = "See väli on kohustuslik";
			}else{
				$create_age = cleanInput($_POST["create_age"]);
			}
			
			if ( empty($_POST["create_eriala"]) ) {
				$create_eriala_error = "See väli on kohustuslik";
			}else{
				$create_eriala = cleanInput($_POST["create_eriala"]);
			}
   
			if(	$create_email_error == "" && $create_password_error == ""){
				echo "Nüüd oled registreeritud! <br> Kasutajanimi: ".$create_email." <br> Parool: ".$create_password;
				
				$password_hash = hash("sha512", $create_password);
				echo "<br>";
				echo $password_hash;
				
				createUser($create_email, $password_hash, $create_name, $create_secondname, $create_age, $create_eriala);
				
			}
		
		
		
  
 
}
//sdfffffffffffffffffffffffffffffffff
//funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
		function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
  }

?>


		<h2>Create user</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
			<label>Login:</label> <input name="create_login" type="login" placeholder="Login" value="<?php echo $create_login; ?>"> <?php echo $create_login_error; ?><br><br>
			<label>E-mail:</label> <input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
			<label>Parool:</label> <input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
			<label>Nimi:</label> <input name="create_name" type="text" placeholder="Nimi" value="<?php echo $create_name; ?>"> <?php echo $create_name_error; ?><br><br>
			<label>Perekonnanimi:</label> <input name="create_secondname" type="text" placeholder="Perekonnanimi" value="<?php echo $create_secondname; ?>"> <?php echo $create_secondname_error; ?><br><br>
			<label>Vanus:</label> <input name="create_age" type="text" placeholder="Age" value="<?php echo $create_age; ?>"> <?php echo $create_age_error; ?><br><br>
			<input name="create_eriala" type="text" placeholder="Eriala" value="<?php echo $create_eriala; ?>"> <?php echo $create_eriala_error; ?><br><br>
			<input name="create" type="submit" value="create user" > <br><br>
			
		</form>
<?php 
	$file_name = "register.php";
	$page_title = "Register";
	require_once("header.php"); ?>
	
<?php require_once("foother.php"); ?>