<?php
	require_once("functions.php");

	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
		exit();
	}
	
	if(isset($_GET["logout"])){

		session_destroy();
		
		header("Location: login.php");
	}
	
?>

<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi valja <a> 
</p>

