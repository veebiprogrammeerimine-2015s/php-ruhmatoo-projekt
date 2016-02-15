<?php
	require_once("functions.php");
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
		exit();
	}

	$first_name = "";
	$surname = "";
	$country = "";
	
	$modify_fname = "";
	$modify_sname = "";
	$modify_country = "";
	

	if(isset($_POST["submit_modify"])){
				if ( empty($_POST["submit_modify"]) ) {
					echo "Test";
				}else{
					$modify_fname = cleanInput($_POST["Firstname"]);
				}
				if ( empty($_POST["submit_modify"]) ) {
					echo "Test2";
				}else{
					$modify_sname = cleanInput($_POST["Surname"]);
				}
				if ( empty($_POST["submit_modify"]) ) {
					echo "Test3";
				} else {
					$modify_country = cleanInput($_POST["Country"]);
					}
				}

				$create_response = $User->modifyUser($modify_fname, $modify_sname, $modify_country);
					
				
		
?>
<?php if(isset($_SESSION["login_success_message"])): ?>
	
	<p style="color:green;" >
		<?=$_SESSION["login_success_message"];?>
	</p>

<?php 
	//kustutan selle sõnumi pärast esimest näitamist
	unset($_SESSION["login_success_message"]);
	
	endif; ?>
<form>
<h2> Name </h2>
	<input name="Firstname "placeholder="Firstname" value="<?php echo $modify_fname; ?>">
<h2> Surname </h2>
	<input name="Surname "placeholder="Surname " value="<?php echo $modify_sname; ?>">
<h2> Country </h2>
	<input name="Country "placeholder="Country" value="<?php echo $modify_country; ?>">
	<br><br><br>
	<input type="submit" name="submit_modify" value="Submit">
</form>