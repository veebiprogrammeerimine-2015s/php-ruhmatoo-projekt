<?php
	require_once("functions.php");

	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
	}	
	
		$feedback_name = "";
		$feedback_name_error = "";
		$feedback = "";
		$feedback_error = "";
		$feedback_email = "";
		$feedback_email_error = "";
		
		if(isset($_POST["feedbk"])){


			if ( empty($_POST["fbname"]) ) {
					$feedback_name_error = "See väli on kohustuslik";
				}else{
					$feedback_name = cleanInput($_POST["fbname"]);
				}
			if ( empty($_POST["fbemail"]) ) {
					$feedback_email_error = "See väli on kohustuslik";
				}else{
					$feedback_email = cleanInput($_POST["fbemail"]);
				}
			if ( empty($_POST["feedback"]) ) {
					$feedback_error = "See väli on kohustuslik";
				}else{
					$feedback = cleanInput($_POST["feedback"]);
				}
		}		
		if($feedback_email_error  == "" && $feedback_name_error  == "" && $feedback_error  == ""){

				$message = feedBack($feedback_name, $feedback_email, $feedback);
				
				if($message != ""){
					$feedback_name = "";
					$feedback_email = "";
					$feedback = "";

					echo $message;
					
				}
			}
?>

<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi välja <a> 
</p>

<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">

<h2> Tagasiside</h2>
<p>
Nimi: <input type="text" name="fbname" size="20" value="<?php echo $feedback_name; ?>" /> <?php echo $feedback_name_error; ?>
</p>
<p>
Email:<input type="text" name="fbemail" size="20" value="<?php echo $feedback_email; ?>" /><?php echo $feedback_email_error; ?>
</p>
<br />
<h3 align="left">Kommentaar</h3> 
<p align="left">
<textarea name="feedback" rows="6" cols="30" placeholder="Kuidas loomal läheb?" value="<?php echo $feedback; ?>"> <?php echo $feedback_error; ?></textarea>
</p>
<p align="left">
<input type="submit" name ="feedbk" value="Anna tagasiside" />
</p>
</form>