<?php
require_once("header.php");
require_once("postmenu.php");
?>



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




$feedback_name = $feedback_name_error = "";
	
	// et ei ole tühjad
	// clean input
	// salvestate
	
	if(isset($_POST["create2"])){
		if ( empty($_POST["feedback_name"]) ) {
			$feedback_name_error = "See väli on kohustuslik";
	}else{
			$feedback_name = cleanInput($_POST["feedback_name"]);
		}
		
		if(	$feedback_name_error == "" ){
			
			// functions.php failis käivina funktsiooni
			// msq on message funktsioonist mis tagasi saadame
			$msg4 = createFeedback($feedback_name);
			
			if($msg4 != ""){
				//salvestamine õnnestus
				// teen tühjaks input value'd
				$feedback_name = "";
								
				echo $msg4;
				
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



   <h2>Lisa tagasisidet</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<link rel="stylesheet" href="kujundus.css" type="text/css" /> 
	<label for="feedback_name" >Tagasiside</label><br>
	<input id="feedback_name" name="feedback_name" type="text" value="<?=$feedback_name; ?>"> <?=$feedback_name_error; ?><br><br>
    <input type="submit" class = "button12" name="create2" value="Salvesta">
 </form>
 
 <?php require_once("feedback_table.php");  ?>
 
    <?php  require_once("foother.php");?>
