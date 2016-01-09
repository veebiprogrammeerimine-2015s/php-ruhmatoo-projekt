<?php
	
	
	require_once("functions.php");
	require_once("OfferManager.class.php");
	require_once("header.php");
	
	$OfferManager = new OfferManager($mysqli, $_SESSION["logged_in_user_id"]);
	
	if(!isSet($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	/* See tähendab, et see leht on mõeldud ainult admini jaoks */
	if($_SESSION["logged_in_user_group_id"] != "1"){
		header("Location: requests.php");
	}

	if(isSet($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}
	
	$history_array = $OfferManager->gethistoryData();

?>

<h2>Ajalugu</h2>

<table border=1>
	<tr>
		<th>Jrk</th>
		<th>Kasutaja ID</th>
		<th>Kasutaja nimi</th>
		<th>Sisselogimine</th>
		<th>Väljalogimine</th>
	</tr>
	
<?php
	
	for($i = 0; $i < count($history_array); $i++){
		echo "<tr>";
		echo "<td>".$history_array[$i]->session_identification."</td>";
		echo "<td>".$history_array[$i]->user_id."</td>";
		echo "<td>".$history_array[$i]->user_first_name." ".$history_array[$i]->user_last_name."</td>";
		if(empty($history_array[$i]->log_in)){
			echo "<td style='background-color:#FF3300'></td>";
		} else {
			echo "<td style='background-color:#00FF66'>".$history_array[$i]->log_in."</td>";
		}
		if(empty($history_array[$i]->log_out)){
			echo "<td style='background-color:#FF3300'></td>";
		} else {
			echo "<td style='background-color:#00FF66'>".$history_array[$i]->log_out."</td>";
		}
		echo "</tr>";
	}

?>

</table>

