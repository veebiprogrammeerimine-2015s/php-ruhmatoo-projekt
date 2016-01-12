<?php
//laen funktsiooni faili	
	require_once("../functions.php");
	require_once("../header.php"); 
	
//kontrollin, kas kasutaja ei ole sisseloginud	
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login.php");
	}
	
//login välja	
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}
	
	$results_php = getResultData();
?>

<table class="center" border=1 >
<tr>
	<th>Basket</th>
	<th>Result</th>
	
	
</tr>
<?php
	
	for($i = 0; $i < count($results_php); $i++){
		
					
		
		echo "<tr>";
			echo "<td>".$results_php[$i]->basket_nr."</td>";
			echo "<td>".$results_php[$i]->result."</td>";
		echo "</tr>";
		
		
		
	}
?>

