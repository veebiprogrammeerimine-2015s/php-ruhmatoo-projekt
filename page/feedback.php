<?php

	require_once("functions.php");
	require_once("OfferManager.class.php");
	require_once("header.php");
	
	$OfferManager = new OfferManager($mysqli, $_SESSION["logged_in_user_id"]);
			
	if(!isset($_GET["user_feedback_id"])){
		header("Location: requests.php");
	}

	$feedback_array = $OfferManager->getFeedbackData();

?>

Kasutaja: <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1" style="text-decoration:none">[logi välja]</a>

<?php
	
	/* SEE ON MÕELDUD ADMINI JAOKS */
	if($_SESSION["logged_in_user_group_id"] == "1"){
		
		echo"<h2>Tagasiside</h2>";
		
		echo "<table border=1>";
		echo "<tr>";
		echo "<th>To:Eesnimi</th>";
		echo "<th>To:Perekonnanimi</th>";
		echo "<th>To:Ettevõtte nimetus</th>";
		echo "<th>Kommentaar</th>";
		echo "<th>From:Eesnimi</th>";
		echo "<th>From:Perekonnanimi</th>";
		echo "<th>From:Ettevõtte nimetus</th>";
		echo "<th>Kuupäev</th>";
		echo "</tr>";

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
	/* SEE ON MÕELDUD AJAKIRJANIKU JA ETTEVÕTTE JAOKS */
	}else{
		
		for($i = 0; $i < count($feedback_array); $i++){
			if($_GET["user_feedback_id"] == $feedback_array[$i]->to_user_id){
				echo "<h2>Tagasiside kasutajale: ".$feedback_array[$i]->to_user_first_name." ".$feedback_array[$i]->to_user_last_name."</h2>";
				break;
			}
		}

		echo "<table border=1>";
		echo "<tr>";
		echo "<th>Tagasiside</th>";
		if($_SESSION["logged_in_user_group_id"] == "3"){
			echo "<th>From:Ettevõte</th>";
		}
		echo "<th>From:Eesnimi</th>";
		echo "<th>From:Perekonnanimi</th>";
		echo "<th>Kuupäev</th>";
		echo "</tr>";
		
		for($i = 0; $i < count($feedback_array); $i++){
			if($_GET["user_feedback_id"] == $feedback_array[$i]->to_user_id){
				echo "<tr>";
				echo "<td>".$feedback_array[$i]->feedback_text."</td>";
				if($_SESSION["logged_in_user_group_id"] == "3"){
					echo "<td>".$feedback_array[$i]->from_user_company_name."</td>";
				}
				echo "<td>".$feedback_array[$i]->from_user_first_name."</td>";
				echo "<td>".$feedback_array[$i]->from_user_last_name."</td>";
				echo "<td>".$feedback_array[$i]->feedback_date."</td>";
				echo "</tr>";
			}
		}
	}
?>
	
</table>
