<?php 
	require_once("page/header.php"); 
	require_once("page/functions.php");	
?>
<?php

	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	$user->getCategory($url);
	
	
?>






<?php require_once("page/footer.php"); ?>