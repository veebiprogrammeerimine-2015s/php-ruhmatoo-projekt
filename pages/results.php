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
	
	$results_php = getResultData($_SESSION["game_id"]);
?>
<p>
	Sisselogitud kasutajaga <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>
<?php
	
	for($i = 0; $i < count($results_php); $i++){
		
					
		
		echo "<tr>";
			echo "<td>".$results_php[$i]->basket_nr."</td>";
			echo "<td>".$results_php[$i]->result."</td>";
		echo "</tr>";
		
		
		
	}
?>

<a href='main.php'>AVALEHELE</a>