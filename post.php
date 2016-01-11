<?php

	// siia lisame auto nr märgite vormi
	//laeme funktsiooni failis
	require_once("function.php");
	
	//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		// suunan login lehele
		header("Location: home.php");
	echo "on vaja registreerida ikka!";
	}
	
	//login välja, aadressireal on ?logout=1
	if(isset($_GET["logout"])){
		//kustutab kõik sessiooni muutujad
		session_destroy();
		
		header("Location: home.php");
	
	}
?>
<?php
	require_once("header.php");
?>
<p>
	<?=$_SESSION["email_from_db"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

<h2 class ="pealkiri2">Tere tulemast!</h2>
<body> 
<link rel="stylesheet" href="kujundus.css" type="text/css" /> 
Tere tulemast meie veebilehele! Siin me saame aidata teid parandusega! :)
<body/> 
<?php require_once("postmenu.php");?>
<?php require_once("foother.php");?>
