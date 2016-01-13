
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
	<div style="text-align: center;">Vabandame, leht on uuendamisel :( </div>
</h1>
<div style="text-align: center;">
<img class="center" src="pildid/dreamteam.jpg"alt="sveg"style="width:600px;height:400px;"></img> </div>