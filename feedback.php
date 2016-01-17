<?php
require_once("header.php");
require_once("postmenu.php");
?>



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




$feedback_name = $feedback_name_error = "";
	
	// et ei ole t�hjad
	// clean input
	// salvestate
	
	if(isset($_POST["create2"])){
		if ( empty($_POST["feedback_name"]) ) {
			$feedback_name_error = "See v�li on kohustuslik";
	}else{
			$feedback_name = cleanInput($_POST["feedback_name"]);
		}
		
		if(	$feedback_name_error == "" ){
			
			// functions.php failis k�ivina funktsiooni
			// msq on message funktsioonist mis tagasi saadame
			$msg4 = createFeedback($feedback_name);
			
			if($msg4 != ""){
				//salvestamine �nnestus
				// teen t�hjaks input value'd
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
