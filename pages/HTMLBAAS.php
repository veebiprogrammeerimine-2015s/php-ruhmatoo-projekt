<?php
	require_once(__DIR__."/../functions/functions.php");
	require_once(__DIR__."/../classes/*.class.php");
	$page_title = "";
	$page_file_name = "";
	if(isset($_GET["logout"])){
        session_destroy();
        header("Location: /../index.php");
    }

?>

<?php require_once(__ROOT__"/header.php");?>
    //**********//
    //***HTML***//
    //**********//
	
	
	

<?php require_once(__ROOT__"/footer.php"); ?>
