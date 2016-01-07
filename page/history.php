<?php
	
	require_once("header.php");
	require_once("functions.php");
	require_once("OfferManager.class.php");
	
	$OfferManager = new OfferManager($mysqli, $_SESSION["logged_in_user_id"]);
	
	if(!isSet($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	/* See tähendab, et see leht on mõeldud ainult admini jaoks */
	if(!$_SESSION["logged_in_user_group_id"] == "1"){
		header("Location: requests.php");
	}

	if(isSet($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}
	
	$history_array = $OfferManager->getFeedbackData();

?>

<h2>Ajalugu</h2>

