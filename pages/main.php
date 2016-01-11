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

	
	$park_list = getParkData();
	$game_php = getHistoryData();
	
?>
<p>
	Tere, <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>


<p>Siia leküljele tuleb: mängude ajalugu, kasutaja saab uusi mänge luua ja loodud mänge mängima minna</p>

<p>
	<a href="table.php">SISESTA UUS PARK</a>
	
</p>
<h1>Discgolfi pargid</h1>
<p>Juba sisestatud pargid</p>
<table border= 1>
	<tr>
		
		<th>Park name</th>
		<th>number of baskets</th>
	</tr>

<?php
		
		for($i = 0; $i < count($park_list); $i++){
			echo "<tr>";
			
				
				echo "<td>".$park_list[$i]->park_name."</td>";
				echo "<td>".$park_list[$i]->basket_number."</td>";
				echo "<td><a href='new_game_0.php?id=".$park_list[$i]->id."'>Mine Mängima</a></td>";
				
			echo "</tr>";
		}
?>
</table>
<h1>Ajalugu</h1>

<table border= 1>
	<tr>
		<th>Park name</th>
		<th>Time</th>
		
	</tr>
<?php
		for($i = 0; $i < count($game_php); $i++){
			echo "<tr>";
			
				
				echo "<td>".$game_php[$i]->game_name."</td>";
				echo "<td>".$game_php[$i]->date."</td>";
				echo "<td><a href='results.php?id=".$game_php[$i]->id."'>Tulemus</a></td>";
				
				
			echo "</tr>";
		}
		
?>