<?php
	require_once("functions.php");
	$page_title = "User edit";
	$page_file_name = "userpage.php";
	
	
?>
<?php
	require_once("functions.php");
	$page_title = "Kasutaja muutmine";
	$page_file_name = "userpage.php";
	$userfirstname_error = "";
	$userlastname_error = "";
	$useraddress_error = "";
	$_POST["userusername"] = $_SESSION["logged_in_user_id"];
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["userfirstname"])) {
		$userfirstname_error = "FirstName is required";
		} else {
		$userfirstname = test_input($_POST["userfirstname"]);
		}

		if (empty($_POST["userlastname"])) {
		$userlastname_error = "LastName is required";
		} else {
		$userlastname = test_input($_POST["userlastname"]);
		}

		if (empty($_POST["useraddress"])) {
		$useraddress_error = "Address required";
		} else {
		$useraddress = test_input($_POST["useraddress"]);
		}

		$userusername = $_SESSION['logged_in_user_id'];
	
		if ($userfirstname_error == "" and $userlastname_error == "" and $useraddress_error==""){
			$response = $userEdit->editUser($userfirstname, $userlastname, $useraddress);
		
		}
	}
	

?>

<?php require_once("header.php"); ?>

<div class="text">Kasutaja muutmine</div>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<?php if(isset($response->success)):	 ?>
  
  <p><?=$response->success->message;?></p>

  <?php	elseif(isset($response->error)): ?>

  <p><?=$response->error->message;?></p>
  
  <?php	endif; ?>
	
		<p>Eesnimi</p>
		<input class="text" name="userfirstname" type="text" placeholder="Eesnimi"  >*<?php echo $userfirstname_error;?>
		<p>Perekonnanimi</p>
		<input class="text" name="userlastname" type="text" placeholder="Perekonnanimi" >* <?php echo $userlastname_error;?> 
		<p>Address</p>
		<input class="text" name="useraddress" type="text" placeholder="Address">* <?php echo $useraddress_error;?> 
		<input name="edit" type="submit" value="User Editing">
		<br><br>
	</form>	



<?php require_once("footer.php"); ?>