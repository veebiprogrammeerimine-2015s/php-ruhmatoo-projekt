<?php
	require_once("functions.php");
	$page_title = "avaleht";
	$page_file_name = "index.php";
if(isset($_GET["logout"])){
        session_destroy();
        header("Location: index.php");
    }
if(isset($_SESSION['logged_in_user_id'])){
		echo "Tere, ",$_SESSION['logged_in_user_email'], "<a href='?logout=1'> Logi välja</a>";

	}

?>

<?php require_once("header.php"); ?>
<h1> Tere </h1>

<?php require_once("footer.php"); ?>
