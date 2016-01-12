<?php

	require_once("functions.php");
	require_once("OfferManager.class.php");
	require_once("header.php");
	
	$OfferManager = new OfferManager($mysqli, $_SESSION["logged_in_user_id"]);
	
	if(!isset($_GET["user_feedback_id"])){
		header("Location: ?user_feedback_id=".$_SESSION['logged_in_user_id']);
	}

	$feedback_array = $OfferManager->getFeedbackData();

?>

<?php
	
	/* SEE ON MÕELDUD ADMINI JAOKS */
	if($_SESSION["logged_in_user_group_id"] == "1"){
		
		echo"<h3>Tagasiside</h3>";
		
		echo "<table class='table table-striped'>";
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
	/* SEE (ALUMINE OSA)ON MÕELDUD AJAKIRJANIKU JA ETTEVÕTTE JAOKS */
	}else{
		
		/* SEE VAATAB JA KAJASTAB SELLE INIMESE, KELLE KOHTA TAGASISIDE ON */
		for($i = 0; $i < count($feedback_array); $i++){
			if($_GET["user_feedback_id"] == $feedback_array[$i]->to_user_id){
				echo "<h3>Tagasiside kasutajale: ".$feedback_array[$i]->to_user_first_name." ".$feedback_array[$i]->to_user_last_name."</h3>";
				break;
			}
		}

		echo "<table class='table table-striped'>";
		echo "<tr>";
		echo "<th>Tagasiside</th>";
		echo "<th>Kellelt</th>";
		if($_SESSION["logged_in_user_group_id"] == "2"){
			echo "<th>Ettevõte</th>";
		}
		echo "<th>Kuupäev</th>";
		echo "</tr>";
		
		for($i = 0; $i < count($feedback_array); $i++){
			if($_GET["user_feedback_id"] == $feedback_array[$i]->to_user_id){
				echo "<tr>";
				echo "<td>".$feedback_array[$i]->feedback_text."</td>";
				echo "<td>".$feedback_array[$i]->from_user_first_name." ".$feedback_array[$i]->from_user_last_name."</td>";
				if($_SESSION["logged_in_user_group_id"] == "2"){
					echo "<td>".$feedback_array[$i]->from_user_company_name."</td>";
				}
				echo "<td>".$feedback_array[$i]->feedback_date."</td>";
				echo "</tr>";
			}
		}
	}
?>
	
</table>
