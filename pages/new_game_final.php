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
	
	$results_list = getGameData($_SESSION["game_id"]);
?>


<p>Your game is over. Your results are here: <br></p>
<p>
total par =  <?php echo $_SESSION["sum_pars"]; ?> <br>
total result =  <?php echo $_SESSION["sum_results"]; ?> <br>
difference = <?php echo $_SESSION["difference"]; ?>
 </p>



<table class="center" border=1 >
<tr>
	<th>Basket</th>
	<th>Par</th>
	<th>Result</th>
	
</tr>
<?php
	
	$previous_basket = -1;
	
	for($i = 0; $i < count($results_list); $i++){
		
					
		
		echo "<tr>";
			echo "<td>".$results_list[$i]->basket_nr."</td>";
			echo "<td>".$results_list[$i]->par."</td>";
			echo "<td>".$results_list[$i]->result."</td>";
		echo "</tr>";
		
		
		
	}
?>

