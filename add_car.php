 <?php

	$page_title = "Auto lisamise leht";
	$file_name = "add_car.php";
	
?>
 
 <?php
	
	require_once("../configglobal.php");
	$database = "if15_kertkulp";
	
	//Laeme funktsiooni failis
	require_once("functions.php");
	
	//kontrollin, kas kasutaja on sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login.php");
		
	}
	
	//Login välja kui aadressi real on ?logout=1
	if(isset($_GET["logout"])){
		session_destroy();
		
		header("Location: login.php");
	}
	
	$car_model = $car_make = $color = $car_model_error = $car_make_error = $color_error = "";
	
	if(isset($_POST["create"])){

			if ( empty($_POST["car_model"]) ) {
				$car_model_error = "See väli on kohustuslik";
			}else{
				$car_model = cleanInput($_POST["car_model"]);
			}
			
			if ( empty($_POST["car_make"]) ) {
				$car_make_error = "See väli on kohustuslik";
			}else{
				$car_model = cleanInput($_POST["car_make"]);
			}
			
			if ( empty($_POST["color"]) ) {
				$color_error = "See väli on kohustuslik";
			} else {
				$color = cleanInput($_POST["color"]);
			}
			if($color_error == "" && $car_model_error == "" && $car_make_error == ""){
				echo "Numbrimärk on ".$car_model." ja värv on ".$color;
				
				$msg = createCar($car_model, $car_make, $color);
				
				if($msg != ""){
					$car_model = "";
					$car_make = "";
					$color = "";
					
					echo $msg;
				}
			}
	}

			

	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	
 ?>
 
 <p>
	Tere, <?=$_SESSION["user_email"]; ?>
	<a href = logout.php>Log out</A>
</p>

<h2>Lisa auto</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="car_model" >Auto mark</label><br>
	<input id="car_model" name="car_model" type="text" value="<?=$car_model; ?>"> <?=$car_model_error; ?><br><br>
	<label for="car_make" >Auto mudel</label><br>
	<input id="car_make" name="car_make" type="text" value="<?=$car_make; ?>"> <?=$car_make_error; ?><br><br>
  	<label for="color" >värv</label><br>
	<input id="color" name="color" type="text" value="<?=$color; ?>"> <?=$color_error; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>