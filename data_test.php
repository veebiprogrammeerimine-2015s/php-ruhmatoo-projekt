<?php
	// siia lisame auto nr m�rgite vormi
	//laeme funktsiooni failis
	require_once("function.php");
	
	//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		// suunan login lehele
		header("Location: home.php");
	echo "on vaja registreerida ikka!";
	}
	
	//login v�lja, aadressireal on ?logout=1
	if(isset($_GET["logout"])){
		//kustutab k�ik sessiooni muutujad
		session_destroy();
		
		header("Location: home.php");
	
	}
	
	$car_plate = $color = $car_plate_error = $color_error = "";
	
	// et ei ole t�hjad
	// clean input
	// salvestate
	
	if(isset($_POST["create"])){
		if ( empty($_POST["car_plate"]) ) {
			$car_plate_error = "See v�li on kohustuslik";
		}else{
			$car_plate = cleanInput($_POST["car_plate"]);
		}
		if ( empty($_POST["color"]) ) {
			$color_error = "See v�li on kohustuslik";
		} else {
			$color = cleanInput($_POST["color"]);
		}
		if(	$car_plate_error == "" && $color_error == ""){
			
			// functions.php failis k�ivina funktsiooni
			// msq on message funktsioonist mis tagasi saadame
			$msg = createCarPlate($car_plate, $color);
			
			if($msg != ""){
				//salvestamine �nnestus
				// teen t�hjaks input value'd
				$car_plate = "";
				$color = "";
								
				echo $msg;
				
			}
			
		}
    } // create if end
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }
	
	
	
?>

<p>
	Tere, <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi v�lja</a>
</p>

 <h2>Lisa auto</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="car_plate" >auto nr</label><br>
	<input id="car_plate" name="car_plate" type="text" value="<?=$car_plate; ?>"> <?=$car_plate_error; ?><br><br>
  	<label>v�rv</label><br>
	<input name="color" type="text" value="<?=$color; ?>"> <?=$color_error; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>