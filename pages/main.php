<?php
	
	require_once("../functions.php");
		
	
	if(isset($_GET["logout"])){
		
		session_destroy();
			
		header("Location: login.php");
		
	}
	
	if(isset($_GET["table"])){
			
		header("Location: table.php");
		
	}
	
	
	
?>
<p>
	Tere, <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>


<p>Siia leküljele tuleb: mängude ajalugu, kasutaja saab uusi mänge luua ja loodud mänge mängima minna</p>

<p>
	<a href="?table=1">SISESTA UUS MÄNG</a>
	
</p>