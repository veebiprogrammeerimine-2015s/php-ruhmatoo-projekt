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
	
	$results_list = getGameData();
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
	
	for($i = 0; $i < count($results_list); $i++){
		echo "<tr>";
			echo "<td>".$results_list[$i]->basket_nr."</td>";
			echo "<td>".$results_list[$i]->par."</td>";
			echo "<td>".$results_list[$i]->result."</td>";
		echo "</tr>";
	}
?>