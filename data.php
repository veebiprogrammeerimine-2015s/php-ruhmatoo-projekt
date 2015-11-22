<?php
	require_once("functions.php");
	// data.php
	
	// kui kasutaja ei ole sisseloginud,
	// siis suunan tagasi
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
	}
	
	$problem = "";
	$date = "";
	$animal_kind = "";
	$owner_name = "";
	$animal_name = "";
	$problem_error = "";
	$date_error = "";
	$animal_kind_error = "";
	$owner_name_error = "";
	$animal_name_error = "";
	
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}
	
	if(isset($_POST["register"])){


		if ( empty($_POST["owner_name"]) ) {
				$owner_name_error = "See väli on kohustuslik";
			}else{
				$owner_name = cleanInput($_POST["owner_name"]);
			}
		if ( empty($_POST["animal_name"]) ) {
				$animal_name_error = "See väli on kohustuslik";
			}else{
				$animal_name = cleanInput($_POST["animal_name"]);
			}
		if ( empty($_POST["animal_kind"]) ) {
				$animal_kind_error = "See väli on kohustuslik";
			}else{
				$animal_kind = cleanInput($_POST["animal_kind"]);
			}
		if ( empty($_POST["date"]) ) {
				$date_error = "See väli on kohustuslik";
			}else{
				$date = cleanInput($_POST["date"]);
			}
		if ( empty($_POST["problem"]) ) {
				$problem_error = "See väli on kohustuslik";
			}else{
				$problem = cleanInput($_POST["problem"]);
			}
			
		if($problem_error && $date_error && $animal_kind_error && $owner_name_error && $animal_name_error == ""){

				$message = registerAnimal($owner_name, $animal_name, $animal_kind, $date, $problem);
				
				if($message != ""){
					// õnnestus, teeme inputi väljad tühjaks
					$problem = "";
					$date = "";
					$animal_kind = "";
					$owner_name = "";
					$animal_name = "";
					
					echo $message;
					
				}
			}
	}
?>
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi välja <a> 
</p>

<h2>Registreerimine</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="owner_name" >Omaniku nimi</label><br>
	<input id="owner_name" name="owner_name" type="text" value="<?php echo $owner_name; ?>"> <?php echo $owner_name_error; ?><br><br>
	<label for="animal_name" >Looma nimi</label><br>
	<input id="animal_name" name="animal_name" type="text" value="<?php echo $animal_name; ?>"> <?php echo $animal_name_error; ?><br><br>
	<label for="animal_kind" >Looma liik</label><br>
	<input id="animal_kind" name="animal_kind" type="text" value="<?php echo $animal_kind; ?>"> <?php echo $animal_kind_error; ?><br><br>
	<label for="date" >Kuupäev</label><br>
	<input id="date" name="date" type="date" value="<?php echo $date; ?>"> <?php echo $date_error; ?><br><br>
	<label for="problem" >problemi kirjeldus</label><br>
	<input id="problem" name="problem" type="text" value="<?php echo $problem; ?>"> <?php echo $problem_error; ?><br><br>
	<input type="submit" name="register" value="Salvesta">
</form>
