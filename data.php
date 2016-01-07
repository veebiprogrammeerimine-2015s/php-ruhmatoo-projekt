<<<<<<< HEAD
<?php
 	require_once("functions.php");
 	require_once("table.php");
 	//data.php
 	// siia pääseb ligi sisseloginud kasutaja
 	//kui kasutaja ei ole sisseloginud,
 	//siis suuunan data.php lehele
 	if(!isset($_SESSION["logged_in_user_id"])){
 		header("Location: login.php");
 	}
 	
 	//kasutaja tahab välja logida
 	if(isset($_GET["logout"])){
 		//aadressireal on olemas muutuja logout
 		
 		//kustutame kõik session muutujad ja peatame sessiooni
 		session_destroy();
 		
 		header("Location: login.php");
 	}
?>
=======
Said sisse logitud. tubli
<?php 
if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	//kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}

?>

<html>
<body style="background-color:#0074D9; text-align:center">
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi välja <a> 
</p>
>>>>>>> 78a8e7af95241d3fb998aa26f5678429c1b471af
