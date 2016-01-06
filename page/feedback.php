<?php

	require_once("functions.php");
	require_once("OfferManager.class.php");
	
	$OfferManager = new OfferManager($mysqli, $_SESSION["logged_in_user_id"]);
	
	if(!isSet($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	if(isSet($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}
	
	$feedback_array = $OfferManager->getFeedbackData();

?>

Kasutaja: <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1" style="text-decoration:none">[logi välja]</a>

<h2>Tagaside</h2>

<?php

	if($_GET["user_feedback_id"])


<table border=1>
	<tr>
		<th>Eesnimi</th>
		<th>Perekonnanimi</th>
		<th>Ettevõtte nimetus</th>
		<th>Kommentaar</th>
		<th>Eesnimi</th>
		<th>Perekonnanimi</th>
		<th>Ettevõtte nimetus</th>
		<th>Kuupäev</th>
	</tr>
	
<?php

	for($i = 0; $i < count($feedback_array); $i++){
		echo "<tr>";
		echo "<td>".$feedback_array[$i]->to_user_first_name."</td>";
		echo "<td>".$feedback_array[$i]->to_user_last_name."</td>";
		echo "<td>".$feedback_array[$i]->to_user_company_name."</td>";
		echo "<td>".$feedback_array[$i]->feedback_text."</td>";
		echo "<td>".$feedback_array[$i]->from_user_first_name."</td>";
		echo "<td>".$feedback_array[$i]->from_user_last_name."</td>";
		echo "<td>".$feedback_array[$i]->from_user_company_name."</td>";
		echo "<td>".$feedback_array[$i]->feedback_date."</td>";
		echo "</tr>";
	}

?>
	
</table>
