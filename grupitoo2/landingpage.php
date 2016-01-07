<?php
require_once("header.php");
	$page_title = "Arvustuse sisestamine";
	$file_name = "landingpage.php";
?>


<?php
	require_once("functions.php");

	if(!isset($_SESSION["id_from_db"])){
		header("Location: login.php");		
	}	
	
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: home.php");
	}
?>



<html lang="et">
	<head>
		<meta charset="utf-8">
		<title>Kriitiku leht</title>
	</head>	
	<body>
		<p>
			Tere, <?php echo $_SESSION["user_email"]; ?> 
		</p>
		<p>
			<a href="?logout=1">Logi välja</a>
		</p>


<?php
	$bar = "";
	$bar_error = "";
	$cocktails = "";
	$cocktails_error = "";
	$service = "";
	$service_error = "";
	$interior = "";
	$interior_error = "";
	$prices = "";
	$prices_error = "";
	$score = "";
	$score_error = "";
	$info = "";
	$info_error = "";
	
	
	if(isset($_POST["create"])){
		if ( empty($_POST["bar"])) {
			$bar_error = "See väli on kohustuslik";
		}else{
			$bar = cleanInput($_POST["bar"]);
		}
		if ( empty($_POST["cocktails"])) {
			$cocktails_error = "See väli on kohustuslik";
		}else{
			$cocktails = cleanInput($_POST["cocktails"]);
		}
		if ( empty($_POST["service"])) {
			$service_error = "See väli on kohustuslik";
		}else{
			$service = cleanInput($_POST["service"]);
		}
		if ( empty($_POST["interior"])) {
			$interior_error = "See väli on kohustuslik";
		}else{
			$interior = cleanInput($_POST["interior"]);
		}
		if ( empty($_POST["prices"])) {
			$prices_error = "See väli on kohustuslik";
		}else{
			$prices = cleanInput($_POST["prices"]);
		}
		if ( empty($_POST["score"])) {
			$score_error = "See väli on kohustuslik";
		}else{
			$score = cleanInput($_POST["score"]);
		}
		if ( empty($_POST["info"])) {
			$info_error = "See väli on kohustuslik";
		}else{
			$info = cleanInput($_POST["info"]);
		}

		if(	$bar_error == "" && $cocktails_error == "" && $service_error == "" && $interior_error == "" && $prices_error == "" && $score_error == "" && $info_error == ""){
			#Sending info to functions.php
			$msg = insertreview($bar, $cocktails, $service, $interior, $prices, $score, $info);
			if($msg !=""){
				$bar = "";
				$cocktails = "";
				$service = "";
				$interior = "";
				$prices = "";
				$score = "";
				$info = "";
				echo $msg;
			}
		}
    }
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }	
?>

	<h2>Arvustuse sisestamine</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		<label for="bar" >Asutuse nimi</label><br>
		<input id="bar" name="bar" type="text" value="<?=$bar; ?>"> <?=$bar_error; ?><br><br>
		
		<label for="cocktails" >Degusteeritud kokteilid</label><br>
		<input id="cocktails" name="cocktails" type="text" value="<?=$cocktails; ?>"> <?=$cocktails_error; ?><br><br>
		
		<label for="service" >Teeninduse üldhinne</label><br>
		<input id="service" name="service" type="number" min="1" max="10" step="1" value="<?=$service; ?>"> <?=$service_error; ?><br><br> 
		
		<label for="interior" >Atmosfääri üldhinne</label><br>
		<input id="interior" name="interior" type="number" min="1" max="10" step="1" value="<?=$interior; ?>"> <?=$interior_error; ?><br><br>
		
		<label for="prices" >Hinnatase</label><br>
		<input id="prices" name="prices" type="number" min="1" max="10" step="1" value="<?=$prices; ?>"> <?=$prices_error; ?><br><br>
		
		<label for="score" >Üleüldine koondhinne</label><br>
		<input id="score" name="score" type="number" min="1" max="10" step="1" value="<?=$score; ?>"> <?=$score_error; ?><br><br>
		
		<label for="info" >Info</label><br>
		<input id="info" name="info" type="text" value="<?=$info; ?>"> <?=$info_error; ?><br><br>
				
		<input type="submit" name="create" value="Salvesta">
	</form>
	</body>
</html>
  
 <?php require_once("footer.php") ?>
 