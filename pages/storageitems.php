<?php
	require_once(__DIR__."/../functions/functions.php");
	require_once(__DIR__."/../classes/storage.class.php");
	$page_title = "Storage Add item";
	$page_file_name = "storageadditem.php";
	$itemCreate = new itemCreate($connection);
	$getAllItems = new getAllItems($connection);
	$deleteItems = new deleteItems($connection);
	$updateItems = new updateItems($connection);
	$getStorage = new getStorage($connection);

	$table_array = $getAllItems->getAllItems();
	$storage_array = $getStorage->getStorage();
	if(isset($_GET["delete"])) {
		$response = $deleteItems->deleteItems($_GET["delete"]);
	}

	if(isset($_GET["update"])){
		$response = $updateItems->updateItems($_GET['item_price'], $_GET['item_weight'], $_GET['item_name'], $_GET['item_length'], $_GET['item_height'], $_GET['item_weight'], $_GET['item_id']);
	}
		
	$keyword = "";
	if(isset($_GET["keyword"])){
		$keyword = $_GET["keyword"];
		$table_array = $getAllItems->getAllItems($keyword);
	}else{
		$table_array = $getAllItems->getAllItems();
	}
	
	$merchandisename_error = "";
	$merchandiseprice_error = "";
	$merchandiseweight_error = "";
	$merch_height_error = "";
	$merch_length_error = "";
	$merch_width_error = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["merchandisename"])) {
		$merchandisename_error = "Name is required";
		} else {
		$merchandisename = test_input($_POST["merchandisename"]);
		}
		if (empty($_POST["merchandiseprice"])) {
		$merchandiseprice_error = "Price is required";
		} else {
		$merchandiseprice = test_input($_POST["merchandiseprice"]);
		}
		if (empty($_POST["merchandiseweight"])) {
		$merchandiseweight_error = "Weight is required";
		} else {
		$merchandiseweight = test_input($_POST["merchandiseweight"]);
		}
		if (empty($_POST["merch_height"])) {
		$merch_height_error = "height is required";
		} else {
		$merch_height = test_input($_POST["merch_height"]);
		}
		if (empty($_POST["merch_length"])) {
		$merch_length_error = "Length is required";
		} else {
		$merch_length = test_input($_POST["merch_length"]);
		}
		if (empty($_POST["merch_width"])) {
		$merch_width_error = "Width is required";
		} else {
		$merch_width = test_input($_POST["merch_width"]);
		}
		if ($merch_height_error == "" and $merch_length_error == "" and $merch_width_error == "" and $merchandisename_error == "" and $merchandiseprice_error == "" and $merchandiseweight_error == ""){
			$response = $itemCreate->createItem($merchandiseprice, $merchandiseweight, $merchandisename, $merch_length, $merch_height, $merch_width);
		}else{
		}
	}
?>
<?php require_once(__DIR__."/../header.php"); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<label class="text">Create Storage</label>
				<?php if(isset($response->success)):	 ?>
				
				<p><?=$response->success->message;?></p>
				
				<?php	elseif(isset($response->error)): ?>
				
				<p><?=$response->error->message;?></p>
				
				<?php	endif; ?>
		
		
			<input class="form-control" name="merchandisename" type="text" placeholder="Item name" value="<?php echo $merchandisename;?>" > <?php echo $merchandisename_error;?> <br>
			<div class="input-group">
				<span class="input-group-addon">€</span>
				<input class="form-control" name="merchandiseprice" type="number" placeholder="Price"">
				<span class="input-group-addon">.00</span>
			</div><?php echo $merchandiseprice_error;?>
			<br>
			<input class="form-control" name="merchandiseweight" type="number" placeholder="Weight" > <?php echo $merchandiseweight_error;?><br>
			<input class="form-control" name="merch_height" type="number" placeholder="Height" > <?php echo $merch_height_error;?><br>
			<input class="form-control" name="merch_length" type="number" placeholder="Length" > <?php echo $merch_length_error;?><br>
			<input class="form-control" name="merch_width" type="number" placeholder="Width" > <?php echo $merch_width_error;?>
			<br>
			<?php
			echo '<select class="btn btn-default" name="ladu">';
				for($i = 0; $i < count($storage_array); $i++){
					echo '<option value="'.$storage_array[$i]->name.'">'.$storage_array[$i]->name.'</option>';
				}
			echo '</select>';
			?>
			<br>
			<br>
			<input name="create" type="submit" value="Create Item"class="btn btn-info btn-block">
			</form>
		</div>
		<div class="col-sm-9">
			<table class="table table-hover">
			<tr>
				<th>Kauba ID</th>
				<th>Kauba Nimetus</th>
				<th>Kauba Hind</th>
				<th>Kauba Pikkus</th>
				<th>Kauba Laius</th>
				<th>Kauba Kõrgus</th>
				<th>Kauba Kaal</th>
				<th>Muuda</th>
				<th>Kustuta</th>
			</tr>
			<?php 
			for($i = 0; $i < count($table_array); $i++){
				if(isset($_GET["edit"]) && $_GET["edit"] == $table_array[$i]->id) {
					echo "<tr>";
					echo '<form action="/pages/storageitems.php" method="get">';
					echo "<input type='hidden' name='item_id' value='".$table_array[$i]->id."'>";
					echo "<td>".$table_array[$i]->id."</td> ";
					echo "<td><input class='form-control' name='item_name' value='".$table_array[$i]->item_name."'></td>";
					echo "<td><input class='form-control' name='item_price' value='".$table_array[$i]->price_added."'></td>";
					echo "<td><input class='form-control' name='item_length' value='".$table_array[$i]->item_length."'></td>";
					echo "<td><input class='form-control' name='item_width' value='".$table_array[$i]->item_width."'></td>";
					echo "<td><input class='form-control' name='item_height' value='".$table_array[$i]->item_height."'></td>";
					echo "<td><input class='form-control' name='item_weight' value='".$table_array[$i]->item_weight."'></td>";
					echo "<td><input class='btn btn-defaultx btn-block' name='update' type='submit' value='Uuenda'></td>";
					echo "<td><a class='btn btn-default btn-block' href='/pages/storageitems.php'>Katkesta</a></td>";
					echo "</form>";
					echo "</tr>";
				} else {
					echo "<tr> <td>".$table_array[$i]->id."</td> ";
					echo "<td>".$table_array[$i]->item_name."</td> ";
					echo "<td>".$table_array[$i]->price_added."</td>"; 
					echo "<td>".$table_array[$i]->item_length."</td>"; 
					echo "<td>".$table_array[$i]->item_width."</td>"; 
					echo "<td>".$table_array[$i]->item_height."</td>"; 
					echo "<td>".$table_array[$i]->item_weight."</td>"; 
					echo '<td><a class="btn btn-info btn-block" href="/pages/storageitems.php?edit='.$table_array[$i]->id.'">Muuda</a></td>';
					echo '<td><a class="btn btn-info btn-block" href="/pages/storageitems.php?delete='.$table_array[$i]->id.'">Kustuta</a></td></tr>';
					
				}
			}
			?>
			</table>
		</div>
	</div>
	<div class="row">
		<div div class="col-sm-3">
			<label class="text"> Kaup </label>
				<form action="/pages/storageitems.php" method="get">
					<input class="form-control" name="keyword" type="search" value="<?=$keyword?>" ><br>
					<input type="submit" value="otsi" class="btn btn-info btn-block">
				</form>
		</div>
	</div>
</div>
<?php require_once(__DIR__."/../footer.php"); ?>