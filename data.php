<?php
	require_once("functions.php");
	require_once("header.php");
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	//data.php
	// siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja ei ole sisseloginud,
	//siis suuunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	



	
?>

	<p>Welcome, <?=$_SESSION["logged_in_user_email"];?> </p>
	<p><a href="?logout=1"> Log out <a> </p>



