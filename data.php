<?php
	// siia lisame auto nr märgite vormi
	//laeme funktsiooni failis
	require_once("function.php");
	
	//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		// suunan login lehele
		header("Location: home.php");
	echo "on vaja registreerida ikka!";
	}
	
	//login välja, aadressireal on ?logout=1
	if(isset($_GET["logout"])){
		//kustutab kõik sessiooni muutujad
		session_destroy();
		
		header("Location: home.php");
	
	}
	
	$post_tech = $post_tech_error = "";
	
	// et ei ole tühjad
	// clean input
	// salvestate
	
	if(isset($_POST["create"])){
		if ( empty($_POST["post_tech"]) ) {
			$post_tech_error = "See väli on kohustuslik";
		}else{
			$post_tech = cleanInput($_POST["post_tech"]);
		}
		if(	$post_tech_error == "" ){
			
			// functions.php failis käivina funktsiooni
			// msq on message funktsioonist mis tagasi saadame
			$msg = createCarPlate($post_tech, $id_from_db);
			
			if($msg != ""){
				//salvestamine õnnestus
				// teen tühjaks input value'd
				$post_tech = "";
								
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
	Tere, <?=$_SESSION["id_from_db"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

 <h2>Lisa auto</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="car_plate" >auto nr</label><br>
	<input id="car_plate" name="car_plate" type="text" value="<?=$car_plate; ?>"> <?=$car_plate_error; ?><br><br>
  	<label>värv</label><br>
	<input name="color" type="text" value="<?=$color; ?>"> <?=$color_error; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>