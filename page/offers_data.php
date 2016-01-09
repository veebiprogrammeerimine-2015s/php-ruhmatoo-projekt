<?php
	require_once("functions.php");
	require_once("OfferManager.class.php");
	require_once("header.php");
	
	$OfferManager = new OfferManager($mysqli, $_SESSION["logged_in_user_id"]);
		
	if($_SESSION["logged_in_user_group_id"] == "3"){
		header("Location: requests.php");
	}
	
	if(!isset($_GET["offers_data_id"])){
		header("Location: requests.php");
	}
	
	$price = $comment = "";
	$price_error = $comment_error = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if(isSet($_POST["add_new_offer"])){
			
			if(empty($_POST["price"])){
				$price_error = "Hind on kohustuslik";
			}else{
				$price = cleanInput($_POST["price"]);
			}
			
			if(empty($_POST["comment"])){
				$comment_error = "Kommentaar on kohustuslik";
			}else{
				$comment = cleanInput($_POST["comment"]);
			}
			
			if($price_error == "" && $comment_error == ""){
				$OfferManager->addNewOffer($_POST["request_id"], $_SESSION["logged_in_user_id"], $price, $comment);
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

<h2>Pakkumise tegemine</h2>

<form action="<?php echo htmlspecialchars("offers_data.php?offers_data_id=".$_GET["offers_data_id"]); ?>" method="post">
	<input type="hidden" name="request_id" value="<?=$_GET["offers_data_id"];?>">
	<input name="price" type="number" placeholder="Hind" value="<?=$price;?>">* <?=$price_error;?><br><br>
	<textarea style="resize:none" name="comment" rows="10" cols="28" placeholder="Kommentaar"><?=$comment;?></textarea>* <?=$comment_error;?><br><br>
	<input name="add_new_offer" type="submit" value="Tee pakkumine">
</form>