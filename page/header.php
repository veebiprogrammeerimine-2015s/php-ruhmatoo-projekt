Kasutaja: <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1" style="text-decoration:none">[logi välja]</a>

<?php
if(!isSet($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		exit();
	}
	
	if(isSet($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}
?>