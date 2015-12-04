<?php
  require_once("functions.php");
  
		
		
		
	if (isset($_SESSION))
	{
    unset($_SESSION);
    	session_unset();
    	session_destroy();
	}
	header("Location: login.php");
	var_dump($_SESSION["id_from_db"]);
?>