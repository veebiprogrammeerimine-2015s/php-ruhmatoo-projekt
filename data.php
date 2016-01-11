

<h2 class ="pealkiri2">Nuud hakkame!</h2>
<body> 
<link rel="stylesheet" href="kujundus.css" type="text/css" /> 
Siin sa võid lisada sinu post, kus sa võiks kirjeldada oma probleem!<br><br>

<body/> 

<?php require_once("postmenu.php");?>

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
			$msg = createPost($post_tech, $_SESSION["id_from_db"]);
			
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


<html>
<p>
	<?=$_SESSION["email_from_db"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

 <h2>Lisa post</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="post_tech" >Posti nime</label><br>
	<input id="post_tech" name="post_tech" type="text" value="<?=$post_tech; ?>"> <?=$post_tech_error; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>
</html>

 <?php
	require_once("header.php");
?>
<?php require_once("foother.php");?>

