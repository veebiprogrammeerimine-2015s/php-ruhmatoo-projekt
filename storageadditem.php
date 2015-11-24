<?php
	require_once("functions.php");
	$page_title = "Storage Add item";
	$page_file_name = "storageadditem.php";
?>
$merchandiseprice, $merchandiseweight, $merchandisename, $merch_length, $merch_height, $merch_width)
<?php
	require_once("functions.php");
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
	}	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["merchandiseprice"])) {
		$merchandiseprice_error = "Price is required";
		} else {
		$merchandiseprice = test_input($_POST["merchandiseprice"]);
		}
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["merchandiseweight"])) {
		$merchandiseweight_error = "Weight is required";
		} else {
		$merchandiseweight = test_input($_POST["merchandiseweight"]);
		}
	}	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["merch_height_error"])) {
		$merch_height_error = "height is required";
		} else {
		$merch_height = test_input($_POST["merch_height"]);
		}
	}	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["merch_length"])) {
		$merch_length_error = "Length is required";
		} else {
		$merch_length = test_input($_POST["merch_length"]);
		}
	}if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["merch_width"])) {
		$merch_width_error = "Width is required";
		} else {
		$merch_width = test_input($_POST["merch_width"]);
		}
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if ($merch_height_error == "" and $merch_length_error == "" and $merch_width_error = "" and $merchandisename_error ="" and $merchandiseprice_error = "" and $merchandiseweight_error = ""){
			$response = $itemCreate->createItem($merchandiseprice, $merchandiseweight, $merchandisename, $merch_length, $merch_height, $merch_width);
		}
	}
?>
<?php require_once("header.php"); ?>
<div class="text">Create Storage</div>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<?php if(isset($response->success)):	 ?>
  
  <p><?=$response->success->message;?></p>

  <?php	elseif(isset($response->error)): ?>

  <p><?=$response->error->message;?></p>
  
  <?php	endif; ?>
	
		<p>Item name</p>
		<input class="button" name="merchandisename" type="text" placeholder="Item name" value="<?php echo $merchandisename;?>" >* <?php echo $merchandisename_error;?> 
		<input class="button" name="merchandiseprice" type="number" placeholder="Price" >* <?php echo $merchandiseprice_error;?>
		<input class="button" name="merchandiseweight" type="number" placeholder="Weight" >* <?php echo $merchandiseweight_error;?>
		<input class="button" name="merch_height" type="number" placeholder="Height" >* <?php echo $merch_height_error;?>
		<input class="button" name="merch_length" type="number" placeholder="Length" >* <?php echo $merch_length_error;?>
		<input class="button" name="merch_width" type="number" placeholder="Width" >* <?php echo $merch_width_error;?>
		<br><br>
		<input name="create" type="submit" value="Create Item">
		<br><br>
	</form>	
	<p>
<?php require_once("footer.php"); ?>