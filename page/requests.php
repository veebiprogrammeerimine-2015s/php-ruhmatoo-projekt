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
	
	$keyword = "";
	
	if(isset($_GET["keyword"])){
		$keyword = $_GET["keyword"];
		$orders_array = $OfferManager->getAllData($keyword);
	}else{
		$orders_array = $OfferManager->getAllData();
	}
	
	if(isset($_GET["update"])){
		$OfferManager->updateOrdersData(cleanInput($_GET["request_id"]), cleanInput($_GET["text_type"]), cleanInput($_GET["subject"]), cleanInput($_GET["description"]), cleanInput($_GET["target_group"]), cleanInput($_GET["source"]), cleanInput($_GET["length"]), cleanInput($_GET["offer_deadline"]), cleanInput($_GET["work_deadline"]), cleanInput($_GET["output"]));
	}
	
	if(isset($_GET["delete"])){
		$OfferManager->deleteOrdersData($_GET["delete"]);
	}
	
	function cleanInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
	}
	
?>

Kasutaja: <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1" style="text-decoration:none">[logi välja]</a>

<h2>Tellimuste tabel</h2>

<form action="requests.php" method="get">
	<input name="keyword" type="search" value="<?=$keyword?>">
	<input type="submit" value="otsi">
</form>


<?php 
	
	/*ETTEVÕTTE ENDA TÖÖPAKKUMISTE TABEL */
	if($_SESSION["logged_in_user_group_id"] == "3"){

		echo "<table border=1>";
		echo "<tr>";
		echo "<th>teksti tüüp</th>";
		echo "<th>teema</th>";
		echo "<th>kirjeldus</th>";
		echo "<th>sihtgrupp</th>";
		echo "<th>allikad</th>";
		echo "<th>maht</th>";
		echo "<th>pakkumise tähtaeg</th>";
		echo "<th>tellimuse tähtaeg</th>";
		echo "<th>ilmumiskoht</th>";
		echo "<th>staatus</th>";
		echo "<th></th>";
		echo "<th></th>";
		echo "</tr>";

		for($i = 0; $i < count($orders_array); $i++){
			if($orders_array[$i]->company_id == $_SESSION["logged_in_user_id"]){
				echo "<tr>";
				echo "<td>".$orders_array[$i]->text_type."</td>";
				echo "<td>".$orders_array[$i]->subject."</td>";
				echo "<td>".$orders_array[$i]->description."</td>";
				echo "<td>".$orders_array[$i]->target_group."</td>";
				echo "<td>".$orders_array[$i]->source."</td>";
				echo "<td>".$orders_array[$i]->length."</td>";
				echo "<td>".$orders_array[$i]->offer_deadline."</td>";
				echo "<td>".$orders_array[$i]->work_deadline."</td>";
				echo "<td>".$orders_array[$i]->output."</td>";
				echo "<td>".$orders_array[$i]->status."</td>";
				echo "<td><a href='?delete=".$orders_array[$i]->request_ID."'>kustuta</a></td>";
				echo "<td><a href='edit.php?edit_id=".$orders_array[$i]->request_ID."'>muuda</a></td>";
				echo "<tr>";
			}
		}
	
	/*KÕIK TÖÖPAKKUMISED, MÕELDUD AJAKIRJANIKELE JA ADMINILE */
	} else {
		echo "<table border=1>";
		echo "<tr>";
		echo "<th>tellija</th>";
		echo "<th>teksti tüüp</th>";
		echo "<th>teema</th>";
		echo "<th>kirjeldus</th>";
		echo "<th>sihtgrupp</th>";
		echo "<th>allikad</th>";
		echo "<th>maht</th>";
		echo "<th>pakkumise tähtaeg</th>";
		echo "<th>tellimise tähtaeg</th>";
		echo "<th>ilmumiskoht</th>";
		echo "<th></th>";
		echo "<th></th>";
		echo "</tr>";
		
		for($i = 0; $i < count($orders_array); $i++){
			if(empty($orders_array[$i]->status)){
				echo "<tr>";
				echo "<td>".$orders_array[$i]->company_name."</td>";
				echo "<td>".$orders_array[$i]->text_type."</td>";
				echo "<td>".$orders_array[$i]->subject."</td>";
				echo "<td>".$orders_array[$i]->description."</td>";
				echo "<td>".$orders_array[$i]->target_group."</td>";
				echo "<td>".$orders_array[$i]->source."</td>";
				echo "<td>".$orders_array[$i]->length."</td>";
				echo "<td>".$orders_array[$i]->offer_deadline."</td>";
				echo "<td>".$orders_array[$i]->work_deadline."</td>";
				echo "<td>".$orders_array[$i]->output."</td>";
				echo "<td><a href='feedback.php?user_feedback_id=".$orders_array[$i]->company_id."'>vaata tagasisidet</a></td>";
				echo "<td><a href='offers_data.php?offers_data_id=".$orders_array[$i]->request_ID."'>tee pakkumine</a></td>";
				echo "<tr>";
			}
		}
	}
?>
</table><br>

<a href="data.php">Tellimuse esitamine</a> <br>
<a href="offers.php">Esitatud pakkumised</a>