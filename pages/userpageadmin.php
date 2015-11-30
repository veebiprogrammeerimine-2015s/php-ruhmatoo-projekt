<?php
	require_once(__DIR__."/../functions/functions.php");
	require_once(__DIR__."/../classes/userpage.class.php");
	$page_title = "Admin kasutaja";
	$page_file_name = "userpageadmin.php";
	if(isset($_GET["logout"])){
        session_destroy();
        header("Location:".__DIR__."/../index.php");
    }
	$userEditAdmin = new userEditAdmin($connection);

?>

<?php
	$userfirstname_error = "";
	$userlastname_error = "";
	$useraddress_error = "";
	if (isset($_POST["change_user"])) {
		unset($_SESSION['selectusername']);
	}
	if (isset($_POST["userfirstname"])) {
		if (empty($_POST["userfirstname"])) {
			$userfirstname_error = "First name is required";
		} else {
			$userfirstname = test_input($_POST["userfirstname"]);
		}
	}
	if (isset($_POST["userlastname"])) {
		if (empty($_POST["userlastname"])) {
			$userlastname_error = "Last name is required";
		} else {
			$userlastname = test_input($_POST["userlastname"]);
		}
	}
	if (isset($_POST["useraddress"])) {
		if (empty($_POST["useraddress"])) {
			$useraddress_error = "Address required";
		} else {
			$useraddress = test_input($_POST["useraddress"]);
		}
	}
	if(isset($_POST["selectusername"])){
		if (empty($_POST["selectusername"])) {
			$selectusername_error = 'Username is required';
		} else {
			$_SESSION['selectusername'] = test_input($_POST["selectusername"]);
			$selectusername = test_input($_POST["selectusername"]);
		}
	}
	if(isset($_POST["selectusername"])){
			$response = $userEditAdmin->readUserAdmin($selectusername);
			
			
			$userfirstname = $response->user->userfirstname;
			$userlastname = $response->user->userlastname;
			$useraddress = $response->user->useraddress;
			$creationdate = $response->user->creationdate;
			$privileges = $response->user->privileges;
			$userusername = $response->user->username;
			
			
			
		}
	if(isset($_POST["change"])){
		if ($userfirstname_error == "" and $userlastname_error == "" and $useraddress_error==""){
			$response = $userEditAdmin->editUserAdmin($userfirstname, $userlastname, $useraddress, $creationdate, $privileges, $selectusername);
			
		}
	}




?>

<?php require_once(__DIR__."/../header.php"); ?>
<div class="container-fluid">
<div class="row">
<div class="col-sm-3">
<h2 class="text">Kasutaja muutmine</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<?php if(isset($response->success)):	 ?>
  
  <p><?=$response->success->message;?></p>

  <?php	elseif(isset($response->error)): ?>

  <p><?=$response->error->message;?></p>
  
  <?php	endif; ?>
		
		
		<?php 
		if(isset($userusername)){
			echo "<label>Kasutaja on: ".$_SESSION['selectusername']."</label> <br>";
			echo '<button type="submit" name="change_user" class="btn btn-info btn-block ">Muuda kasutajat</button>';

			echo '<label>Eesnimi</label>';
			echo '<input class="form-control" name="userfirstname" type="text" placeholder="First name" value="'.$userfirstname.'"  > '; echo $userfirstname_error;
			echo '<br><label>Perekonnanimi</label><br>';
			echo '<input class="form-control" name="userlastname" type="text" placeholder="Last name" value="'.$userlastname.'" > '; echo $userlastname_error;
			echo '<br><label>Address</label><br>';
			echo '<input class="form-control" name="useraddress" type="text" placeholder="Address" value="'.$useraddress.'">'; echo $useraddress_error;
			echo '<br><button type="submit" name="change" class="btn btn-info btn-block">Sisesta</button>';
		}else{
			echo '<input class="form-control" name="selectusername" type="text" placeholder="Kasutajanimi"  >* '; echo $selectusername_error;
			echo '<button type="submit" name="select" class="btn btn-info btn-block ">Vali</button>';
		}
		
		?>
		
		
		
		
		
	</form>	

</div>
</div>
</div>
<?php require_once(__DIR__."/../footer.php"); ?>