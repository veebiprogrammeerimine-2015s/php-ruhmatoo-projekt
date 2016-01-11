<?php
	require_once("functions.php");
	require_once("OfferManager.class.php");
	require_once("header.php");
	
	$OfferManager = new OfferManager($mysqli, $_SESSION["logged_in_user_id"]);
	
	if(!isSet($_GET["offer_id"])){
		header("Location: offers.php");
	}
	
	$feedback = "";
	$feedback_error = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if(isSet($_POST["add_new_feedback"])){
			
			if(empty($_POST["feedback"])){
				$feedback_error = "Palun sisesta tagasiside";
			}else{
				$feedback = cleanInput($_POST["feedback"]);
			}
			
					
			if($feedback_error == ""){
				$OfferManager->addNewFeedback($_SESSION['logged_in_user_id'], $_POST["to_user_id"], $_POST["offer_id"], $feedback);
				header("Location: requests.php");  
			}
		}
	}
	
	function cleanInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
	}

?>

<h3>Tagasiside</h3>

<form action="<?php echo htmlspecialchars("feedback_data.php?offer_id=".$_GET["offer_id"]."&to_user_id=".$_GET["to_user_id"]); ?>" method="post">
	<input type="hidden" name="offer_id" value="<?=$_GET["offer_id"];?>">
	<input type="hidden" name="to_user_id" value="<?=$_GET["to_user_id"];?>">
	<textarea style="resize:none" name="feedback" rows="10" cols="28" placeholder="Tagasiside"><?=$feedback;?></textarea>* <?=$feedback_error;?><br><br>
	<input name="add_new_feedback" type="submit" value="Anna tagasisidet">
</form>