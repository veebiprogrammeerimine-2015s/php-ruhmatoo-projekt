<?php
	
	require_once("functions.php");
	require_once("OfferManager.class.php");
	require_once("header.php");
	
	$OfferManager = new OfferManager($mysqli, $_SESSION["logged_in_user_id"]);
		
	if(isset($_GET["update_1"], $_GET["update_2"])){
		$OfferManager->updateOffersAndRequestsData($_GET["update_1"], $_GET["update_2"]);
	}
	
	$offers_array = $OfferManager->getOffersData();
?>

<h3>Pakkumised</h3>

<?php

/* Antud lehekülg on mõeldud nii ajakirjanikule kui ka ettevõttele, st:
(1) iga ajakirjanik saab vaadata enda tehtud pakkumisi ettevõtete tööpakkumistele ja
(2) iga ettevõte saab vaadata ajakirjanike pakkumisi antud ettevõtte tööpakkumistele */
	
	
	/* AJAKIRJANIK */
	if($_SESSION["logged_in_user_group_id"] == "2"){
		
		echo "<table class='table table-striped'>";
		echo "<tr>";
		echo "<th>Teema</th>";
		echo "<th>Tellija</th>";
		echo "<th>Pakkumise kuupäev</th>";
		echo "<th>Hind (EUR)</th>";
		echo "<th>Kommentaar</th>";
		echo "<th>Accepted</th>";
		echo "<th></th>";
		echo "</tr>";

		for($i = 0; $i < count($offers_array); $i++){
			echo "<tr>";
			echo "<td>".$offers_array[$i]->subject."</td>";
			echo "<td>".$offers_array[$i]->company_name."</td>";
			echo "<td>".$offers_array[$i]->offer_date."</td>";
			echo "<td>".$offers_array[$i]->price."</td>";
			echo "<td>".$offers_array[$i]->comment."</td>";
			echo "<td>".$offers_array[$i]->accepted."</td>";
			if($offers_array[$i]->accepted == "1"){
				echo "<td><a href='feedback_data.php?offer_id=".$offers_array[$i]->offer_id."&to_user_id=".$offers_array[$i]->company_id."'>anna tagasisidet</a></td>";
			}
			echo "<tr>";
		}
	}
	
	/* ETTEVÕTE JA ADMIN*/
	else {
		
		echo "<table class='table table-striped'>";
		echo "<tr>";
		echo "<th>Ajakirjanik</th>";
		echo "<th>Tellimus</th>";
		if($_SESSION["logged_in_user_group_id"] == "1"){
			echo "<th>tellimus_ettevõte</th>";
		}
		echo "<th>Kuupäev</th>";
		echo "<th>Hind</th>";
		echo "<th>Kommentaar</th>";
		echo "<th>Accepted</th>";
		echo "<th></th>";
		echo "<th></th>";
		echo "<th></th>";
		echo "</tr>";
	
		for($i = 0; $i < count($offers_array); $i++){
			echo "<tr>";
			echo "<td>".$offers_array[$i]->journalist_first_name." ".$offers_array[$i]->journalist_last_name."</td>";
			echo "<td>".$offers_array[$i]->subject."</td>";
			if($_SESSION["logged_in_user_group_id"] == "1"){
				echo "<td>".$offers_array[$i]->company_name."</td>";
			}
			echo "<td>".$offers_array[$i]->offer_date."</td>";
			echo "<td>".$offers_array[$i]->price."</td>";
			echo "<td>".$offers_array[$i]->comment."</td>";
			echo "<td>".$offers_array[$i]->accepted."</td>";
			echo "<td><a href='feedback.php?user_feedback_id=".$offers_array[$i]->journalist_id."'>vaata tagasisidet</a></td>";
			if($offers_array[$i]->accepted == "1" or $offers_array[$i]->accepted == "0"){
				echo "<td></td>";
			} else {
				echo "<td><a href='?update_1=".$offers_array[$i]->offer_id."&update_2=".$offers_array[$i]->request_id."'>aktsepteeri</a></td>";
			}
			if($offers_array[$i]->accepted == "1"){
				echo "<td><a href='feedback_data.php?offer_id=".$offers_array[$i]->offer_id."&to_user_id=".$offers_array[$i]->journalist_id."'>anna tagasisidet</a></td>";
			}
			echo "<tr>";
		}
	}

?>

</table><br>