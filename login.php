<?php
//laeme funktsiooni failis
	require_once("functions.php");
	
	//*******************//
	//***Kuhu suunata?***//
	//*******************//
	//kontrollin, kas kasutaja on sisseloginud
	if(isset($_SESSION["id_from_db"])){
		// kui on,suunan data lehele
		header("Location: data.php");
		exit();
	}
	
	// muuutujad errorite jaoks
	$personalcode_error = $password_error = $create_personalcode_error = $create_password_error = "";
	// muutujad väärtuste jaoks
	$personalcode = $password = $create_personalcode = $create_password = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		// Sisse logimine
		if(isset($_POST["login"])){
			if ( empty($_POST["personalcode"]) ) {
				$personalcode_error = "See väli on kohustuslik";
			}else{
				// puhastame muutuja võimalikest üleliigsetest sümbolitest
				$personalcode = cleanInput($_POST["personalcode"]);
			}
			if ( empty($_POST["password"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}
			// Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $personalcode_error == ""){

				$password_hash = hash("sha512", $password);
				
				// käivitan funktsiooni
				$login_response = $User->loginUser($personalcode, $password_hash);
				if(isset($login_response->success)){
					//läks edukalt, peab sessiooni salvestama
					$_SESSION["id_from_db"] = $login_response->success->user->id;
					$_SESSION["pc_from_db"] = $login_response->success->user->personalcode;
					//***********************************//
					//**suunamine peale sisse logimist?**//
					//***********************************//
					header("Location:data.php");
					//lõpetame php laadimise
					exit();
				}
			}
		}
		
	//Kasutaja loomine
    if(isset($_POST["create"])){
			if ( empty($_POST["create_personalcode"]) ) {
				$create_personalcode_error = "See väli on kohustuslik";
			}else{
				$create_personalcode = cleanInput($_POST["create_personalcode"]);
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
			//võib kasutaja teha
			if(	$create_personalcode_error == "" && $create_password_error == ""){
				
				$password_hash = hash("sha512", $create_password);
				
				//käivitame funktsiooni
				$create_response = $User->createUser($create_personalcode, $password_hash);
				
			}
    }
	}
  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
?>

<?php
	//load header
	require_once("header.php");
?> 
<!--main code start here --> 

<html>
<head>
  <title>Login</title>
</head>
<body>

  <h2>Logi sisse</h2>
  
  <?php if(isset($login_response->error)):?>
  <p style="color:red;"><?=$login_response->error->message;?></p>
  <?php elseif(isset($login_response->success)):?>
  <p style="color:green;"><?=$login_response->success->message;?></p>
  <?php endif;?>
  
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="personalcode" type="number" placeholder="Isikukood" value="<?php echo $personalcode; ?>"> <?php echo $personalcode_error; ?><br><br>
  	<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Logi sisse">
  </form>

  <h2>Loo kasutaja</h2>
  
  <?php if(isset($create_response->error)):?>
  <p style="color:red;"><?=$create_response->error->message;?></p>
  <?php elseif(isset($create_response->success)):?>
  <p style="color:green;"><?=$create_response->success->message;?></p>
  <?php endif;?>
  
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_personalcode" type="number" placeholder="Isikukood" value="<?php echo $create_personalcode; ?>"> <?php echo $create_personalcode_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
  	<input type="submit" name="create" value="Loo kasutaja">
  </form>
  
<body>
<html>

<!--main code end here -->  
<?php
	//load footer
	require_once("footer.php");	
?> 
    