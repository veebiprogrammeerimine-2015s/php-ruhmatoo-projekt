<?php
	require_once("functions.php");
	// data.php
	
	// kui kasutaja ei ole sisseloginud,
	// siis suunan tagasi
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
	}
	
	$problem = $date = $animal_kind = $owner_name = $animal_name = "";
	$problem_error = $date_error = $animal_kind_error = $owner_name_error = $animal_name_error = "";
	
?>
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi välja <a> 
</p>

<h2>Registreerimine</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="omaniku_nimi" >Omaniku nimi</label><br>
	<input id="omaniku_nimi" name="omaniku_nimi" type="text" value="<?php echo $owner_name; ?>"> <?php echo $owner_name_error; ?><br><br>
	<label for="looma_nimi" >Looma nimi</label><br>
	<input id="looma_nimi" name="looma_nimi" type="text" value="<?php echo $animal_name; ?>"> <?php echo $animal_name_error; ?><br><br>
	<label for="looma_liik" >Looma liik</label><br>
	<input id="looma_liik" name="looma_liik" type="text" value="<?php echo $animal_kind; ?>"> <?php echo $animal_kind_error; ?><br><br>
	<label for="kuup2ev" >Kuupäev</label><br>
	<input id="kuup2ev" name="kuup2ev" type="date" value="<?php echo $date; ?>"> <?php echo $date_error; ?><br><br>
	<label for="probleem" >Probleemi kirjeldus</label><br>
	<input id="probleem" name="probleem" type="text" value="<?php echo $problem; ?>"> <?php echo $problem_error; ?><br><br>
	<input type="submit" name="register" value="Salvesta">
</form>
