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

	
	$park_list = getParkData();
	$game_php = getHistoryData();
	
?>





			<div class="parksinfo">
				<h1>ALL DISC GOLF PARKS</h1>
				<table class="center" border= 1>
					<tr>
						
						<th>Park name</th>
						<th>Number of baskets</th>
					</tr>

				<?php
						
						for($i = 0; $i < count($park_list); $i++){
							echo "<tr>";
							
								
								echo "<td>".$park_list[$i]->park_name."</td>";
								echo "<td>".$park_list[$i]->basket_number."</td>";
								echo "<td><a href='new_game_0.php?id=".$park_list[$i]->id."'>Go to play</a></td>";
								
							echo "</tr>";
						}
				?>
				</table>

				<br>

				<p>
					<a href="table.php">INSERT NEW PARK</a>	
				</p>
			</div>
			


<br><br>

<div class="historyinfo">
	<h1>GAMES HISTORY</h1>
			
	<table class="center" border= 1>
		<tr>
			<th>Game name</th>
			<th>Playing time</th>
		</tr>




	
<?php
		for($i = 0; $i < count($game_php); $i++){
			echo "<tr>";
			
				
				echo "<td>".$game_php[$i]->game_name."</td>";
				echo "<td>".$game_php[$i]->date."</td>";
				echo "<td><a href='results.php?id=".$game_php[$i]->id."'>Score</a></td>";
				
				
			echo "</tr>";
		}
		
?>

	</table>	
</div>	