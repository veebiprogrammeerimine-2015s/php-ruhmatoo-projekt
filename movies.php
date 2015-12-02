<?php require_once("page/header.php"); ?>

<?php

	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	if (strpos($url,'Cat_') !== false) {
		echo 'töötab';
	}
	
	
?>






<?php require_once("page/footer.php"); ?>