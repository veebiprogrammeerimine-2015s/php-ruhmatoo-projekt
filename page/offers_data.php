<?php
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
	
	$price = $comment = "";
	$price_error = $comment_error = "";
	
	if($_SERVER["REQUEST_METHOD"] == "GET"){
		
		if(isSet($_GET["add_new_offer"])){
			
			if(empty($_GET["price"])){
				$price_error = "Hind on kohustuslik";
			}else{
				$price = cleanInput($_GET["price"]);
			}
			
			if(empty($_GET["comment"])){
				$comment_error = "Kommentaar on kohustuslik";
			}else{
				$comment = cleanInput($_GET["comment"]);
			}
			
			if($price_error == "" && $comment_error == ""){
				$OfferManager->addNewOffer($_GET["offers_data_id"], $_SESSION["logged_in_user_id"], $price, $comment);
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

Kasutaja: <?=$_SESSION['logged_in_user_id'];?> <a href="?logout=1" style="text-decoration:none">[logi välja]</a>

<h2>Pakkumise tegemine</h2>

<form action="offers_data.php" method="get">
	<input type="hidden" name="request_id" value="<?=$_GET["offers_data_id"];?>">
	<input name="price" type="number" placeholder="Hind" value="<?=$price;?>">* <?=$price_error;?><br><br>
	<textarea style="resize:none" name="comment" rows="10" cols="28" placeholder="Kommentaar"><?=$comment;?></textarea>* <?=$comment_error;?><br><br>
	<input name="add_new_offer" type="submit" value="Tee pakkumine">
</form>