
<?php
require_once("../functions.php");
require_once("../user.class.php");
require_once("../header.php");

?>

<?php
    
    
    //kui kasutaja on sisse logitud, suuna teisele lehele
    //kontrollin kas sessiooni muutuja olemas
    if(isset($_SESSION['user_id'])){
        header("Location: profile.php");
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
                
                $login_response = $User->loginUser($email, $hash);
                
                //var_dump($login_response);
                //echo $login_response->success->user->email;
                
                if(isset($login_response->success)){
                    // sisselogimine õnnestus
                    $_SESSION["user_id"] = $login_response->success->user->id;
                    $_SESSION["user_email"] = $login_response->success->user->email;
                    
                    header("Location: data.php");
                }
            
            }
		} // login if end
    // *********************
    // ** LOO KASUTAJA *****
    // *********************
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
				//echo hash("sha512", $create_password);
                //echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password;
                
                // tekitan parooliräsi
                $hash = hash("sha512", $create_password);
                
                //functions.php's funktsioon
                $response = $User->createUser($create_email, $hash);
                
                
                
                
            }
        } // create if end
	}
  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
  
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

  <h2>Log in</h2>
  
  <?php if(isset($login_response->error)): ?>
  
  <p style="color:red;">
    <?=$login_response->error->message;?>
  </p>
   
  <?php endif; ?>
  
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
  	<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Log in">
  </form>

 
<body>
<html>