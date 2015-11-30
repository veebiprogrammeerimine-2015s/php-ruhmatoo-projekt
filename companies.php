<?php
	//Lehe nimi
	$page_title = "Muuda töökohti";
	//Faili nimi
	$page_file = "myjobs.php";
?>
<?php
	require_once("header.php"); 
	require_once ("functions.php");
	
	if(!isset($_SESSION['logged_in_user_id'])) {
		header("Location: register.php");
		exit ();
	}
	
	if($_SESSION['logged_in_user_group'] != 3) {
		header("Location: noaccess.php");
		exit ();
	}
?>

<?php require_once("footer.php"); ?>