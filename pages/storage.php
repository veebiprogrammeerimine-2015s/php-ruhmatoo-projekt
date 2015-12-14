<?php
	require_once(__DIR__."/../functions/functions.php");
	require_once(__DIR__."/../classes/storage.class.php");
	$page_title = "Storage";
	$page_file_name = "storage.php";
	$storageCreate = new storageCreate($connection);
?>
<?php
	$storage_name_error = "";
	$storage_address_error = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["storage_name"])) {
		$storage_name_error = "Name is required";
		} else {
		$storage_name = test_input($_POST["storage_name"]);
		}
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["storage_address"])) {
		$storage_address_error = "Address is required";
		} else {
		$storage_address = test_input($_POST["storage_address"]);
		}
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if ($storage_name_error == "" and $storage_address_error == ""){
			$response = $storageCreate->createStorage($storage_name, $storage_address);
		}
	}
?>
<?php require_once(__DIR__."/../header.php"); ?>
<div class="text">Create Storage</div>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<?php if(isset($response->success)):?>
  
  <p><?=$response->success->message;?></p>

  <?php	elseif(isset($response->error)):?>

  <p><?=$response->error->message;?></p>
  
  <?php	endif; ?>
	
		<p>Name</p>
		<input class="button" name="storage_name" type="text" placeholder="example" value="<?php echo $storage_name;?>" >* <?php echo $storage_name_error;?> 
		
		<p>Address</p>
		<input class="button" name="storage_address" type="text" placeholder="Address 101" >* <?php echo $storage_address_error;?>
		<br><br>
		<input name="create" type="submit" value="Create Storage">
		<br><br>
	</form>	
	<p>
<?php require_once(__DIR__."/../footer.php"); ?>