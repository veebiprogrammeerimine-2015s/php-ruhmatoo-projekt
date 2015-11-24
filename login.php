<?php
	require_once("functions.php");
	require_once("user.class.php");

	$pw_error = $username_error = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["username"])) {
		$username_error = "Name is required";
		} else {
		$username = test_input($_POST["username"]);
		}
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["password"])) {
		$pw_error = "Password is required";
		} else {
		$password = test_input($_POST["password"]);
		$password = hash(sha512, $password);
		}
			
		if ($pw_error == "" and $username_error == ""){
			$response = $userLogin->loginUser($username, $password);

		}
	}
	
?>
<?php

	$_SESSION['logged_in_user_username'] = $response->success->user->username;
	$_SESSION['logged_in_user_privileges'] = $response->success->user->privileges;
	$_SESSION['logged_in_user_id'] = $response->success->user->id;

?>
<?php
	$page_title = "LogIn";
	$page_file_name = "login.php";
	if(isset($_SESSION['logged_in_user_id'])){
		header("Location: index.php");

	}

?>
<?php require_once("header.php"); ?>

<div id="header" >

	<p style="font-size:30px";>Log In</p>
	<form action="<?php echo $_SERVER["PHP_SELF"]?> " method="post">

		<?php if(isset($response->success)):	 ?>

		<p><?=$response->success->message;?></p>

		<?php	elseif(isset($response->error)): ?>

		<p><?=$response->error->message;?></p>

		<?php	endif; ?>

		<p>Email/Username</p>
		<input name="username" type="text" placeholder="example" value="<?php echo $username;?>" > <?php echo $username_error;?> <br>
		<p>Password</p>
		<input name="password" type="password" placeholder="Password" > <?php echo $pw_error;?>
		<br><br>
		<input name="login" type="submit" value="Log In">
	</form>
<?php require_once("footer.php"); ?>