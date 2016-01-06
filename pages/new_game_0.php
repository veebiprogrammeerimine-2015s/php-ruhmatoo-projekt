<?php
//laen funktsiooni faili	
	require_once("../functions.php");
	
//kontrollin, kas kasutaja ei ole sisseloginud	
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login.php");
	}
	
//login välja	
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}
	
	//$park_id = $_GET["id"];
	//$nr_of_baskets = $_GET["nr"];
	
//mängu alustamine	
	

?>
<p>
	Sisselogitud kasutajaga <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>
<h2>Pane mängule nimi:</h2><br>
<table border= 1>
	<tr>
		
		<th>Mängu nimi</th>
	<tr>
<?php

	if(isset($_POST['save'])){
		//var_dump($_POST);
		$game_name = $_POST["game_name"];
		startNewGame($game_name, $_GET["id"]);
	}
	

	echo "<form action=new_game_0.php method='post'>";
	echo "<table>";
	echo "<tr>";
	echo "<td><input name='park_id' type='hidden' value='".$_GET["id"]."'></td>";
	echo "<td><input name='nr_of_baskets' type='hidden' value='".$_GET["nr"]."'></td>";
	echo "<td><input name='game_name'>"."</td>";
	echo "<td>"."</td>";
	echo "</table>";
	echo "<input type='submit' name='save' value='salvesta'>";
	echo "</form";
	
	
	



?>