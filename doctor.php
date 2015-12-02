<?php
	require_once("functions.php");
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
	}
	
	
		$doctor_name = "";
		$procedure_name = "";
		$operation_name = "";
		$operation_date = "";
		$operation_difficulty = "";
		$animal_name = "";
		$doctor_name_error = "";
		$procedure_name_error = "";
		$operation_name_error = "";
		$operation_date_error = "";
		$operation_difficulty_error = "";
		$d_animal_name_error = "";
	
	

			
		if($doctor_name_error  == "" && $operation_name_error  == "" && $operation_date_error  == "" && $operation_difficulty_error  == "" && $d_animal_name_error == "" && $procedure_name_error == ""){

				$message = doctorView($doctor_name, $procedure_name, $operation_name, $operation_date, $operation_difficulty, $d_animal_name);
				
				if($message != ""){
					// õnnestus, teeme inputi väljad tühjaks
					$doctor_name = "";
					$operation_date = "";
					$procedure_name = "";
					$operation_name = "";
					$operation_difficulty = "";
					$d_animal_name = "";
					
					echo $message;
					
				}
			}
	}
	
	
	
	
	
	
	
	
	
?>

<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi välja <a> 
</p>

<h2>Arsti vaade</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="doctor_name" >Arsti nimi</label><br>
	<input id="doctor_name" name="doctor_name" type="text" value="<?php echo $doctor_name; ?>"> <?php echo $doctor_name_error; ?><br><br>
	<label for="animal_name" >Protseduuri nimetus</label><br>
	<input id="procedure_name" name="procedure_name" type="text" value="<?php echo $procedure_name; ?>"> <?php echo $procedure_name_error; ?><br><br>
	<label for="operation_name" >Operatsiooni nimetus</label><br>
	<input id="operation_name" name="operation_name" type="text" value="<?php echo $operation_name; ?>"> <?php echo $operation_name_error; ?><br><br>
	<label for="date" >Operatsiooni kuupäev</label><br>
	<input id="date" name="operation_date" type="date" value="<?php echo $operation_date; ?>"> <?php echo $operation_date_error; ?><br><br>
	<label for="operation_difficulty" >Operatsiooni raskustase</label><br>
	<input id="operation_difficulty" name="operation_difficulty" type="text" value="<?php echo $operation_difficulty; ?>"> <?php echo $operation_difficulty_error; ?><br><br>
	<label for="animal_name" >Looma nimi</label><br>
	<input id="d_animal_name" name="d_animal_name" type="text" value="<?php echo $d_animal_name; ?>"> <?php echo $d_animal_name_error; ?><br><br>
	<input type="submit" name="register" value="Salvesta">
</form>
