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
	
	$post_name = $post_done = $post_name_error = "";
	
	// et ei ole tühjad
	// clean input
	// salvestate
	
	if(isset($_POST["post"])){
		if ( empty($_POST["post_name"]) ) {
			$post_name_error = "See väli on kohustuslik";
		}else{
			$post_name = cleanInput($_POST["post_name"]);
		}
		if ( empty($_POST["post_done"]) ) {
			$post_done = "";
		} else {
			$post_done = cleanInput($_POST["post_done"]);
		}
		if(	$post_name_error == "" ){
			
			// functions.php failis käivina funktsiooni
			// msq on message funktsioonist mis tagasi saadame
			$msg = createPost($post_name, $post_done);
			
			if($msg != ""){
				//salvestamine õnnestus
				// teen tühjaks input value'd
				$post_name = "";
				$post_done = "";
								
				echo $msg;
				
			}
			
		}
    } // create if end
	
	//function cleanInput($data) {
		//$data = trim($data);
		//$data = stripslashes($data);
		//$data = htmlspecialchars($data);
		//return $data;
	//}
	
	

	//võttame bd
	$result=mysql_query("SELECT * FROM  post_tech");
	//Если в базе данных есть записи, формируем массив
	
	echo $result;
    

	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }
?>

<p>
	Tere, <?=$_SESSION["email_from_db"];?> sinu id on (<?=$_SESSION["id_from_db"];?>) 
	<a href="?logout=1"> Logi välja</a>
</p>

  
 <h2>Lisa postitusi</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="post_name" >Postitis</label><br>
	<input id="post_name" name="post_name" type="text" value="<?=$post_name; ?>"> <?=$post_name_error; ?><br><br>
  	<label>Lisa</label><br>
	<input name="post_done" type="text" value="<?=$post_done; ?>"> <?=$post_done; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>