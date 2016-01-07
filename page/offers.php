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
	
	if(isset($_GET["update_1"], $_GET["update_2"])){
		$OfferManager->updateOffersAndRequestsData($_GET["update_1"], $_GET["update_2"]);
	}
	
	$offers_array = $OfferManager->getOffersData();
?>

Kasutaja: <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1" style="text-decoration:none">[logi välja]</a>

<h2>Pakkumiste tabel</h2>

<?php

/* Antud lehekülg on mõeldud nii ajakirjanikule kui ka ettevõttele, st:
(1) iga ajakirjanik saab vaadata enda tehtud pakkumisi ettevõtete tööpakkumistele ja
(2) iga ettevõte saab vaadata ajakirjanike pakkumisi antud ettevõtte tööpakkumistele */
	
	
	/* AJAKIRJANIK */
	if($_SESSION["logged_in_user_group_id"] == "2"){
		
		echo "<table border=1>";
		echo "<tr>";
		echo "<th>Ajakirjanik</th>";
		echo "<th>tellimus</th>";
		echo "<th>tellimus_nimi</th>";
		echo "<th>tellimus_ettevõte</th>";
		echo "<th>kuupäev</th>";
		echo "<th>hind</th>";
		echo "<th>kommentaar</th>";
		echo "<th>accepted</th>";
		echo "<th></th>";
		echo "</tr>";

		for($i = 0; $i < count($offers_array); $i++){
			echo "<tr>";
			echo "<td>".$offers_array[$i]->journalist_first_name." ".$offers_array[$i]->journalist_last_name."</td>";
			echo "<td>".$offers_array[$i]->request_id."</td>";
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
	
	/* ETTEVÕTE */
	if($_SESSION["logged_in_user_group_id"] == "3"){
		
		echo "<table border=1>";
		echo "<tr>";
		echo "<th>Ajakirjanik</th>";
		echo "<th>tellimus</th>";
		echo "<th>tellimus_nimi</th>";
		echo "<th>tellimus_ettevõte</th>";
		echo "<th>kuupäev</th>";
		echo "<th>hind</th>";
		echo "<th>kommentaar</th>";
		echo "<th>accepted</th>";
		echo "<th></th>";
		echo "<th></th>";
		echo "<th></th>";
		echo "</tr>";
	
		for($i = 0; $i < count($offers_array); $i++){
			echo "<tr>";
			echo "<td>".$offers_array[$i]->journalist_first_name." ".$offers_array[$i]->journalist_last_name."</td>";
			echo "<td>".$offers_array[$i]->request_id."</td>";
			echo "<td>".$offers_array[$i]->subject."</td>";
			echo "<td>".$offers_array[$i]->company_name."</td>";
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