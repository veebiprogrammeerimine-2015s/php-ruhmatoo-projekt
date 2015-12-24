<?php
	
	require_once("functions.php");
	require_once("OfferManager.class.php");
	
	$OfferManager = new OfferManager($mysqli, $_SESSION["logged_in_user_id"]);
	
	if(!isSet($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	if($_SESSION["logged_in_user_group_id"] == "3"){
		header("Location: requests.php");
	}
	
	if(isSet($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}
	
	$offers_array = $OfferManager->getOffersData();
?>

Kasutaja: <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1" style="text-decoration:none">[logi välja]</a>

<h2>Pakkumiste tabel</h2>

<table border=1>
<tr>
    <th>tellimus</th>
	<th>tellimus_nimi</th>
	<th>tellimus_ettevõte</th>
    <th>kuupäev</th>
	<th>hind</th>
    <th>kommentaar</th>
	<th>accepted</th>
</tr>

<?php
	for($i = 0; $i < count($offers_array); $i++){
		echo "<tr>";
		echo "<td>".$offers_array[$i]->request_id."</td>";
		echo "<td>".$offers_array[$i]->subject."</td>";
		echo "<td>".$offers_array[$i]->company_name."</td>";
		echo "<td>".$offers_array[$i]->offer_date."</td>";
		echo "<td>".$offers_array[$i]->price."</td>";
		echo "<td>".$offers_array[$i]->comment."</td>";
		echo "<td>".$offers_array[$i]->accepted."</td>";
		echo "<tr>";
	}
?>
</table><br>