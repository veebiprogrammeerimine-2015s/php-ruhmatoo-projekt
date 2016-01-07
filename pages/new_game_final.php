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
	
	$results_list = getGameData($_SESSION["game_id"]);
?>
<p>
	Sisselogitud kasutajaga <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>
<p>m2ng l2bi!!!</p>
<table border=1 >
<tr>
	<th>Korv</th>
	<th>Par</th>
	<th>Tulemus</th>
	
</tr>
<?php
	
	$previous_basket = -1;
	
	for($i = 0; $i < count($results_list); $i++){
		
		if ($results_list[$i]->basket_nr == $previous_basket){
			continue;
		}else{
			if($previous_basket != -1){
				$i = $i + $previous_basket;
			}
			
		}
			
		
		echo "<tr>";
			echo "<td>".$results_list[$i]->basket_nr."</td>";
			echo "<td>".$results_list[$i]->par."</td>";
			echo "<td>".$results_list[$i]->result."</td>";
		echo "</tr>";
		
		$previous_basket = $results_list[$i]->basket_nr;
		
	}
?>