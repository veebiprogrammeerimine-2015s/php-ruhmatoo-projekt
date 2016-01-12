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
//tulemuse salvestamine	
	$result = $result_error = "";
	
	if(isset($_POST["save"])){
			if ( empty($_POST["result"]) ) {
				$result_error = "Palun sisesta tulemus";
			}else{
				$result = cleanInput($_POST["result"]);
			}
			
	if(	$result_error == ""){
				

				$msg = saveResult($_GET["k"],$result);
				
				if($msg != ""){
					
					if($_GET["k"] == $_SESSION["nr_of_baskets"]){
						header("Location: new_game_final.php");
						var_dump($_GET["k"]);
						exit();
					}
					$k = $_GET["k"]+1;
					header("Location: new_game_1.php?k=".$k);
						
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

<div class="newgame1">
<h1>You are playing at: <?php echo $_SESSION["park_name"]; ?></h1>
<h2><?=$_GET["k"];?>. basket</h2>
	<form action="new_game_1.php?k=<?php echo $_GET["k"]; ?>" method="post" >
		<label for="result" >Your result</label>
		<input id="result" name="result" type="number" value="<?=$result; ?>"> <?=$result_error; ?><br><br>
		<input type="submit" name="save" value="Save">
	</form>
</div>
	