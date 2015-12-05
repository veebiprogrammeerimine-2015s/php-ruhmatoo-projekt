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
		$OfferManager->updateOrdersData(cleanInput($_GET["request_id"]), cleanInput($_GET["text_type"]), cleanInput($_GET["subject"]), cleanInput($_GET["description"]), cleanInput($_GET["target_group"]), cleanInput($_GET["source"]), cleanInput($_GET["length"]), cleanInput($_GET["deadline"]), cleanInput($_GET["output"]));
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

Kasutaja: <?=$_SESSION['logged_in_user_id'];?> <a href="?logout=1" style="text-decoration:none">[logi välja]</a>

<h2>Tellimuste tabel</h2>

<form action="requests.php" method="get">
	<input name="keyword" type="search" value="<?=$keyword?>">
	<input type="submit" value="otsi">
</form>

<table border=1>
<tr>
    <th>teksti tüüp</th>
    <th>teema</th>
	<th>kirjeldus</th>
	<th>sihtgrupp</th>
    <th>allikad</th>
    <th>maht</th>
    <th>tähtaeg</th>
	<th>ilmumiskoht</th>
    <th></th>
	<th></th>
	<th></th>
</tr>

<?php
	for($i = 0; $i < count($orders_array); $i++){
		echo "<tr>";
		echo "<td>".$orders_array[$i]->text_type."</td>";
		echo "<td>".$orders_array[$i]->subject."</td>";
		echo "<td>".$orders_array[$i]->description."</td>";
		echo "<td>".$orders_array[$i]->target_group."</td>";
		echo "<td>".$orders_array[$i]->source."</td>";
		echo "<td>".$orders_array[$i]->length."</td>";
		echo "<td>".$orders_array[$i]->deadline."</td>";
		echo "<td>".$orders_array[$i]->output."</td>";
		echo "<td><a href='?delete=".$orders_array[$i]->request_ID."'>kustuta</a></td>";
		echo "<td><a href='edit.php?edit_id=".$orders_array[$i]->request_ID."'>muuda</a></td>";
		echo "<td><a href='offers_data.php?offers_data_id=".$orders_array[$i]->request_ID."'>tee pakkumine</a></td>";
		echo "<tr>";
	}
?>
</table><br>

<a href="data.php">Tellimuse esitamine</a>