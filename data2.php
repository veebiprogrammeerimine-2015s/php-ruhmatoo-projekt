<?php
	// siia lisame auto nr margite vormi
	//laeme funktsiooni failis
	require_once("function2.php");
	
	//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["administrator_id_from_db"])){
		// suunan login lehele
		header("Location: home.php");
	}
	
	
	//login valja, aadressireal on ?logout=1
	if(isset($_GET["logout"])){
		//kustutab koik sessiooni muutujad
		session_destroy();
		
		header("Location: home.php");
		
	}
	
	
	$post_name = $post_done = $post_name_error = "";
	
	// et ei ole tuhjad
	// clean input
	// salvestate
	
	if(isset($_POST["create"])){
		if ( empty($_POST["post_name"]) ) {
			$post_name_error = "See vali on kohustuslik";
		}else{
			$post_name = cleanInput($_POST["post_name"]);
		}
		if ( empty($_POST["post_done"]) ) {
			$post_done = "";
		} else {
			$post_done = cleanInput($_POST["post_done"]);
		}
		if(	$post_name_error == "" ){
			
			// functions.php failis kaivina funktsiooni
			// msq on message funktsioonist mis tagasi saadame
			$msg = createPost($post_name, $post_done);
			
			if($msg != ""){
				//salvestamine onnestus
				// teen tuhjaks input value'd
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
	
	
	$comment_name = $comment_name_error = "";
	
	// et ei ole tuhjad
	// clean input
	// salvestate
	
	if(isset($_POST["create"])){
		if ( empty($_POST["comment_name"]) ) {
			$comment_name_error = "See vali on kohustuslik";
		}else{
			$comment_name = cleanInput($_POST["comment_name"]);
		}
		
		if(	$comment_name_error == "" ){
			
			// functions.php failis kaivina funktsiooni
			// msq on message funktsioonist mis tagasi saadame
			$msg5 = createFeedback($feedback_name);
			
			if($msg5 != ""){
				//salvestamine onnestus
				// teen tuhjaks input value'd
				$comment_name = "";
								
				echo $msg5;
				
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
	
	
	 <h2>Lisa postitusi</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="post_name" >Postitis</label><br>
	<input id="post_name" name="post_name" type="text" value="<?=$post_name; ?>"> <?=$post_name_error; ?><br><br>
  	<label>Lisa</label><br>
	<input name="post_done" type="text" value="<?=$post_done; ?>"> <?=$post_done; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>
	

	
	      <h2>Lisa kommentaare</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="comment_name" >Kommentaar</label><br>
	<input id="comment_name" name="comment_name" type="text" value="<?=$comment_name; ?>"> <?=$comment_name_error; ?><br><br>
    <input type="submit" name="create" value="Salvesta">
  </form>