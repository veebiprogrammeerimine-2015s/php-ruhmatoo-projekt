<?php
	
	/* Hetkel on selline jama, et kuna funktsioon "addNewFeedback" võtab informatsiooni aadressirealt ($_GET) (rida 37),
	siis juhul, kui seda aadressiriba uuendada (nt inimene sisestab andmeid valesti), siis need $_GET väärtused (mis saadakse
	ridadelt 58 ja 59) kaovad ju ära ja seega ei saa seda kõike andmebaasi salvestada.

	Täpselt sama jama on ka offers_data.php puhul*/
	
	
	require_once("functions.php");
	require_once("OfferManager.class.php");
	
	$OfferManager = new OfferManager($mysqli, $_SESSION["logged_in_user_id"]);
	
	if(!isSet($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}

	if(isSet($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
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

Kasutaja: <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1" style="text-decoration:none">[logi välja]</a>

<h2>Tagasiside</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<input type="hidden" name="offer_id" value="<?=$_GET["offer_id"];?>">
	<input type="hidden" name="to_user_id" value="<?=$_GET["to_user_id"];?>">
	<textarea style="resize:none" name="feedback" rows="10" cols="28" placeholder="Tagasiside"><?=$feedback;?></textarea>* <?=$feedback_error;?><br><br>
	<input name="add_new_feedback" type="submit" value="Anna tagasisidet">
</form>