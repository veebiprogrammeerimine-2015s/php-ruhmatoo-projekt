<?php

	require_once("functions.php");
	require_once("OfferManager.class.php");
	
	$OfferManager = new OfferManager($mysqli, $_SESSION["logged_in_user_id"]);
	
	if(!isSet($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	if(isSet($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}
	
	$feedback_array = $OfferManager->getFeedbackData();

?>

Kasutaja: <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1" style="text-decoration:none">[logi välja]</a>

<h2>Tagaside</h2>



