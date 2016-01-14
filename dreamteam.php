
<?php require_once("functions.php") ?>
<?php require_once("header.php") ?>
<?php require_once("footer.php"); ?>
<?php if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	?>

<h1>
	<div style="text-align: center;"></div>
</h1>
<div style="text-align: center;">
    <p><a href="dreamteam_add.php" class="btn btn-primary" role="button">Loo endale enda dreamteam</a></p>
    
