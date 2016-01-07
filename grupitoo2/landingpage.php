<?php
	//kopeerime header.php sisu
	//../ naitab, et fail asub uhe kasuta vorra valjaspool
require_once("header.php");
?>



<?php
	$page_title = "Sisesta ülevaade";
	$file_name = "pandingpage.php";
?>


<?php

##################################### MAANDUMISLEHT ON HETKEL VEEL KATKI. TÖÖTAN SELLE KALLAL, ET SAADA SISESTADA ANDMEID TABELISSE JA TABELITEST INFOT KÄTTE SAADA
##################################### SISSELOGIMINE JA UUE KASUTAJA REGISTREERIMINE TÖÖTAB


	//********************ENDA***************************************

// 1) $_session["nimi"]; - serveris mingi osa mälust on eraldatud sellele kasutajale (sessioonile). Brauser kinni = sess läbi
// 2) $_cookie["nimi"]; - paned brauseri akna kinni, sess jääb ikka lahti. Avad brauseri ja oled ikka sisse logitud


	//laen funktsioonid failis
	require_once("functions.php");
	//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		//suunan login lehele
		header("Location: login.php");
		
		
	}	
	if(isset($_GET["logout"])){
		//sessdestroy kustutab kõik sessi muutujad
		session_destroy();
		header("Location: home.php");
	}

?>
<p>
Tere, <?php echo $_SESSION["user_email"]; ?> 
</p>

<!-- "<?php echo $_SESSION["user_email"]; ?>" saaks ka lühemalt "<?=$_SESSION["user_email"];?>" -->
<p>
<a href="?logout=1">Logi välja</a>
</p>


<html lang="et">
<head>
<meta charset="utf-8">
<title>Kriitiku leht</title>

</html>


<?php
######################################## TEST ENDA CRITIC SISESTUSFUNKTSIOON ###################################################

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
			
			// functions.php failis käivina funktsiooni
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
    } // create if end
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
	
	<label for="service" >Teeninduse üldhinne (1-10p)</label><br>
	<input id="service" name="service" type="number" value="<?=$service; ?>"> <?=$service_error; ?><br><br> 
	
	<label for="interior" >Atmosfääri üldhinne (1-10p)</label><br>
	<input id="interior" name="interior" type="number" value="<?=$interior; ?>"> <?=$interior_error; ?><br><br>
	
	<label for="prices" >Hinnatase (1-10p)</label><br>
	<input id="prices" name="prices" type="number" value="<?=$prices; ?>"> <?=$prices_error; ?><br><br>
	
	<label for="score" >Üleüldine koondhinne (1-10p)</label><br>
	<input id="score" name="score" type="number" value="<?=$score; ?>"> <?=$score_error; ?><br><br>
	
	<label for="info" >Info</label><br>
	<input id="info" name="info" type="text" value="<?=$info; ?>"> <?=$info_error; ?><br><br>
	
	
	
	
  	<input type="submit" name="create" value="Salvesta">
  </form>

  
  
 <?php require_once("footer.php") ?>