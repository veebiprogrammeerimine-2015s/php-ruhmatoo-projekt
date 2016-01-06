
<?php

	$comment_error = "";
	$comment = "";

	if($_SERVER["REQUEST_METHOD"] == "POST") {
			if(isset($_POST["saada"])){
			if (empty($_POST["comment"]) ) {
				$comment_error = "See väli on kohustuslik";
			}else{
				$comment = cleanInput($_POST["comment"]);
			}


			if ($comment_error == "") {
				$response = $Rate->newComment($trimmed, $_SESSION['logged_in_user_id'], $comment);
			}
		}
	}

?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<label for="comment">Kommenteeri</label>
	<textarea name="comment" rows="4" cols="75" class="form-control"></textarea>
	<br>
	<button type="submit" class="btn btn-success pull-right" name="saada">Saada</button>
</form>
