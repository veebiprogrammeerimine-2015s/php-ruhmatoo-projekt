<?php
//laen funktsiooni faili	
	require_once("../functions.php");
	require_once("../header.php"); 
	
//kontrollin, kas kasutaja ei ole sisseloginud	
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login.php");
	}
	
//login välja	
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}

	
//mängu alustamine	
	$game_name =  $game_name_error =  "";
	
	$park_id = $_GET["id"];
	
	if(isset($_POST["start_new_game"])){
			if ( empty($_POST["game_name"]) ) {
				$game_name_error = "Palun pane mängule nimi!";
			}else{
				$game_name = cleanInput($_POST["game_name"]);
			}
	if(	$game_name_error == ""){
		// functions.php failis käivitan funktsiooni
				$msg = startNewGame ($game_name, $park_id);
				
				if($msg != ""){
					//salvestamine õnnestus
					//suunan 1. korvi lehele
					header("Location: new_game_1.php?k=1");
					
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

<div class="newgame">
<h2>Please, add a name to your game:</h2><br>

<form action="<?php echo htmlspecialchars("new_game_0.php?id=".$park_id);?>" method="post" >
  	<label for="game_name" >Game name: </label> <input id="game_name" name="game_name" type="text" value="<?=$game_name; ?>"> <?=$game_name_error; ?>
	<input id="park_id" name="park_id" type="hidden" value="<?=$park_id; ?>">
	<input type="submit" name="start_new_game" value="Go to play">
  </form>
 </div>