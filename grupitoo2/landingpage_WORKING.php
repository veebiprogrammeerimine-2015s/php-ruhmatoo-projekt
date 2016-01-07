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
	$critic = "";
	$critic_error = "";
	$bar = "";
	$bar_error = "";
	
	
	if(isset($_POST["create"])){

		if ( empty($_POST["critic"])) {
			$critic_error = "See väli on kohustuslik";
		}else{
			$critic = cleanInput($_POST["critic"]);
		}
############################### LISAN LAHTREID JUURDE (html lahtrid ja tabel ise on puudu)
		if ( empty($_POST["bar"])) {
			$bar_error = "See väli on kohustuslik";
		}else{
			$bar = cleanInput($_POST["bar"]);
		}
		if ( empty($_POST["critic"])) {
			$critic_error = "See väli on kohustuslik";
		}else{
			$critic = cleanInput($_POST["critic"]);
		}
		if ( empty($_POST["critic"])) {
			$critic_error = "See väli on kohustuslik";
		}else{
			$critic = cleanInput($_POST["critic"]);
		}
		if ( empty($_POST["critic"])) {
			$critic_error = "See väli on kohustuslik";
		}else{
			$critic = cleanInput($_POST["critic"]);
		}

###############################		

		if(	$critic_error == ""){
			
			// functions.php failis käivina funktsiooni
			$msg = insertreview($critic);
			if($msg !=""){
				$critic = "";
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

 <h2>Critic</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="critic" >Critic</label><br>
	<input id="critic" name="critic" type="text" value="<?=$critic; ?>"> <?=$critic_error; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>

  
  
 <?php require_once("footer.php") ?>