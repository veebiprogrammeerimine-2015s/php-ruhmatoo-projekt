<?php

	require_once("functions.php");

    if(isset($_SESSION['logged_in_user_id'])){
        header("Location: requests.php");
    }

	$email_error = "";
	$password_error = "";

	$email = "";
	$password = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if(isset($_POST["login"])){

            if(empty($_POST["email"])) {
                $email_error = "Ei saa olla tühi";
            } else {
                $email = cleanInput($_POST["email"]);		
            }
            
            if(empty($_POST["password"])) {
                $password_error = "Ei saa olla tühi";
            } else {
                $password = cleanInput($_POST["password"]);
            }
            
            if($password_error == "" && $email_error == ""){
				
				$hash = hash("sha512", $password);
				
				$login_response = $User->loginUser($email, $hash);
				
				if(isset($login_response->success)){
					$_SESSION["logged_in_user_id"] = $login_response->success->user->id;
					$_SESSION["logged_in_user_group_id"] = $login_response->success->user->group_id;
					$_SESSION["logged_in_user_first_name"] = $login_response->success->user->first_name;
					$_SESSION["logged_in_user_last_name"] = $login_response->success->user->last_name;
					$_SESSION["logged_in_user_email"] = $login_response->success->user->email;
					
					header("Location: requests.php");
					
					exit();
				}
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
<?php

	$page_title = "Login";
	$page_file = "login.php";
	
?>

<?php require_once("../header.php"); ?>
		
		<?php if(isset($login_response->error)): ?>
		<p style="color:red;">
			<?=$login_response->error->message;?>
		</p>
		<?php endif; ?>
		
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<input name="email" type="email" placeholder="E-post" value ="<?php echo $email; ?>">* <?php echo $email_error; ?> <br><br>
			<input name="password" type="password" placeholder="Parool">* <?php echo $password_error; ?> <br><br>
			<input name="login" type="submit" value="Logi sisse">
		</form>
<?php require_once("../footer.php"); ?>